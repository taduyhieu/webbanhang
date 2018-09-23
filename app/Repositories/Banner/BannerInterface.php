<?php

namespace Fully\Repositories\Banner;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface BannerInterface.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
interface BannerInterface extends RepositoryInterface {

    public function togglePublish($id);

    public function searchBannersByName($searchName);

    public function getBannerByPosition($timeCurrent);
}
