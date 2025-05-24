<?php

namespace Modules\Catalog\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\ProductImage;
use Hash;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\SearchKeyword;
use Modules\Core\Traits\CoreTrait;
use Modules\Core\Traits\SyncRelationModel;
use Modules\Variation\Entities\OptionValue;
use Modules\Variation\Entities\ProductVariant;

class ProductRepository
{
    use SyncRelationModel, CoreTrait;

    protected $product;
    protected $prdImg;
    protected $optionValue;
    protected $variantPrd;
    protected $imgPath;

    public function __construct(Product $product, ProductImage $prdImg, OptionValue $optionValue, ProductVariant $variantPrd)
    {
        $this->product = $product;
        $this->prdImg = $prdImg;
        $this->optionValue = $optionValue;
        $this->variantPrd = $variantPrd;
        $this->imgPath = public_path('uploads/products');
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $products = $this->product->orderBy($order, $sort)->get();
        return $products;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $products = $this->product->active()->orderBy($order, $sort)->get();
        return $products;
    }

    public function getReviewProductsCount()
    {
        return $this->product->where('pending_for_approval', false)->count();
    }

    public function findById($id)
    {
        $product = $this->product->withDeleted()->with(['tags', 'images', 'addOns'])->find($id);
        return $product;
    }

    public function findVariantProductById($id)
    {
        return $this->variantPrd->with('productValues')->find($id);
    }

    public function findProductImgById($id)
    {
        return $this->prdImg->find($id);
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = [
                //'image' => $request->image ? path_without_domain($request->image) : url(config('setting.logo')),
                'status' => $request->status == 'on' ? 1 : 0,
                'featured' => $request->featured == 'on' ? 1 : 0,
                'price' => $request->price,
                'sku' => $request->sku,
                "shipment" => $request->shipment,
                'sort' => $request->sort ?? 0,
                'title' => $request->title,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'seo_description' => $request->seo_description,
                'seo_keywords' => $request->seo_keywords,
                'product_flag' => $request->product_flag ?? null,
                'preparation_time' => $request->preparation_time ?? null,
                'requirements' => $request->requirements ?? null,
                'duration_of_stay' => $request->duration_of_stay ?? null,
            ];

            if ($request->manage_qty == 'limited' && $request->product_flag != 'service') {
                $data['qty'] = $request->qty;
            } else {
                $data['qty'] = null;
            }

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage($this->imgPath, $request->image);
                $data['image'] = 'uploads/products/' . $imgName;
            } else {
                $data['image'] = url(config('setting.logo'));
            }

            if (config('setting.other.is_multi_vendors') == 1) {
                $data['vendor_id'] = $request->vendor_id;
            } else {
                $data['vendor_id'] = config('setting.default_vendor') ?? null;
            }

            if (auth()->user()->can('pending_products_for_approval')) {
                $data['pending_for_approval'] = $request->pending_for_approval == 'on' ? 1 : 0;
            }

            $product = $this->product->create($data);

            $product->categories()->sync(int_to_array($request->category_id));
            if ($request->offer_status != "on") {
                $this->productVariants($product, $request);
            }

            $this->productOffer($product, $request);

            // Add Product Images
            if (isset($request->images) && !empty($request->images)) {
                $imgPath = public_path('uploads/products');

                foreach ($request->images as $k => $img) {
                    $imgName = $img->hashName();
                    $img->move($imgPath, $imgName);

                    $product->images()->create([
                        'image' => $imgName,
                    ]);
                }
            }

            // Add Product Tags
            if (isset($request->tags) && !empty($request->tags)) {
                $tagsCollection = collect($request->tags);
                $filteredTags = $tagsCollection->filter(function ($value, $key) {
                    return $value != null && $value != '';
                });
                $tags = $filteredTags->all();

                $product->tags()->sync($tags);
            }

            // Add Product search keywords
            if (isset($request->search_keywords) && !empty($request->search_keywords)) {
                $searchKeywordsCollection = collect($request->search_keywords);
                $filteredSearchKeywords = $searchKeywordsCollection->filter(function ($value, $key) {
                    return $value != null && $value != '';
                });
                $searchKeywords = $filteredSearchKeywords->all();

                $ids = [];
                foreach ($searchKeywords as $searchKeyword) {
                    $keyword = SearchKeyword::firstOrCreate(
                        ['id' => $searchKeyword],
                        ['title' => $searchKeyword, 'status' => 1]
                    );
                    if ($keyword) {
                        $ids[] = $keyword->id;
                    }
                }
                $product->searchKeywords()->sync($ids);
            }

