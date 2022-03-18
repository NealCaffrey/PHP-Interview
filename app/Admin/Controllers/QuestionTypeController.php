<?php
/**
 * Created by PhpStorm
 * User: Neal Caffrey
 * Date: 3/18/2022
 * Time: 2:40 PM
 */

namespace App\Admin\Controllers;


use App\Models\QuestionType;
use Dcat\Admin\Http\Controllers\AdminController;

class QuestionTypeController extends AdminController
{
    public function typeList()
    {
        return QuestionType::all(['id', 'name as text']);
    }
}
