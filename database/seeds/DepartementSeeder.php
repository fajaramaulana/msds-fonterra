<?php

use App\Models\Departement;
use Illuminate\Database\Seeder;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departement::insert([
            [
                'name' => 'MTC',
                'email' => 'mtcfontera@mail.com'
            ],
            [
                'name' => 'fsq',
                'email' => 'fsqfontera@mail.com'
            ],
            [
                'name' => 'Process',
                'email' => 'processfontera@mail.com'
            ],
            [
                'name' => 'HR',
                'email' => 'hrfontera@mail.com'
            ]
        ]);
    }
}