            if ($request->home_categories && !empty($request->home_categories)) {
                $homeCategoriesCollection = collect($request->home_categories);
                $filteredHomeCategoriesCollection = $homeCategoriesCollection->filter(function ($value, $key) {
                    return $value != null && $value != '';
                });
                $home_categories = $filteredHomeCategoriesCollection->all();

                $product->homeCategories()->sync($home_categories);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        $product = $this->findById($id);
        if (!$product)
            return false;

        $restore = $request->restore ? $this->restoreSoftDelete($product) : null;

        if (isset($request->images) && !empty($request->images)) {
            $sync = $this->syncRelation($product, 'images', $request->images);
        }

        try {
            $data = [
                'featured' => $request->featured == 'on' ? 1 : 0,
                'status' => $request->status == 'on' ? 1 : 0,
                'sku' => $request->sku,
                "shipment" => $request->shipment,
                'sort' => $request->sort ?? 0,
                'seo_description' => $request->seo_description,
                'seo_keywords' => $request->seo_keywords,
                'product_flag' => $request->product_flag ?? null,
                'preparation_time' => $request->preparation_time ?? null,
                'requirements' => $request->requirements ?? null,
                'duration_of_stay' => $request->duration_of_stay ?? null,
            ];

            if (config('setting.other.is_multi_vendors') == 1) {
                $data['vendor_id'] = $request->vendor_id;
            } else {
                $data['vendor_id'] = config('setting.default_vendor') ?? null;
            }

            if (auth()->user()->can('edit_products_price')) {
                $data['price'] = $request->price;
            }

            if (auth()->user()->can('edit_products_qty')) {
                if ($request->manage_qty == 'limited' && $request->product_flag != 'service') {
                    $data['qty'] = $request->qty;
                } else {
                    $data['qty'] = null;
                }
            }

            if (auth()->user()->can('edit_products_image')) {
                if ($request->image) {
                    File::delete($product->image); ### Delete old image
                    $imgName = $this->uploadImage($this->imgPath, $request->image);
                    $data['image'] = 'uploads/products/' . $imgName;
                } else {
                    $data['image'] = $product->image;
                }
            }

            if (auth()->user()->can('pending_products_for_approval')) {
                $data['pending_for_approval'] = $request->pending_for_approval == 'on' ? 1 : 0;
            }


            if (auth()->user()->can('edit_products_title')) {
                $data["title"] = $request->title;
            }

            if (auth()->user()->can('edit_products_description')) {
                $data["description"] = $request->description;
                $data["short_description"] = $request->short_description;
            }

            $product->update($data);



            if (auth()->user()->can('edit_products_category')) {
                $product->categories()->sync(int_to_array($request->category_id));
            }

            if ($request->offer_status == "on") {
                $product->variants()->delete();
            } else {
                $this->productVariants($product, $request);
            }

            if (auth()->user()->can('edit_products_price')) {
                $this->productOffer($product, $request);
            }

            if (auth()->user()->can('edit_products_gallery')) {
                // Create Or Update Product Images
                if (isset($request->images) && !empty($request->images)) {
                    $imgPath = public_path('uploads/products');

                    // Update Old Images
                    if (isset($sync['updated']) && !empty($sync['updated'])) {
                        foreach ($sync['updated'] as $k => $id) {
                            $oldImgObj = $product->images()->find($id);
                            File::delete('uploads/products/' . $oldImgObj->image); ### Delete old image

                            $img = $request->images[$id];
                            $imgName = $img->hashName();
                            $img->move($imgPath, $imgName);

                            $oldImgObj->update([
                                'image' => $imgName,
                            ]);
                        }
                    }

                    // Add New Images
                    foreach ($request->images as $k => $img) {
                        if (!in_array($k, $sync['updated'])) {
                            $imgName = $img->hashName();
                            $img->move($imgPath, $imgName);

                            $product->images()->create([
                                'image' => $imgName,
                            ]);
                        }
                    }
                }
            }

            // Update Product Tags
            if (isset($request->tags) && !empty($request->tags)) {
                $tagsCollection = collect($request->tags);
                $filteredTags = $tagsCollection->filter(function ($value, $key) {
                    return $value != null && $value != '';
                });
                $tags = $filteredTags->all();

                $product->tags()->sync($tags);
            }

            // Add Product search keywords
            if (isset($request->search_keywords) && !empty($request->search_keywords)) {
                $searchKeywordsCollection = collect($request->search_keywords);
                $filteredSearchKeywords = $searchKeywordsCollection->filter(function ($value, $key) {
                    return $value != null && $value != '';
                });
                $searchKeywords = $filteredSearchKeywords->all();

                $ids = [];
                foreach ($searchKeywords as $searchKeyword) {
                    $keyword = SearchKeyword::firstOrCreate(
                        ['id' => $searchKeyword],
                        ['title' => $searchKeyword, 'status' => 1]
                    );
                    if ($keyword) {
                        $ids[] = $keyword->id;
                    }
                }
                $product->searchKeywords()->sync($ids);
            }

            if ($request->home_categories && !empty($request->home_categories)) {
                $homeCategoriesCollection = collect($request->home_categories);
                $filteredHomeCategoriesCollection = $homeCategoriesCollection->filter(function ($value, $key) {
                    return $value != null && $value != '';
                });
                $home_categories = $filteredHomeCategoriesCollection->all();
                $product->homeCategories()->sync($home_categories);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function approveProduct($request, $id)
    {
        DB::beginTransaction();
        $product = $this->findById($id);

        try {
            $data = [];
            if (auth()->user()->can('review_products')) {
                $data['pending_for_approval'] = $request->pending_for_approval == 'on' ? true : false;
                $product->update($data);
            } else {
                return false;
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelete($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);
            if ($model) {
                File::delete($model->image);
            } ### Delete old image

            if ($model->trashed()) :
                $model->forceDelete();
            else :
                $model->delete();
            endif;

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {
            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteProductImg($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findProductImgById($id);

            if ($model) {
                File::delete('uploads/products/' . $model->image); ### Delete old image
                $model->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->product->with(['vendor', 'categories']);
        $query = $query->approved();

        $query->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
            });

            $query->orWhereHas('categories', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search.value') . '%');
            });
        });

        return $this->filterDataTable($query, $request);
    }

    public function reviewProductsQueryTable($request)
    {
        $query = $this->product->with(['vendor']);
        $query = $query->notApproved();

        $query->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
            });
        });

