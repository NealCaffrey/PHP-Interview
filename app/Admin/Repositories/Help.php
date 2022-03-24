<?php

namespace App\Admin\Repositories;

use App\Models\Help as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Help extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
