<?php

namespace App\Http\Controllers\Admin;

use App\Helpers;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use function Laravel\Prompts\table;

/**
 * Class PostCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PostCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;


    protected function fetchTags()
    {
        return $this->fetch([
            'model' => \App\Models\Tag::class, // required
            'searchable_attributes' => ['name', 'desc'],
            'paginate' => 10, // items to show per page
//            'query' => function($model) {
//                return $model->active();
//            } // to filter the results that are returned
        ]);
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Post::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/post');
        CRUD::setEntityNameStrings(trans('admin.post'), trans('admin.post'));
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')->label(trans('admin.name'));
        CRUD::column('desc')->label(trans('admin.description'));
        CRUD::column('author')->label(trans('admin.author'));
        CRUD::column('image')->type('image')->label(trans('admin.post_image'))->disk('public');
        CRUD::column('category')->type('relationship')->label(trans('admin.category'));
        CRUD::column('views')->type('number')->label(trans('admin.views'));
        CRUD::column('is_feature')->type('boolean')->label(trans('admin.is_feature'));

        CRUD::addColumn([
            'label'     => trans('admin.keywords'),
            'type'      => 'select_multiple',
            'name'      => 'tags',
            'entity'    => 'tags',
            'attribute' => 'name',
            'model'     => 'App\Models\Tag'
        ]);

        CRUD::addColumn([
            'name' => 'status',
            'type' => 'select_from_array',
            'options' => Helpers::GENERAL_STATUSES,
            'label' => trans('admin.status')
        ]);

        CRUD::addFilter([
            'name'  => 'category_filter',
            'type'  => 'select2',
            'label' => trans('admin.category')
        ], function () {
            return Category::where('status', true)->pluck('name', 'id')->all();
        }, function ($value) { // if the filter is active
            CRUD::addClause('where', 'category_id', $value);
        });

        CRUD::addFilter(
            [
                'name'  => 'filter_by_status',
                'type'  => 'select2',
                'label' => trans('admin.status'),
            ],
            Helpers::GENERAL_STATUSES,
            function ($value) { // if the filter is active
                CRUD::addClause('where', function($q) use($value) {
                    $q->where('status', $value);
                });
            }
        );

        CRUD::addFilter(
            [
                'type'  => 'date_range',
                'name'  => 'from_to_created_at',
                'label' => trans('admin.created_at')
            ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'created_at', '>=', $dates->from);
                $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
            }
        );

        CRUD::enableExportButtons();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PostRequest::class);
        CRUD::field('name')->label(trans('admin.name'));

        CRUD::field('author')->label(trans('admin.author'));

        CRUD::addField(['name' => 'desc', 'type' => 'textarea', 'label' => trans('admin.description')]);

        //CRUD::addField(['name' => 'keywords', 'type' => 'textarea', 'label' => trans('admin.keywords')]);
        CRUD::addField(['name' => 'image', 'type' => 'upload', 'label' => trans('admin.post_image'), 'withFiles' => true]);


        CRUD::addField([
            'type' => "select",
            'name' => 'category_id',
            'entity' => 'category',
            'model'     => "App\Models\Category",
            'label' => trans('admin.category'),
            'options'   => (function ($query) {
                return $query->whereDoesntHave('children')->orderBy('name', 'ASC')->get();
            }),
        ]);

        CRUD::addField(
            [   // CKEditor
                'name'          => 'summary',
                'label'         => trans('admin.summary'),
                'type'          => 'ckeditor',

                // optional:
                //'extra_plugins' => ['font', 'youtube', 'resize', 'maximize', 'tabletoolstoolbar', 'simplebox'],
                'options'       => [
                    'autoGrow_minHeight'   => 200,
                    'autoGrow_bottomSpace' => 50,
                    //'removePlugins'        => 'resize,maximize',
                    'extraAllowedContent' => 'iframe[*]'
                ],

            ]
        );

        CRUD::addField(
            [   // CKEditor
                'name'          => 'content',
                'label'         => trans('admin.content'),
                'type'          => 'ckeditor',

                // optional:
                //'extra_plugins' => ['font', 'youtube', 'resize', 'maximize', 'tabletoolstoolbar', 'simplebox'],
                'options'       => [
                    'autoGrow_minHeight'   => 200,
                    'autoGrow_bottomSpace' => 50,
                    //'removePlugins'        => 'resize,maximize',
                    'extraAllowedContent' => 'iframe[*]'
                ],

            ]
        );


        CRUD::addField([
            'type' => "relationship",
            'name' => 'tags', // the method on your model that defines the relationship
            'label' => trans('admin.keywords'), // the method on your model that defines the relationship
            //'ajax' => true,
            'inline_create' => [
                'entity' => 'tag',
                'force_select' => true,
            ]
        ]);

        CRUD::addField([
            'name' => 'status',
            'type' => 'select_from_array',
            'options' => Helpers::GENERAL_STATUSES,
            'label' => trans('admin.status')
        ]);

        CRUD::field('is_feature')->type('boolean')->label(trans('admin.is_feature'));

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
