<?php

namespace App\Http\Controllers;

use App\Models\Outputs;
use App\Models\Recurrence;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutputsController extends Controller
{
    public function index()
    {
        $outputs = Outputs::all();

        return response(['total' => sizeof($outputs), 'data' => $outputs], 200);
    }

    public function showOutputsPrevision(Request $request, $account_id)
    {

        $date = strtotime($request->date);
        $month = date("m", $date);
        $year = date("Y", $date);

        $outputs = DB::select("SELECT (SUM(amount) + SUM(portion_amount)) outputs FROM outputs WHERE extract(month FROM receipt_date) = '$month' AND extract(year FROM receipt_date) =  '$year' AND account_id = $account_id AND payment_status = false");

        return response(['data' => $outputs], 200);
    }

    public function showOutputsMadeEffective(Request $request, $account_id)
    {

        $date = strtotime($request->date);
        $month = date("m", $date);
        $year = date("Y", $date);

        $outputs = DB::select("SELECT (SUM(amount) + SUM(portion_amount)) outputs FROM outputs WHERE extract(month FROM receipt_date) = '$month' AND extract(year FROM receipt_date) =  '$year' AND account_id = $account_id AND payment_status = true");

        return response(['data' => $outputs], 200);
    }

    public function new(Request $request)
    {

        try {

            if ($request->amount) {
                $amount = explode("R$ ", $request->amount);
                $amount = $amount[1];
                $amount = str_replace(",", ".", $amount);
            } else {
                $amount = 0;
            }

            if ($request->portion_amount) {
                $portion_amount = explode("R$ ", $request->portion_amount);
                $portion_amount = $portion_amount[1];
                $portion_amount = str_replace(",", ".", $portion_amount);
            } else {
                $portion_amount = 0;
            }

            $outputs = Outputs::create([
                "description" => $request->description,
                "recurrence" => $request->recurrence,
                "recurrence_lenght" => $request->recurrence_lenght,
                "recurrence_type" => $request->recurrence_type,
                "amount" => $amount,
                "portion_amount" => $portion_amount,
                "due_date" => $request->due_date,
                "payment_status" => $request->payment_status,
                "cat_input_id" => $request->cat_input_id,
                "subcat_input_id" => $request->subcat_input_id,
                "account_id" => $request->account_id,
                "observation" => $request->observation,
                "receipt_date" => $request->receipt_date
            ]);

            switch ($request->recurrence) {
                case 0:
                    // A primeira recorrência pega a data inicial de vencimento
                    $due_date = $request->due_date;

                    Recurrence::create([
                        "output_id" => $outputs->id,
                        "portion" => $amount,
                        "due_date" => $due_date,
                        "payment_slip" => "",
                        "payment_voucher" => "",
                        "payment_status" => $request->payment_status
                    ]);


                    break;

                case 1:
                    // A primeira recorrência pega a data inicial de vencimento
                    $due_date = $request->due_date;

                    // Gera um array a partir da data inicial de pagamento
                    $due_dates = HelperController::dateRecurrences($due_date, 0, $request->recurrence_lenght);

                    // Insere as recorrências de Receita
                    for ($i = 0; $i < $request->recurrence_lenght; $i++) {

                        Recurrence::create([
                            "output_id" => $outputs->id,
                            "portion" => $portion_amount,
                            "due_date" => $due_dates[$i],
                            "payment_slip" => "",
                            "payment_voucher" => "",
                            "payment_status" => 0
                        ]);
                    }
                    break;

                case 2:
                    // A primeira recorrência pega a data inicial de vencimento
                    $due_date = $request->due_date;

                    // Gera um array a partir da data inicial de pagamento
                    $due_dates = HelperController::dateRecurrences($due_date, 0, 12);

                    // Insere as recorrências de Receita
                    for ($i = 1; $i <= 12; $i++) {

                        Recurrence::create([
                            "output_id" => $outputs->id,
                            "portion" => $portion_amount,
                            "due_date" => $due_dates[$i],
                            "payment_slip" => "",
                            "payment_voucher" => "",
                            "payment_status" => 0
                        ]);
                    }
                    break;
            }

            return response(['status' => 'success', 'message' => 'Despesa criada com sucesso!', 'data' => $outputs], 201);
        } catch (Exception $err) {
            return response(['status' => 'error', 'message' => $err->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {

        $request = $request->all();
        if (!$outputs = Outputs::find($id)) {

            return response(["status" => "error", "message" => "Despesa não encontrada!"], 500);
        } else {

            try {
                $outputs->update($request);

                return response(['status' => 'success', 'message' => 'Despesa atualizada com sucesso!', 'data' => $outputs], 201);
            } catch (Exception $err) {
                return response(['status' => 'error', 'message' => $err->getMessage()], 500);
            }
        }
    }

    public function remove(Outputs $outputs, $id)
    {

        if (!$outputs = Outputs::find($id)) {

            return response(["status" => "error", "message" => "Despesa não encontrada!"], 500);
        } else {

            try {
                $outputs->delete();

                return response(["status" => "success", "message" => "Despesa removida com sucesso!"], 200);
            } catch (Exception $err) {
                return response(["error" => "error", "message" => $err->getMessage()], 500);
            }
        }
    }
}
