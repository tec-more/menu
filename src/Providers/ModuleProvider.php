<?php namespace Tukecx\Base\Menu\Providers;

use Illuminate\Support\ServiceProvider;
use Tukecx\Base\Menu\Facades\DashboardMenuFacade;
use Tukecx\Base\Menu\Facades\MenuManagementFacade;

class ModuleProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*Load views*/
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'tukecx-menu');
        /*Load translations*/
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'tukecx-menu');
        /*Load migrations*/
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->publishes([
            __DIR__ . '/../../resources/views' => config('view.paths')[0] . '/vendor/tukecx-menu',
        ], 'views');
        $this->publishes([
            __DIR__ . '/../../resources/lang' => base_path('resources/lang/vendor/tukecx-menu'),
        ], 'lang');
        $this->publishes([
            __DIR__ . '/../../resources/assets' => resource_path('assets'),
        ], 'tukecx-assets');
        $this->publishes([
            __DIR__ . '/../../resources/public' => public_path(),
        ], 'tukecx-public-assets');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Load helpers
        load_module_helpers(__DIR__);

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(BootstrapModuleServiceProvider::class);

        //Register related facades
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('MenuManagement', MenuManagementFacade::class);
        $loader->alias('DashboardMenu', DashboardMenuFacade::class);
    }
}
