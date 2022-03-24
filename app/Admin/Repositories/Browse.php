<?php

namespace App\Admin\Repositories;

use App\Models\Browse as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Browse extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
