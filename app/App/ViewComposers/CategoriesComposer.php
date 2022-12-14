<?php

namespace SAAS\App\ViewComposers;

use SAAS\Domain\Categories\Models\Category;
use Illuminate\View\View;

class CategoriesComposer
{
    /**
     * Holds list of categories in storage.
     *
     * @var $categories
     */
    private $categories;

    private $blog_categories;

    public function compose(View $view)
    {
        if (!$this->categories) {
            $this->categories = Category::get()->toTree();

//            $this->blog_categories = $this->categories->where('slug', 'blog')->first();
        }

        return $view->with('categories', $this->categories);
    }
}