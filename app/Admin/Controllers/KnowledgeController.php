<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Knowledge;
use App\Models\Category;
use App\Models\QuestionType;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class KnowledgeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Knowledge(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('category_id', '分类')->display(function ($categoryId) {
                return Category::find($categoryId)->category_name;
            });
            $grid->column('question', '问题');
            $grid->column('sort', '排序')->sortable();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('category_id');
            });

            $grid->model()->orderByDesc('sort');
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Knowledge(), function (Show $show) {
            $show->field('id');
            $show->field('category_id');
            $show->field('question');
            $show->field('answer');
            $show->field('sort');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Knowledge(), function (Form $form) {
            $form->display('id');
            $form->select('category_id')
                ->options('/api/category_list')
                ->rules('required');

            $form->text('question')->rules('required');
            $form->number('sort')->rules('required');
            $form->markdown('answer')->rules('required');

            $form->display('created_at');
            $form->display('updated_at');

            $form->submitted(function ($form) {

            });
        });
    }
}
