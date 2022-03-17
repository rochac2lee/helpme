<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Exception;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index() {
        $services = Service::all();

        return response(['total' => sizeof($services), 'data' => $services], 200);
    }

    public function new(Request $request) {

        try {
            $service = Service::create([
                "service" => $request->service,
                "price" => $request->price,
                "status" => $request->status
            ]);

            return response(['status' => 'success', 'message' => 'Serviço criado com sucesso!', 'data' => $service], 201);
        } catch(Exception $err) {
            return response(['status' => 'error', 'message' => $err->getMessage()], 500);
        }

    }

    public function update(Request $request, $id) {

        $request = $request->all();
        if(!$service = Service::find($id)) {

            return response(["status" => "error", "message" => "Serviço não encontrado!"], 500);

        } else {

            try {
                $service->update($request);

                return response(['status' => 'success', 'message' => 'Serviço atualizado com sucesso!', 'data' => $service], 201);
            } catch(Exception $err) {
                return response(['status' => 'error', 'message' => $err->getMessage()], 500);
            }

        }

    }

    public function remove(Service $service, $id) {

        if(!$service = Service::find($id)) {

            return response(["status" => "error", "message" => "Serviço não encontrado!"], 500);

        } else {

            try {
                $service->delete();

                return response([ "status" => "success", "message" => "Serviço removido com sucesso!" ], 200);
            } catch(Exception $err) {
                return response([ "error" => "error", "message" => $err->getMessage()], 500);
            }
        }

    }

}
