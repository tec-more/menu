<?php namespace Tukecx\Base\Menu\Providers;

use Illuminate\Support\ServiceProvider;
use Tukecx\Base\Menu\Repositories\Contracts\MenuRepositoryContract;
use Tukecx\Base\Menu\Repositories\MenuRepository;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'Tukecx\Base\Menu';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function booted()
    {
        /**
         * Register to dashboard menu
         */
        \DashboardMenu::registerItem([
            'id' => 'tukecx-menu',
            'priority' => 20,
            'parent_id' => null,
            'heading' => null,
            'title' => '菜单',
            'font_icon' => 'fa fa-bars',
            'link' => route('admin::menus.index.get'),
            'css_class' => null,
            'permissions' => ['view-menus']
        ]);

        cms_settings()
            ->addSettingField('main_menu', [
                'group' => 'basic',
                'type' => 'select',
                'priority' => 3,
                'label' => '主菜单',
                'helper' => '我们站点的主菜单'
            ], function () {
                /**
                 * @var MenuRepository $menus
                 */
                $menus = app(MenuRepositoryContract::class);
                $menus = $menus->where('status', '=', 'activated')
                    ->get();

                $menusArr = [];

                foreach ($menus as $menu) {
                    $menusArr[$menu->slug] = $menu->title;
                }

                return [
                    'main_menu',
                    $menusArr,
                    get_settings('main_menu'),
                    ['class' => 'form-control']
                ];
            });
    }
}
