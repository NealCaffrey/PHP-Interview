<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Point;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PointsController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Point(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('member_id');
            $grid->column('type');
            $grid->column('points');
            $grid->column('knowledge_id');
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
