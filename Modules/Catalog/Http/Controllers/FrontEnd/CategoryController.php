<?php

namespace Modules\Catalog\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vendor\Repositories\FrontEnd\VendorRepository as Vendor;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;
use Modules\Catalog\Repositories\FrontEnd\CategoryRepository as Category;
use Modules\Tags\Repositories\FrontEnd\TagsRepository as Tags;

class CategoryController extends Controller
{
    protected $vendor;
    protected $product;
    protected $category;
    protected $tags;

    function __construct(Vendor $vendor, Product $product, Category $category, Tags $tags)
    {
        $this->product = $product;
        $this->vendor = $vendor;
        $this->category = $category;
        $this->tags = $tags;
    }

    public function index($slug)
    {
        dd('Coming Soon !!');
    }

    public function productsCategory(Request $request, $slug = null)
    {
        if ($slug == null) {
            $category = null;
        } else {
            $category = $this->category->findBySlug($slug);

            if (!$category)
                abort(404);
        }

        $products = $this->product->getProductsByCategory($request, $category, ["tags", "variants"]);

        ### automatically append query string to pagination links
        $querystringArray = [];
        $querystringArray['s'] = $request->s;
        $querystringArray['categories'] = $request->categories;
        $querystringArray['tags'] = $request->tags;
        $querystringArray['price_from'] = $request->price_from;
        $querystringArray['price_to'] = $request->price_to;
        $products->appends($querystringArray);

        $tags = $this->tags->getAllActive();
        $categories = $this->category->getAllActive($order = 'sort', $sort = 'asc');

//        dd($products->toArray());
//        dd($category->toArray(), $products->toArray(), $tags->toArray());

        return view('catalog::frontend.categories.category-products',
            compact('category', 'products', 'tags', 'categories')
        );
    }


}
