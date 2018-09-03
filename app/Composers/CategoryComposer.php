<?php

namespace Fully\Composers;

use Session;
use Fully\Repositories\Category\CategoryInterface;
/**
 * Class MenuComposer.
 *
 * @author
 */
class CategoryComposer
{
    /**
     * @var \Fully\Repositories\Category\CategoryInterface
     */
    protected $category;

    /**
     * CategoryComposer constructor.
     * @param ProductInterface $products
     */
    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }

    /**
     * @param $view
     */
    public function compose($view)
    {
        $categories = $this->category->all();
        
        $view->with('categories', $categories);
    }
}
 