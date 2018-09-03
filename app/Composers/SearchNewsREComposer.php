<?php

namespace Fully\Composers;
use Fully\Models\City;
use Fully\Repositories\CategoryRealestale\CategoryRealestaleInterface;

/**
 * Class SearchNewsREComposer.
 *
 * @author
 */
class SearchNewsREComposer
{
    /**
     * @var \Fully\Repositories\CategoryRealestale\CategoryRealestaleInterface;
     */
    protected $cateNewsRE;

    /**
     * NewsComposer constructor.
     * @param CategoryRealestaleInterface $cateNewsRE
     */
    public function __construct(CategoryRealestaleInterface $cateNewsRE)
    {
        $this->cateNewsRE = $cateNewsRE;
    }

    /**
     * @param $view
     */
    public function compose($view)
    {
        $newsCate = $this->cateNewsRE->getCategoryRealestaleLimit();
        $catNeedHire = $this->cateNewsRE->getCategoryRealestaleNeedHire();
        $catHire = $this->cateNewsRE->getCategoryRealestaleHire();
        $listCity = City::select('id', 'name')->get();
        
        $view->with('newsCate', $newsCate)->with('listCity', $listCity)->with('catNeedHire', $catNeedHire)->with('catHire', $catHire);
    }
}
