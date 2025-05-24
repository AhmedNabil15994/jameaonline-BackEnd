<?php

namespace Modules\Catalog\Repositories\Vendor;

use Illuminate\Support\Facades\File;
use Modules\Catalog\Entities\Product;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\ProductImage;
use Modules\Catalog\Entities\SearchKeyword;
use Modules\Core\Traits\CoreTrait;
use Modules\Core\Traits\SyncRelationModel;

class ProductRepository
{
    use SyncRelationModel, CoreTrait;

    protected $product;
    protected $prdImg;
    protected $imgPath;

    public function __construct(Product $product, ProductImage $prdImg)
    {
        $this->product = $product;
        $this->prdImg = $prdImg;
        $this->imgPath = public_path('uploads/products');
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $products = $this->product->whereHas('vendor', function ($query) {
            $query->whereHas('sellers', function ($q) {
                $q->where('seller_id', auth()->user()->id);
            });
        })->orderBy($order, $sort)->get();

        return $products;
    }

    public function findById($id, $with = [])
    {
        $product = $this->product->whereHas('vendor', function ($query) {
            $query->whereHas('sellers', function ($q) {
                $q->where('seller_id', auth()->user()->id);
            });
        });
        if (!empty($with)) {
            $with = array_merge($with, ['tags', 'images']);
        }
        $product = $product->with($with);
        return $product->find($id);
    }

    public function findProductImgById($id)
    {
        return $this->prdImg->find($id);
    }

    public function restoreSoftDelete($model)
    {
        $model->restore();
    }

    public function translateTable($model, $request, $action = '')
    {
        foreach (config('translatable.locales') as $k => $locale) {
            if ($action == '' || ($action == 'edit' && auth()->user()->can('edit_products_title'))) {
                $model->translateOrNew($locale)->title = $request['title'][$locale];
            }

            if ($action == '' || ($action == 'edit' && auth()->user()->can('edit_products_description'))) {
                if (!is_null($request['short_description'][$locale])) {
                    $model->translateOrNew($locale)->short_description = $request['short_description'][$locale];
                }
                if (!is_null($request['description'][$locale])) {
                    $model->translateOrNew($locale)->description = $request['description'][$locale];
                }
            }

            if (!is_null($request['seo_description'][$locale])) {
                $model->translateOrNew($locale)->seo_description = $request['seo_description'][$locale];
            }
            if (!is_null($request['seo_keywords'][$locale])) {
                $model->translateOrNew($locale)->seo_keywords = $request['seo_keywords'][$locale];
            }
        }

        $model->save();
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                // 'image' => $request->image ? path_without_domain($request->image) : url(config('setting.logo')),
                'featured' => $request->featured == 'on' ? 1 : 0,
                'status' => $request->status == 'on' ? 1 : 0,
                'price' => $request->price,
                'sku' => $request->sku,
                "shipment" => $request->shipment,
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
                $data['pending_for_approval'] = 1;
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
                'seo_description' => $request->seo_description,
                'seo_keywords' => $request->seo_keywords,
                'product_flag' => $request->product_flag ?? null,
                'preparation_time' => $request->preparation_time ?? null,
                'requirements' => $request->requirements ?? null,
                'duration_of_stay' => $request->duration_of_stay ?? null,
            ];

            if (auth()->user()->can('edit_products_qty')) {
                if ($request->manage_qty == 'limited' && $request->product_flag != 'service') {
                    $data['qty'] = $request->qty;
                } else {
                    $data['qty'] = null;
                }
            }

            if (config('setting.other.is_multi_vendors') == 1) {
                $data['vendor_id'] = $request->vendor_id;
            } else {
                $data['vendor_id'] = config('setting.default_vendor') ?? null;
            }

            if (auth()->user()->can('edit_products_price')) {
                $data['price'] = $request->price;
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
                $data['pending_for_approval'] = 1;
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

    public function QueryTable($request)
    {
        $query = $this->product->with('vendor')->whereHas('vendor.sellers', function ($query) {
            $query->where('seller_id', auth()->user()->id);
        });

        if ($request->input('search.value')) {
            $query = $query->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            })->orWhere(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
            });
        }

        $query = $this->filterDataTable($query, $request);

        return $query;
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
                    if (isset($request['_v_images'][$id])) {
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
                    $variant->productValues()->create([
                        'option_value_id' => $value2,
                        'product_id' => $model['id'],
                    ]);
                }
            }
        }
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
                    'offer_price' => $request['offer_price'] ? $request['offer_price'] : ($model->offer->offer_price ?? null),
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
}