        return $this->filterDataTable($query, $request);
    }

    public function filterDataTable($query, $request)
    {
        // Search Categories by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '0') {
            $query->unactive();
        }

        if (isset($request['req']['vendor']) && !empty($request['req']['vendor'])) {
            $query->where('vendor_id', $request['req']['vendor']);
        }

        if (isset($request['req']['categories']) && $request['req']['categories'] != '') {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->where('product_categories.category_id', $request['req']['categories']);
            });
        }

        if (isset($request['req']['product_flag']) && !empty($request['req']['product_flag']))
            $query->where('product_flag', $request['req']['product_flag']);

        return $query;
    }

    public function productVariants($model, $request)
    {
        $oldValues = isset($request['variants']['_old']) ? $request['variants']['_old'] : [];

        $sync = $this->syncRelation($model, 'variants', $oldValues);

        if ($sync['deleted']) {
            $model->variants()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                foreach ($request['upateds_option_values_id'] as $key => $varianteId) {
                    $variation = $model->variants()->find($id);

                    $data = [
                        'sku' => $request['_variation_sku'][$id],
                        'price' => $request['_variation_price'][$id],
                        'status' => isset($request['_variation_status'][$id]) && $request['_variation_status'][$id] == 'on' ? 1 : 0,
                        'qty' => $request['_variation_qty'][$id],
                        "shipment" => isset($request["_vshipment"][$id]) ? $request["_vshipment"][$id] : null,
                        //                        'image' => $request['_v_images'][$id] ? path_without_domain($request['_v_images'][$id]) : $model->image
                    ];

                    if (!is_null($request['_v_images']) && isset($request['_v_images'][$id])) {
                        $imgName = $this->uploadVariantImage($request['_v_images'][$id]);
                        $data['image'] = 'uploads/products/' . $imgName;
                    }

                    $variation->update($data);

                    if (isset($request["_v_offers"][$id])) {
                        $this->variationOffer($variation, $request["_v_offers"][$id]);
                    }
                }
            }
        }

        $selectedOptions = [];

        if ($request['option_values_id']) {
            foreach ($request['option_values_id'] as $key => $value) {

                // dd($request->all(), $key);

                $data = [
                    'sku' => $request['variation_sku'][$key],
                    'price' => $request['variation_price'][$key],
                    'status' => isset($request['variation_status'][$key]) && $request['variation_status'][$key] == 'on' ? 1 : 0,
                    'qty' => $request['variation_qty'][$key],
                    "shipment" => isset($request["vshipment"][$key]) ? $request["vshipment"][$key] : null,
                    //                    'image' => $request['v_images'][$key] ? path_without_domain($request['v_images'][$key]) : $model->image
                ];

                if (!is_null($request['v_images']) && isset($request['v_images'][$key])) {
                    $imgName = $this->uploadVariantImage($request['v_images'][$key]);
                    $data['image'] = 'uploads/products/' . $imgName;
                } else {
                    $data['image'] = $model->image;
                }

                $variant = $model->variants()->create($data);

                if (isset($request["v_offers"][$key])) {
                    $this->variationOffer($variant, $request["v_offers"][$key]);
                }

                foreach ($value as $key2 => $value2) {
                    $optVal = $this->optionValue->find($value2);
                    if ($optVal) {
                        if (!in_array($optVal->option_id, $selectedOptions)) {
                            array_push($selectedOptions, $optVal->option_id);
                        }
                    }

                    $option = $model->options()->updateOrCreate([
                        'option_id' => $optVal->option_id,
                        'product_id' => $model['id'],
                    ]);

                    $variant->productValues()->create([
                        'product_option_id' => $option['id'],
                        'option_value_id' => $value2,
                        'product_id' => $model['id'],
                    ]);
                }
            }
        }

        /*if (count($selectedOptions) > 0) {
            foreach ($selectedOptions as $option_id) {
                $option = $model->options()->updateOrCreate([
                    'option_id' => $option_id,
                    'product_id' => $model['id'],
                ]);
            }
        }*/

        /*if (count($selectedOptions) > 0) {
            $model->productOptions()->sync($selectedOptions);
        }*/
    }

    public function productOffer($model, $request)
    {
        if (isset($request['offer_status']) && $request['offer_status'] == 'on') {
            $data = [
                'status' => ($request['offer_status'] == 'on') ? true : false,
                // 'offer_price' => $request['offer_price'] ? $request['offer_price'] : $model->offer->offer_price,
                /* 'start_at' => $request['start_at'] ? $request['start_at'] : $model->offer->start_at,
                'end_at' => $request['end_at'] ? $request['end_at'] : $model->offer->end_at, */
                'start_at' => $request['start_at'] ?? null,
                'end_at' => $request['end_at'] ?? null,
            ];

            if ($request['offer_type'] == 'amount' && !is_null($request['offer_price'])) {
                $data['offer_price'] = $request['offer_price'];
                $data['percentage'] = null;
            } elseif ($request['offer_type'] == 'percentage' && !is_null($request['offer_percentage'])) {
                $data['offer_price'] = null;
                $data['percentage'] = $request['offer_percentage'];
            } else {
                $data['offer_price'] = null;
                $data['percentage'] = null;
            }

            $model->offer()->updateOrCreate(['product_id' => $model->id], $data);
        } else {
            if ($model->offer) {
                $model->offer()->delete();
            }
        }
    }

    public function variationOffer($model, $request)
    {
        if (isset($request['status']) && $request['status'] == 'on') {
            $model->offer()->updateOrCreate(
                ['product_variant_id' => $model->id],
                [
                    'status' => ($request['status'] == 'on') ? true : false,
                    'offer_price' => $request['offer_price'] ? $request['offer_price'] : $model->offer->offer_price,
                    /* 'start_at' => $request['start_at'] ? $request['start_at'] : $model->offer->start_at,
                    'end_at' => $request['end_at'] ? $request['end_at'] : $model->offer->end_at, */
                    'start_at' => $request['start_at'] ?? null,
                    'end_at' => $request['end_at'] ?? null,
                ]
            );
        } else {
            if ($model->offer) {
                $model->offer()->delete();
            }
        }
    }

    public function getProductDetailsById($id)
    {
        $product = $this->product->query();

        $product = $product->with([
            'categories',
            'vendor',
            'tags',
            'images',
            'offer',
            'variants' => function ($q) {
                $q->with(['offer', 'productValues' => function ($q) {
                    $q->with(['productOption.option', 'optionValue']);
                }]);
            },
            'addOns',
        ]);

        $product = $product->find($id);
        return $product;
    }
}
