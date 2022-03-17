<?php

namespace App\Http\Controllers;

use App\Models\InputsCategories;
use Exception;
use Illuminate\Http\Request;

class InputsCategoriesController extends Controller
{
    public function index() {
        $inputsCategories = InputsCategories::all();

        return response(['total' => sizeof($inputsCategories), 'data' => $inputsCategories], 200);
    }

    public function new(Request $request) {

        try {
            $inputsCategories = InputsCategories::create([
                "category" => $request->category
            ]);

            return response(['status' => 'success', 'message' => 'Categoria para Receitas criado com sucesso!', 'data' => $inputsCategories], 201);
        } catch(Exception $err) {
            return response(['status' => 'error', 'message' => $err->getMessage()], 500);
        }

    }

    public function update(Request $request, $id) {

        $request = $request->all();
        if(!$inputsCategories = InputsCategories::find($id)) {

            return response(["status" => "error", "message" => "Categoria não encontrada!"], 500);

        } else {

            try {
                $inputsCategories->update($request);

                return response(['status' => 'success', 'message' => 'Categoria atualizada com sucesso!', 'data' => $inputsCategories], 201);
            } catch(Exception $err) {
                return response(['status' => 'error', 'message' => $err->getMessage()], 500);
            }

        }

    }

    public function remove(InputsCategories $inputsCategories, $id) {

        if(!$inputsCategories = InputsCategories::find($id)) {

            return response(["status" => "error", "message" => "Categoria não encontrada!"], 500);

        } else {

            try {
                $inputsCategories->delete();

                return response([ "status" => "success", "message" => "Categoria removida com sucesso!" ], 200);
            } catch(Exception $err) {
                return response([ "error" => "error", "message" => $err->getMessage()], 500);
            }
        }

    }
}
