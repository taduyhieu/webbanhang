<?php

namespace Fully\Composers;

use Menu;
use Fully\Repositories\Menu\MenuInterface;
use Fully\Repositories\News\NewsInterface;
use Carbon\Carbon;
use Fully\Models\Role;

/**
 * Class MenuComposer.
 *
 * @author
 */
class MenuComposer {

    /**
     * @var \Fully\Repositories\Menu\MenuInterface
     */
    protected $menu;
    protected $news;

    /**
     * @param MenuInterface $menu
     */
    public function __construct(MenuInterface $menu, NewsInterface $news) {
        $this->menu = $menu;
        $this->news = $news;
    }

    /**
     * @param $view
     */
    public function compose($view) {
        $items = $this->menu->all();
        $menus = $this->menu->getFrontMenuHTML($items);
        $newsToday = $this->news->getNewsToday();
        $jd = cal_to_jd(CAL_GREGORIAN, date("m"), date("d"), date("Y"));
        $dayOfWeek = jddayofweek($jd, 1);
        $dateNow = Carbon::now();
        switch ($dayOfWeek) {
            case "Monday":
                $dayOfWeek = "Thứ 2";
                break;
            case "Tuesday":
                $dayOfWeek = "Thứ 3";
                break;
            case "Wednesday":
                $dayOfWeek = "Thứ 4";
                break;
            case "Thursday":
                $dayOfWeek = "Thứ 5";
                break;
            case "Friday":
                $dayOfWeek = "Thứ 6";
                break;
            case "Saturday":
                $dayOfWeek = "Thứ 7";
                break;
            case "Sunday":
                $dayOfWeek = "Chủ nhật";
                break;
            default:
                $dayOfWeek = "Thứ không xác định";
        }
        $roles = Role::take(1)->offset(1)->first();

        $view->with('menus', $menus)->with('dateNow', $dateNow)->with('dayOfWeek', $dayOfWeek)->with('items', $items)->with('newsToday', $newsToday)->with('roles', $roles);
    }

}
