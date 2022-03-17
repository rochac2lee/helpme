<?php

namespace App\Http\Controllers;

use App\Models\OutputsSubcategories;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutputsSubcategoriesController extends Controller
{
    public function index() {
        $outputsSubcategories = OutputsSubcategories::all();

        return response(['total' => sizeof($outputsSubcategories), 'data' => $outputsSubcategories], 200);
    }

    public function show($output_category_id) {
        $outputsSubcategories = DB::select("SELECT * FROM outputs_subcategories WHERE output_category_id = $output_category_id");

        return response(['total' => sizeof($outputsSubcategories), 'data' => $outputsSubcategories], 200);
    }

    public function new(Request $request) {

        try {
            $outputsSubcategories = OutputsSubcategories::create([
                "output_category_id" => $request->output_category_id,
                "subcategory" => $request->subcategory
            ]);

            return response(['status' => 'success', 'message' => 'Subcategoria para Despesas criada com sucesso!', 'data' => $outputsSubcategories], 201);
        } catch(Exception $err) {
            return response(['status' => 'error', 'message' => $err->getMessage()], 500);
        }

    }

    public function update(Request $request, $id) {

        $request = $request->all();
        if(!$outputsSubcategories = OutputsSubcategories::find($id)) {

            return response(["status" => "error", "message" => "Subcategoria não encontrada!"], 500);

        } else {

            try {
                $outputsSubcategories->update($request);

                return response(['status' => 'success', 'message' => 'Subcategoria atualizada com sucesso!', 'data' => $outputsSubcategories], 201);
            } catch(Exception $err) {
                return response(['status' => 'error', 'message' => $err->getMessage()], 500);
            }

        }

    }

    public function remove(OutputsSubcategories $outputsSubcategories, $id) {

        if(!$outputsSubcategories = OutputsSubcategories::find($id)) {

            return response(["status" => "error", "message" => "Subcategoria não encontrada!"], 500);

        } else {

            try {
                $outputsSubcategories->delete();

                return response([ "status" => "success", "message" => "Subcategoria removida com sucesso!" ], 200);
            } catch(Exception $err) {
                return response([ "error" => "error", "message" => $err->getMessage()], 500);
            }
        }

    }
}
