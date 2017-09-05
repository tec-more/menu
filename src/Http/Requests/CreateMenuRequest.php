<?php namespace Tukecx\Base\Menu\Http\Requests;

use Tukecx\Base\Core\Http\Requests\Request;

class CreateMenuRequest extends Request
{
    public $rules = [
        'title' => 'string|max:255|required',
        'slug' => 'string|max:255|nullable',
        'status' => 'string|required|in:activated,disabled',
        'menu_structure' => 'required',
        'deleted_nodes' => 'required'
    ];
}
