<?php

namespace Modules\Catalog\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Catalog\Http\Requests\Vendor\ProductRequest;
use Modules\Catalog\Transformers\Vendor\ProductResource;
use Modules\Catalog\Repositories\Vendor\ProductRepository as Product;
use Modules\Catalog\Repositories\Dashboard\CategoryRepository as Category;

class ProductController extends Controller
{
    protected $product;
    protected $category;

    function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    public function index()
    {
        return view('catalog::vendor.products.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->product->QueryTable($request));
        $datatable['data'] = ProductResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function create()
    {
        return view('catalog::vendor.products.create');
    }

    public function store(ProductRequest $request)
    {
        try {
            $create = $this->product->create($request);

            if ($create) {
                return Response()->json([true, __('apps::vendor.general.message_create_success')]);
            }

            return Response()->json([false, __('apps::vendor.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('catalog::vendor.products.show');
    }

    public function edit(Request $request, $id)
    {
        $product = $this->product->findById($id);
        if (!$product)
            abort(404);

        $product->load(["variantValues", "variants.productValues.optionValue.option", "categories"]);
        $currentVaration = $product->variantValues->sortBy("option_value_id")->groupBy("product_variant_id")->pluck("*.option_value_id")->toArray();

        $request->request->add(['section_id' => $product->vendor->section_id ?? null]);
        return view('catalog::vendor.products.edit', compact('product', "currentVaration"));
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $update = $this->product->update($request, $id);

            if ($update) {
                return Response()->json([true, __('apps::vendor.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::vendor.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->product->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::vendor.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::vendor.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            if (empty($request['ids']))
                return Response()->json([false, __('apps::dashboard.general.select_at_least_one_item')]);

            $deleteSelected = $this->product->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::vendor.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::vendor.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deleteProductImage(Request $request)
    {
        try {
            $id = $request->id;
            $prdImg = $this->product->findProductImgById($id);

            if ($prdImg) {
                $delete = $this->product->deleteProductImg($id);
                if ($delete)
                    return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
                else
                    return Response()->json([false, __('apps::dashboard.general.message_error')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function getProductCategoriesByVendorSection(Request $request)
    {
        $product = null;
        if (!empty($request->product_id)) {
            $product = $this->product->findById($request->product_id, ['categories']);
            if (!$product)
                return response()->json(['success' => false, 'message' => __('catalog::vendor.products.alerts.product_not_found')]);
        }

        $mainCategories = $this->category->mainCategories('sort', 'asc', $request->section_id);
        $view = $request->flag == 'create' ? "catalog::vendor.tree.products.view" : "catalog::vendor.tree.products.edit";
        return view($view, compact('mainCategories', 'product'))->render();
    }
}
