<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Request as ModelsRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestsController extends Controller
{

    public function index() {
        $requests = ModelsRequest::all();

        return response(['total' => sizeof($requests), 'data' => $requests], 200);
    }

    public function new(Request $request) {

        try {
            $requests = ModelsRequest::create([
                "client_id" => $request->client_id,
                "type" => $request->type,
                "name" => $request->name,
                "phone" => $request->phone,
                "email" => $request->email,
                "plan" => $request->plan,
                "additional_users" => $request->additional_users,
                "additional_whats" => $request->additional_whats,
                "has_campaigns" => $request->has_campaigns,
                "status" => $request->status ? $request->status : true
            ]);

            $msg = $request->name." solicitou mais informações sobre o ".$request->type;

            $notification = ([
                "client_id" => null,
                "created_by" => 1,
                "message" => $msg
            ]);

            HelperController::sendNotification($notification);

            return response(['status' => 'success', 'message' => 'Pedido criado com sucesso!', 'data' => $requests], 201);
        } catch(Exception $err) {
            return response(['status' => 'error', 'message' => $err->getMessage()], 500);
        }

    }

    public function update(Request $request, $id) {

        $request = $request->all();
        if(!$requests = ModelsRequest::find($id)) {

            return response(["status" => "error", "message" => "Pedido não encontrado!"], 500);

        } else {

            try {
                $requests->update($request);

                return response(['status' => 'success', 'message' => 'Pedido atualizado com sucesso!', 'data' => $requests], 201);
            } catch(Exception $err) {
                return response(['status' => 'error', 'message' => $err->getMessage()], 500);
            }

        }

    }

    public function remove(ModelsRequest $requests, $id) {

        if(!$requests = ModelsRequest::find($id)) {

            return response(["status" => "error", "message" => "Pedido não encontrado!"], 500);

        } else {

            try {
                $requests->delete();

                return response([ "status" => "success", "message" => "Pedido removido com sucesso!" ], 200);
            } catch(Exception $err) {
                return response([ "error" => "error", "message" => $err->getMessage()], 500);
            }
        }

    }

}
