<?php

namespace Modules\Catalog\ViewComposers\Vendor;

use Modules\Catalog\Repositories\Dashboard\CategoryRepository as Category;
use Illuminate\View\View;
use Cache;

class CategoryComposer
{
    public $categories = [];

    public function __construct(Category $category)
    {
        $this->categories =  $category->mainCategories('sort', 'asc', request()->section_id);
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('mainCategories', $this->categories);
    }
}
