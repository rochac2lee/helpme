<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InputsSubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inputsSubcategories = array([
            "input_category_id" => 1,
            "subcategory" => "Serviços"
        ], [
            "input_category_id" => 1,
            "subcategory" => "Produtos"
        ], [
            "input_category_id" => 1,
            "subcategory" => "Licenças"
        ], [
            "input_category_id" => 1,
            "subcategory" => "Outros"
        ], [
            "input_category_id" => 2,
            "subcategory" => "Rendimentos Diversos"
        ], [
            "input_category_id" => 2,
            "subcategory" => "Outros"
        ], [
            "input_category_id" => 3,
            "subcategory" => "Outros"
        ], [
            "input_category_id" => 4,
            "subcategory" => "Empréstimos"
        ], [
            "input_category_id" => 4,
            "subcategory" => "Outros"
        ]);

        for ($i = 0; $i < sizeOf($inputsSubcategories); $i++) {
            DB::table('inputs_subcategories')->insert($inputsSubcategories[$i]);
        }
    }
}
