<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Collection;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CollectionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Collection(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('member_id');
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
