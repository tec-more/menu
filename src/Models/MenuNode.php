<?php namespace Tukecx\Base\Menu\Models;

use Tukecx\Base\Menu\Models\Contracts\MenuNodeModelContract;
use Tukecx\Base\Core\Models\EloquentBase as BaseModel;

class MenuNode extends BaseModel implements MenuNodeModelContract
{
    protected $table = 'menu_nodes';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public $timestamps = true;

    protected $relatedModelInfo = [];

    /**
     * @param $value
     * @return mixed|string
     */
    public function getTitleAttribute($value)
    {
        if ($value) {
            return $value;
        }
        if (!$this->resolveRelatedModel()) {
            return '';
        }

        return array_get($this->relatedModelInfo, 'model_title');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getUrlAttribute($value)
    {
        if (!$this->resolveRelatedModel()) {
            return $value;
        }

        return array_get($this->relatedModelInfo, 'url');
    }

    private function resolveRelatedModel()
    {
        if ($this->type === 'custom-link') {
            return null;
        }
        $this->relatedModelInfo = menus_management()->getObjectInfoByType($this->type, $this->related_id);

        return $this->relatedModelInfo;
    }
}
