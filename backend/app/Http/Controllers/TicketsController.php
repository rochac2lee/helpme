<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketsController extends Controller
{

    public function index() {

        $tickets = DB::select("SELECT t.id, t.user_id, t.url, t.priority, u.first_name, u.last_name, (SELECT users.first_name responsible_first_name FROM users WHERE t.responsible_id = users.id), (SELECT users.last_name responsible_last_name FROM users WHERE t.responsible_id = users.id), (SELECT users.profile FROM users WHERE t.responsible_id = users.id), t.client_id, c.first_name client_first_name, c.last_name client_last_name, t.status_id, st.status, t.title, t.description, to_char(t.created_at, 'DD/MM/YYYY HH24:MI:SS') created_at
                               FROM tickets t
                               LEFT JOIN users u ON t.user_id = u.id
                               LEFT JOIN clients c ON t.client_id = c.id
                               LEFT JOIN status_tickets st ON t.status_id = st.id
                               ORDER BY t.id DESC");

        return response(['total' => sizeof($tickets), 'data' => $tickets], 200);
    }

    public function show($id) {

        $tickets = DB::select("SELECT t.id, t.user_id, t.url, t.priority, u.first_name, u.last_name, (SELECT users.first_name responsible_first_name FROM users WHERE t.responsible_id = users.id), (SELECT users.last_name responsible_last_name FROM users WHERE t.responsible_id = users.id), (SELECT users.profile FROM users WHERE t.responsible_id = users.id), t.client_id, c.first_name client_first_name, c.last_name client_last_name, t.status_id, st.status, t.title, t.description, to_char(t.created_at, 'DD/MM/YYYY HH24:MI:SS') created_at
                               FROM tickets t
                               LEFT JOIN users u ON t.user_id = u.id
                               LEFT JOIN clients c ON t.client_id = c.id
                               LEFT JOIN status_tickets st ON t.status_id = st.id
                               WHERE t.id = $id");

        return response(['total' => sizeof($tickets), 'data' => $tickets], 200);
    }

    public function new (Request $request) {

        if ($request->responsible_id == "") {
            $request->responsible_id = $request->user_id;
        }

        try {
            $ticket = Ticket::create([
                'user_id' => $request->user_id ? $request->user_id : 1,
                'responsible_id' => $request->responsible_id,
                'client_id' => $request->client_id,
                'status_id' => $request->status_id ? $request->status_id : 1,
                'title' => $request->title,
                'description' => $request->description,
                'priority' => $request->priority ? $request->priority : 0,
                'url' => $request->url ? $request->url : "",
            ]);

            return response(['status' => 'success', 'message' => 'Ticket criado com sucesso!', 'data' => $ticket], 201);
        } catch(Exception $err) {
            return response(['status' => 'error', 'message' => $err->getMessage()], 500);
        }

    }

    public function update(Request $request, $id) {

        $request = $request->all();
        if(!$ticket = Ticket::find($id)) {

            return response(["status" => "error", "message" => "Ticket não encontrado!"], 500);

        } else {

            try {
                $ticket->update($request);

                return response(['status' => 'success', 'message' => 'Ticket atualizado com sucesso!', 'data' => $ticket], 201);
            } catch(Exception $err) {
                return response(['status' => 'error', 'message' => $err->getMessage()], 500);
            }

        }

    }

    public function remove(Ticket $ticket, $id) {

        if(!$ticket = Ticket::find($id)) {

            return response(["status" => "error", "message" => "Ticket não encontrado!"], 500);

        } else {

            try {

                // Exclui todos os dados de acompanhamento vinculados ao ticket
                DB::delete("DELETE FROM follow_tickets WHERE ticket_id = $id");

                $ticket->delete();

                return response([ "status" => "success", "message" => "Ticket removido com sucesso!" ], 200);
            } catch(Exception $err) {
                return response([ "error" => "error", "message" => $err->getMessage()], 500);
            }
        }

    }

}
