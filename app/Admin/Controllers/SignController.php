<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Sign;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class SignController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Sign(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('member_id');
            $grid->column('sign_day');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });

            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableBatchActions();
        });
    }
}
