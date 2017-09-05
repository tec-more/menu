<?php namespace Tukecx\Base\Menu\Providers;

use Illuminate\Support\ServiceProvider;
use Tukecx\Base\Menu\Models\Menu;
use Tukecx\Base\Menu\Models\MenuNode;
use Tukecx\Base\Menu\Repositories\Contracts\MenuNodeRepositoryContract;
use Tukecx\Base\Menu\Repositories\Contracts\MenuRepositoryContract;
use Tukecx\Base\Menu\Repositories\MenuNodeRepository;
use Tukecx\Base\Menu\Repositories\MenuNodeRepositoryCacheDecorator;
use Tukecx\Base\Menu\Repositories\MenuRepository;
use Tukecx\Base\Menu\Repositories\MenuRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $module = 'Tukecx\Base\Menu';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MenuRepositoryContract::class, function () {
            $repository = new MenuRepository(new Menu());

            if (config('tukecx-caching.repository.enabled')) {
                return new MenuRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
        $this->app->bind(MenuNodeRepositoryContract::class, function () {
            $repository = new MenuNodeRepository(new MenuNode());

            if (config('tukecx-caching.repository.enabled')) {
                return new MenuNodeRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
