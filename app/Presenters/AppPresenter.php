<?php namespace App\Presenters;

use Route;
/**
 * Class RbacPresenter
 *
 * @package namespace App\Presenters;
 */
class AppPresenter
{

    /**
     * Set the menu to active by current
     * @param null $name
     * @return string
     */
    public function activeMenuByRoute($names = [])
    {
        $currentRouteName = Route::currentRouteName();
        $routeSections = explode('.', $currentRouteName);

        foreach ($names as $name ) {
            if(isset($routeSections[0]) && $routeSections[0] !== $name) {
                continue;
            }else{
                return 'am-active';
            }
        }

        return '';
    }

    /*根据路由显示*/
    public function showRoute($names)
    {
        $currentRouteName = Route::currentRouteName();
        $routeSections = explode('.', $currentRouteName);
        foreach ($names as $name ) {
            if($routeSections[0] !== $name || $currentRouteName == 'item.index' || $currentRouteName == 'user.index') {
                continue;
            }else{
                return true;
            }
        }
        return false;
    }

}
