<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Plan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlansController extends Controller {
    public function index() {
        $plans = DB::select("SELECT p.id, p.title, p.price, p.description, p.status, s.service from plans p INNER JOIN services s ON p.service_id = s.id");

        return response(['total' => sizeof($plans), 'data' => $plans], 200);
    }

    public function show($serviceId) {
        $plans = DB::select("SELECT p.id, p.title, p.price, p.description, p.status, s.service from plans p INNER JOIN services s ON p.service_id = s.id WHERE service_id = $serviceId");

        return response(['data' => $plans], 200);
    }

    public function new(Request $request) {

        if ($request->price) {
            $price = explode("R$ ", $request->price);
            $price = $price[1];
            $price = str_replace(",", ".", $price);
        } else {
            $price = 0;
        }

        try {
            $plans = Plan::create([
                "service_id" => $request->service_id,
                "price" => $price,
                "title" => $request->title,
                "description" => $request->description,
                "status" => $request->status
            ]);

            return response(['status' => 'success', 'message' => 'Plano cadastrado com sucesso!', 'data' => $plans], 201);
        } catch (Exception $err) {
            return response(['status' => 'error', 'message' => $err->getMessage()], 500);
        }

    }

    public function update(Request $request, $id) {

        $request = $request->all();
        if(!$plans = Plan::find($id)) {

            return response(["status" => "error", "message" => "Plano não encontrado!"], 500);

        } else {

            try {

                $plans->update($request);

                return response(["status" => "success", "message" => "Plano atualizado com sucesso!"], 200);
            } catch(Exception $err) {
                return response(["status" => "error", "message" => $err->getMessage()], 500);
            }

        }
    }

    public function remove(Client $plans, $id) {

        if(!$plans = Plan::find($id)) {

            return response(["status" => "error", "message" => "Plano não encontrado!"], 500);

        } else {

            try {
                $plans->delete();

                return response([ "status" => "success", "message" => "PLano removido com sucesso!" ], 200);
            } catch(Exception $err) {
                return response([ "error" => "error", "message" => $err->getMessage()], 500);
            }

        }

    }
}
