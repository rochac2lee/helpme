<?php

namespace App\Http\Controllers;

use App\Models\ServicesByClients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesByClientsController extends Controller {
    public function index() {
        $servicesByClients = ServicesByClients::all();

        return response(['total' => sizeof($servicesByClients), 'data' => $servicesByClients], 200);
    }

    public function show($clientId) {
        $servicesByClients = DB::select("
                                        SELECT
                                            services_by_clients.id,
                                            services_by_clients.title,
                                            services_by_clients.description,
                                            services_by_clients.status,
                                            services_by_clients.client_id,
                                            services_by_clients.service_id,
                                            services_by_clients.plan_id,
                                            services_by_clients.aditionals_users,
                                            services_by_clients.api,
                                            services.service,
                                            plans.title plan
                                        FROM services_by_clients
                                        INNER JOIN services
                                            ON services_by_clients.service_id = services.id
                                        Left JOIN plans
                                            ON services_by_clients.plan_id = plans.id
                                        WHERE client_id = $clientId");

        return response(['data' => $servicesByClients], 200);
    }

    public function new(Request $request) {
        $servicesByClients = ServicesByClients::create([
            "client_id" => $request->client_id,
            "service_id" => $request->service_id,
            "plan_id" => $request->plan_id,
            "title" => $request->title,
            "description" => $request->description,
            "status" => $request->status,
            "aditionals_users" => $request->aditionals_users,
            "api" => $request->api,
        ]);

        return $servicesByClients;

        $response = [
            "status" => "success",
            "message" => "Serviço vinculado ao cliente com sucesso!"
        ];

        return response($response, 201);
    }

    public function update(Request $request, ServicesByClients $servicesByClients) {

        $servicesByClients->plan_id = $request->plan_id;
        $servicesByClients->title = $request->title;
        $servicesByClients->description = $request->description;
        $servicesByClients->status = $request->status;
        $servicesByClients->aditionals_users = $request->aditionals_users;
        $servicesByClients->api = $request->api;
        $servicesByClients->save();

        $response = [
            "status" => "success",
            "message" => "Serviço atualizado com sucesso!"
        ];

        return response($response, 200);
    }

    public function remove(ServicesByClients $servicesByClients) {

        $servicesByClients->delete();

        $response = [
            "status" => "success",
            "message" => "Serviço desvinculado do cliente com sucesso!"
        ];

        return response($response, 200);
    }

}
