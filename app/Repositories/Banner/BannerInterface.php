<?php

namespace Fully\Repositories\Banner;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface BannerInterface.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
interface BannerInterface extends RepositoryInterface {

    public function togglePublish($id);

    public function searchBannersByName($searchName);

    public function getBannerByPosition($timeCurrent);
}
