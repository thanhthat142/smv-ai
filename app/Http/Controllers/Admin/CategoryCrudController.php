<?php

namespace App\Http\Controllers\Admin;

use App\Helpers;
use App\Http\Requests\CategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings(trans('admin.category'), trans('admin.category'));
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id')->label('#ID');
        CRUD::column('name')->label(trans('admin.name'));
        CRUD::column('slug')->label(trans('admin.seo_url'));
        CRUD::addColumn(['name' => 'parent', 'type' => 'relationship', 'label' => trans('admin.parent_category')]);
        CRUD::column('desc')->type('textarea')->label(trans('admin.description'));
        CRUD::column('keywords')->type('textarea')->label(trans('admin.description'));
        CRUD::column('order')->type('number')->label(trans('admin.order'));
        CRUD::column('status')->type('select_from_array')->options(Helpers::GENERAL_STATUSES)->label(trans('admin.status'));
        CRUD::column('image')->type('image')->label(trans('admin.category_image'))->disk('uploads');
        CRUD::column('is_news')->type('boolean')->label(trans('admin.is_news'));
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CategoryRequest::class);
        CRUD::field('name')->label(trans('admin.name'));
        //CRUD::field('banner')->type('browse')->label('Banner');
        CRUD::field('desc')->type('textarea')->label(trans('admin.description'));
        CRUD::field('keywords')->type('textarea')->label(trans('admin.keywords'));
        CRUD::field('order')->type('number')
            ->label(trans('admin.order'))
            ->hint(trans('admin.cate_order_hint'));

        CRUD::addField([
            'name' => 'parent_id',
            'entity' => 'parent',
            'attribute' => 'name',
            'model' => 'App\Models\Category',
            'type' => 'select2',
            'label' => trans('admin.parent_category'),
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }), //  you can use this to filter the results show in the select
        ]);
        CRUD::field('status')
            ->type('select_from_array')
            ->options(Helpers::GENERAL_STATUSES)
            ->label(trans('admin.status'));
        CRUD::addField(['name' => 'image', 'type' => 'upload', 'label' => trans('admin.category_image'), 'withFiles' => ['disk' => 'uploads']]);
        CRUD::field('is_news')->type('boolean')->label(trans('admin.is_news'));
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
