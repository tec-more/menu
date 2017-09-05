<?php namespace Tukecx\Base\Menu\Http\DataTables;

use Tukecx\Base\Core\Http\DataTables\AbstractDataTables;
use Tukecx\Base\Menu\Models\Menu;

class MenusListDataTable extends AbstractDataTables
{
    protected $model;

    public function __construct()
    {
        $this->model = Menu::select('id', 'created_at', 'title', 'slug', 'status');

        parent::__construct();
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->setAjaxUrl(route('admin::menus.index.post'), 'POST');

        $this
            ->addHeading('title', '标题', '25%')
            ->addHeading('slug', 'Alias', '25%')
            ->addHeading('status', '状态', '15%')
            ->addHeading('created_at', '创建时间', '15%')
            ->addHeading('actions', '动作', '20%');

        $this->setColumns([
            ['data' => 'title', 'name' => 'title'],
            ['data' => 'slug', 'name' => 'slug'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ]);

        return $this->view();
    }

    /**
     * @return $this
     */
    protected function fetch()
    {
        $this->fetch = datatable()->of($this->model)
            ->editColumn('status', function ($item) {
                return html()->label($item->status, $item->status);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('admin::menus.update-status.post', ['id' => $item->id, 'status' => 'activated']);
                $disableLink = route('admin::menus.update-status.post', ['id' => $item->id, 'status' => 'disabled']);
                $deleteLink = route('admin::menus.delete.delete', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::menus.edit.get', ['id' => $item->id]), '编辑', ['class' => 'btn btn-sm btn-outline green']);

                $activeBtn = ($item->status != 'activated') ? form()->button('激活', [
                    'title' => 'Active this item',
                    'data-ajax' => $activeLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                    'type' => 'button',
                ]) : '';

                $disableBtn = ($item->status != 'disabled') ? form()->button('禁止', [
                    'title' => 'Disable this item',
                    'data-ajax' => $disableLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
                    'type' => 'button',
                ]) : '';

                $deleteBtn = form()->button('删除', [
                    'title' => 'Delete this item',
                    'data-ajax' => $deleteLink,
                    'data-method' => 'DELETE',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                    'type' => 'button',
                ]);

                return $editBtn . $activeBtn . $disableBtn . $deleteBtn;
            });

        return $this;
    }
}
