<?php

namespace Fully\Composers;

use Fully\Repositories\Banner\BannerInterface;

/**
 * Class BannerComposer.
 *
 * @author
 */
class BannerComposer
{
    /**
     * @var \Fully\Repositories\Banner\BannerInterface
     */
    protected $banner;

    /**
     * BannerComposer constructor.
     * @param BannerComposer $banner
     */
    public function __construct(BannerInterface $banner)
    {
        $this->banner = $banner;
    }

    /**
     * @param $view
     */
    public function compose($view)
    {
        $timeCurrent = date("Y-m-d H:i:s");
        $banners = $this->banner->getBannerByPosition($timeCurrent);
        $view->with('banners', $banners);
    }
}
