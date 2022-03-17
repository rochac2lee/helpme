<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutputsSubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $outputsSubcategories = array([
            "output_category_id" => 1,
            "subcategory" => "Empréstimos"
        ], [
            "output_category_id" => 1,
            "subcategory" => "Presentes e Brindes"
        ], [
            "output_category_id" => 1,
            "subcategory" => "Taxas e Impostos"
        ], [
            "output_category_id" => 1,
            "subcategory" => "Outros"
        ], [
            "output_category_id" => 2,
            "subcategory" => "Internet"
        ], [
            "output_category_id" => 2,
            "subcategory" => "Servidor"
        ], [
            "output_category_id" => 2,
            "subcategory" => "Telefonia"
        ], [
            "output_category_id" => 2,
            "subcategory" => "Marketing"
        ], [
            "output_category_id" => 2,
            "subcategory" => "Outros"
        ], [
            "output_category_id" => 3,
            "subcategory" => "Manutenção"
        ], [
            "output_category_id" => 3,
            "subcategory" => "Limpeza"
        ], [
            "output_category_id" => 3,
            "subcategory" => "Combustível"
        ], [
            "output_category_id" => 3,
            "subcategory" => "IPVA"
        ], [
            "output_category_id" => 3,
            "subcategory" => "Licenciamento"
        ], [
            "output_category_id" => 3,
            "subcategory" => "Multas"
        ], [
            "output_category_id" => 3,
            "subcategory" => "Outros"
        ], [
            "output_category_id" => 4,
            "subcategory" => "Uber"
        ], [
            "output_category_id" => 4,
            "subcategory" => "99"
        ], [
            "output_category_id" => 4,
            "subcategory" => "Táxi"
        ], [
            "output_category_id" => 4,
            "subcategory" => "Outros"
        ], [
            "output_category_id" => 5,
            "subcategory" => "Uniforme"
        ], [
            "output_category_id" => 5,
            "subcategory" => "Máscara"
        ], [
            "output_category_id" => 5,
            "subcategory" => "Outros"
        ], [
            "output_category_id" => 6,
            "subcategory" => "Carro"
        ], [
            "output_category_id" => 6,
            "subcategory" => "Imóvel"
        ], [
            "output_category_id" => 6,
            "subcategory" => "Equipamentos"
        ], [
            "output_category_id" => 6,
            "subcategory" => "Móveis"
        ], [
            "output_category_id" => 6,
            "subcategory" => "Outros"
        ]);

        for ($i = 0; $i < sizeOf($outputsSubcategories); $i++) {
            DB::table('outputs_subcategories')->insert($outputsSubcategories[$i]);
        }
    }
}
