<?php namespace Tukecx\Base\Menu\Facades;

use Illuminate\Support\Facades\Facade;

class DashboardMenuFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Tukecx\Base\Menu\Support\DashboardMenu::class;
    }
}
