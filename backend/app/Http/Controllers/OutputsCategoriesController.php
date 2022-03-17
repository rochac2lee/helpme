<?php

namespace App\Http\Controllers;

use App\Models\OutputsCategories;
use Exception;
use Illuminate\Http\Request;

class OutputsCategoriesController extends Controller
{
    public function index() {
        $outputsCategories = OutputsCategories::all();

        return response(['total' => sizeof($outputsCategories), 'data' => $outputsCategories], 200);
    }

    public function new(Request $request) {

        try {
            $outputsCategories = OutputsCategories::create([
                "category" => $request->category
            ]);

            return response(['status' => 'success', 'message' => 'Categoria para Despesas criado com sucesso!', 'data' => $outputsCategories], 201);
        } catch(Exception $err) {
            return response(['status' => 'error', 'message' => $err->getMessage()], 500);
        }

    }

    public function update(Request $request, $id) {

        $request = $request->all();
        if(!$outputsCategories = OutputsCategories::find($id)) {

            return response(["status" => "error", "message" => "Categoria não encontrada!"], 500);

        } else {

            try {
                $outputsCategories->update($request);

                return response(['status' => 'success', 'message' => 'Categoria atualizada com sucesso!', 'data' => $outputsCategories], 201);
            } catch(Exception $err) {
                return response(['status' => 'error', 'message' => $err->getMessage()], 500);
            }

        }

    }

    public function remove(OutputsCategories $outputsCategories, $id) {

        if(!$outputsCategories = OutputsCategories::find($id)) {

            return response(["status" => "error", "message" => "Categoria não encontrada!"], 500);

        } else {

            try {
                $outputsCategories->delete();

                return response([ "status" => "success", "message" => "Categoria removida com sucesso!" ], 200);
            } catch(Exception $err) {
                return response([ "error" => "error", "message" => $err->getMessage()], 500);
            }
        }

    }
}
