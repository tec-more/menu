<?php namespace Tukecx\Base\Menu\Models;

use Tukecx\Base\Menu\Models\Contracts\MenuModelContract;
use Tukecx\Base\Core\Models\EloquentBase as BaseModel;

class Menu extends BaseModel implements MenuModelContract
{
    protected $table = 'menus';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public $timestamps = true;
}
