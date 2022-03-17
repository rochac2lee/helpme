<?php

namespace App\Http\Controllers;

use App\Models\Recurrence;
use Exception;
use Illuminate\Http\Request;

class RecurrencesController extends Controller
{
    public function index() {
        $recurrences = Recurrence::all();

        return response(['total' => sizeof($recurrences), 'data' => $recurrences], 200);
    }

    public function new(Request $request) {

        try {
            $recurrences = Recurrence::create([
                "input_id" => $request->input_id,
                "output_id" => $request->output_id,
                "portion" => $request->portion,
                "due_date" => $request->due_date,
                "payment_slip" => $request->payment_slip,
                "payment_voucher" => $request->payment_voucher,
                "payment_status" => $request->payment_status
            ]);

            return response(['status' => 'success', 'message' => 'Recorrencia criada com sucesso!', 'data' => $recurrences], 201);
        } catch(Exception $err) {
            return response(['status' => 'error', 'message' => $err->getMessage()], 500);
        }

    }

    public function update(Request $request, $id) {

        $request = $request->all();
        if(!$recurrences = Recurrence::find($id)) {

            return response(["status" => "error", "message" => "Recorrencia não encontrada!"], 500);

        } else {

            try {
                $recurrences->update($request);

                return response(['status' => 'success', 'message' => 'Recorrencia atualizada com sucesso!', 'data' => $recurrences], 201);
            } catch(Exception $err) {
                return response(['status' => 'error', 'message' => $err->getMessage()], 500);
            }

        }

    }

    public function remove(Recurrence $recurrences, $id) {

        if(!$recurrences = Recurrence::find($id)) {

            return response(["status" => "error", "message" => "Recorrencia não encontrada!"], 500);

        } else {

            try {
                $recurrences->delete();

                return response([ "status" => "success", "message" => "Recorrencia removida com sucesso!" ], 200);
            } catch(Exception $err) {
                return response([ "error" => "error", "message" => $err->getMessage()], 500);
            }
        }

    }
}
