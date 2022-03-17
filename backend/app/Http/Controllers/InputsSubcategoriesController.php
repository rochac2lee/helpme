<?php

namespace App\Http\Controllers;

use App\Models\InputsSubcategories;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InputsSubcategoriesController extends Controller
{
    public function index() {
        $inputsSubcategories = InputsSubcategories::all();

        return response(['total' => sizeof($inputsSubcategories), 'data' => $inputsSubcategories], 200);
    }

    public function show($input_category_id) {

        $inputsSubcategories = DB::select("SELECT * FROM inputs_subcategories WHERE input_category_id = $input_category_id");

        return response(['total' => sizeof($inputsSubcategories), 'data' => $inputsSubcategories], 200);
    }

    public function new(Request $request) {

        try {
            $inputsSubcategories = InputsSubcategories::create([
                "input_category_id" => $request->input_category_id,
                "subcategory" => $request->subcategory
            ]);

            return response(['status' => 'success', 'message' => 'Subcategoria para Receitas criado com sucesso!', 'data' => $inputsSubcategories], 201);
        } catch(Exception $err) {
            return response(['status' => 'error', 'message' => $err->getMessage()], 500);
        }

    }

    public function update(Request $request, $id) {

        $request = $request->all();
        if(!$inputsSubcategories = InputsSubcategories::find($id)) {

            return response(["status" => "error", "message" => "Subcategoria não encontrada!"], 500);

        } else {

            try {
                $inputsSubcategories->update($request);

                return response(['status' => 'success', 'message' => 'Subcategoria atualizada com sucesso!', 'data' => $inputsSubcategories], 201);
            } catch(Exception $err) {
                return response(['status' => 'error', 'message' => $err->getMessage()], 500);
            }

        }

    }

    public function remove(InputsSubcategories $inputsSubcategories, $id) {

        if(!$inputsSubcategories = InputsSubcategories::find($id)) {

            return response(["status" => "error", "message" => "Subcategoria não encontrada!"], 500);

        } else {

            try {
                $inputsSubcategories->delete();

                return response([ "status" => "success", "message" => "Subcategoria removida com sucesso!" ], 200);
            } catch(Exception $err) {
                return response([ "error" => "error", "message" => $err->getMessage()], 500);
            }
        }

    }
}
