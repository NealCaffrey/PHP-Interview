<?php

namespace App\Admin\Repositories;

use App\Models\Sign as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Sign extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
