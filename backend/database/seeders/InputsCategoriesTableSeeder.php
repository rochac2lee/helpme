<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InputsCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inputsCategories = array([
            "id" => 1,
            "category" => "Pagamentos"
        ], [
            "id" => 2,
            "category" => "Rendimentos"
        ], [
            "id" => 3,
            "category" => "Vendas"
        ], [
            "id" => 4,
            "category" => "Recebimentos"
        ]);

        for ($i = 0; $i < sizeOf($inputsCategories); $i++) {
            DB::table('inputs_categories')->insert($inputsCategories[$i]);
        }
    }
}
