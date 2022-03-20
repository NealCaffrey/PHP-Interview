<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Question;
use App\Models\Category;
use App\Models\QuestionType;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class QuestionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Question(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('category_id', '分类名称')->display(function ($categoryId) {
                return Category::find($categoryId)->category_name;
            });
            $grid->column('type', '类型')->display(function ($typeId) {
                return QuestionType::find($typeId)->name;
            });
            $grid->column('question');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
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
        return Show::make($id, new Question(), function (Show $show) {
            $show->field('id');
            $show->field('category_id');
            $show->field('type');
            $show->field('question');
            $show->field('select_content');
            $show->field('answer');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Question(), function (Form $form) {
            $form->display('id');

            //分类
            $form->select('category_id')
                ->options('/api/category_list')
                ->rules('required');

            //问题
            $form->text('question')->rules('required');

            //类型
            $form->radio('type')
                ->when(1, function (Form $form) {
                    //单选
                    $form->text('select1[]', 'A')->customFormat(function ($paths) {
                        $select = json_decode($this->select_content);
                        return $select[0] ?? '';
                    });
                    $form->text('select1[]', 'B')->customFormat(function ($paths) {
                        $select = json_decode($this->select_content);
                        return $select[1] ?? '';
                    });
                    $form->text('select1[]', 'C')->customFormat(function ($paths) {
                        $select = json_decode($this->select_content);
                        return $select[2] ?? '';
                    });
                    $form->text('select1[]', 'D')->customFormat(function ($paths) {
                        $select = json_decode($this->select_content);
                        return $select[3] ?? '';
                    });
                    $form->radio('answer1', '答案')->options([
                        1 => 'A',
                        2 => 'B',
                        3 => 'C',
                        4 => 'D'
                    ])->customFormat(function ($paths) {
                        return $this->answer;
                    });
                })
                ->when(2, function (Form $form) {
                    //多选
                    $form->text('select2[]', 'A')->customFormat(function ($paths) {
                        $select = json_decode($this->select_content);
                        return $select[0] ?? '';
                    });
                    $form->text('select2[]', 'B')->customFormat(function ($paths) {
                        $select = json_decode($this->select_content);
                        return $select[1] ?? '';
                    });
                    $form->text('select3[]', 'C')->customFormat(function ($paths) {
                        $select = json_decode($this->select_content);
                        return $select[2] ?? '';
                    });
                    $form->text('select4[]', 'D')->customFormat(function ($paths) {
                        $select = json_decode($this->select_content);
                        return $select[3] ?? '';
                    });
                    $form->checkbox('answer2', '答案')->options([
                        1 => 'A',
                        2 => 'B',
                        3 => 'C',
                        4 => 'D'
                    ])->customFormat(function ($paths) {
                        return json_decode($this->answer);
                    });
                })
                ->when(3, function (Form $form) {
                    //判断
                    $form->radio('answer3', '答案')->options([
                        1 => '正确',
                        2 => '错误'
                    ])->customFormat(function ($paths) {
                        return $this->answer;
                    });
                })
                ->when(4, function (Form $form) {
                    //问答
                    $form->text('answer4', '答案')->customFormat(function ($paths) {
                        return $this->answer;
                    });
                })
                ->rules('required')
                ->options([1 => '单选题', 2 => '多选题', 3 => '判断题', 4 => '问答题']);

            //隐藏字段
            $form->hidden('select_content');
            $form->hidden('answer');

            //保存前置
            $form->saving(function (Form $form) {
                if ($form->input('type') == 1) {
                    //单选
                    $form->input('select_content', json_encode($form->input('select1')));
                    $form->input('answer', $form->input('answer1'));
                } elseif ($form->input('type') == 2) {
                    //多选
                    $form->input('select_content', json_encode($form->input('select2')));
                    $form->input('answer', json_encode($form->input('answer2')));
                } elseif ($form->input('type') == 3) {
                    $form->input('select_content', json_encode([]));
                    $form->input('answer', $form->input('answer3'));
                } elseif ($form->input('type') == 4) {
                    $form->input('select_content', json_encode([]));
                    $form->input('answer', $form->input('answer4'));
                }

                //删除字段
                $form->deleteInput('select1');
                $form->deleteInput('answer1');
                $form->deleteInput('select2');
                $form->deleteInput('answer2');
                $form->deleteInput('answer3');
                $form->deleteInput('answer4');
            });
        });
    }
}
