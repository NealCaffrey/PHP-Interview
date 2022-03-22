<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Knowledge;

class KnowledgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Knowledge::factory(10)->create();
    }
}
