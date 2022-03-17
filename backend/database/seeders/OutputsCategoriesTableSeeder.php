<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutputsCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $outputsCategories = array([
            "id" => 1,
            "category" => "Pagamentos"
        ], [
            "id" => 2,
            "category" => "Serviços"
        ], [
            "id" => 3,
            "category" => "Carro"
        ], [
            "id" => 4,
            "category" => "Transporte"
        ], [
            "id" => 5,
            "category" => "Vestuário"
        ], [
            "id" => 6,
            "category" => "Aluguel"
        ]);

        for ($i = 0; $i < sizeOf($outputsCategories); $i++) {
            DB::table('outputs_categories')->insert($outputsCategories[$i]);
        }
    }
}
