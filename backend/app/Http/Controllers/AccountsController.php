<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    public function index() {
        $inputs = Account::all();

        return response(['total' => sizeof($inputs), 'data' => $inputs], 200);
    }

    public function new(Request $request) {

        $initial_value = explode("R$ ", $request->initial_value);
        $initial_value = $initial_value[1];
        $initial_value = str_replace(",",".", $initial_value);

        try {
            $inputs = Account::create([
                "name" => $request->name,
                "initial_value" => $initial_value,
                "inputs" => $request->inputs,
                "outputs" => $request->outputs,
                "description" => $request->description,
                "four_numbers_card" => $request->four_numbers_card
            ]);

            return response(['status' => 'success', 'message' => 'Conta criada com sucesso!', 'data' => $inputs], 201);
        } catch(Exception $err) {
            return response(['status' => 'error', 'message' => $err->getMessage()], 500);
        }

    }

    public function showPrevision(Request $request) {

        $date = strtotime($request->date);
        $month = date("m", $date);
        $year = date("Y", $date);

        $accounts = Account::all();

        for ($i=0; $i < sizeof($accounts); $i++) {
            $account_id = $accounts[$i]->id;

            $inputs = DB::select("SELECT SUM(r.portion) inputs FROM recurrences r INNER JOIN inputs i ON r.input_id = i.id WHERE i.account_id = $account_id AND r.input_id > 0 AND extract(month FROM r.due_date) = '$month' AND extract(year FROM r.due_date) =  '$year' AND r.payment_status = false");

            /* $inputs = DB::select("SELECT (SUM(amount) + SUM(portion_amount)) inputs FROM inputs WHERE extract(month FROM due_date) = '$month' AND extract(year FROM due_date) =  '$year' AND account_id = $account_id AND payment_status = false"); */

            $accounts[$i]->inputs = $inputs[0]->inputs != null ? $inputs[0]->inputs : 0;

            $outputs = DB::select("SELECT SUM(portion) outputs FROM recurrences r INNER JOIN outputs o ON r.output_id = o.id WHERE o.account_id = $account_id AND r.output_id > 0 AND extract(month FROM r.due_date) = '$month' AND extract(year FROM r.due_date) =  '$year' AND r.payment_status = false");

            // $outputs = DB::select("SELECT (SUM(amount) + SUM(portion_amount)) outputs FROM outputs WHERE extract(month FROM due_date) = '$month' AND extract(year FROM due_date) =  '$year' AND account_id = $account_id AND payment_status = false");
            $accounts[$i]->outputs = $outputs[0]->outputs != null ? $outputs[0]->outputs : 0;

            $val1 = $inputs[0] ? $inputs[0]->inputs : 0;
            $val2 = $outputs[0] ? $outputs[0]->outputs : 0;

            $accounts[$i]->total = $val1 - $val2;
            $accounts[$i]->total = floatval($accounts[$i]->total);
        }

        return response(['data' => $accounts], 200);

    }

    public function showMadeEffective(Request $request) {

        $date = strtotime($request->date);
        $month = date("m", $date);
        $year = date("Y", $date);

        $accounts = Account::all();

        for ($i=0; $i < sizeof($accounts); $i++) {
            $account_id = $accounts[$i]->id;

            $inputs = DB::select("SELECT SUM(r.portion) inputs FROM recurrences r INNER JOIN inputs i ON r.input_id = i.id WHERE i.account_id = $account_id AND r.input_id > 0 AND extract(month FROM r.due_date) = '$month' AND extract(year FROM r.due_date) =  '$year' AND r.payment_status = true");

            // $inputs = DB::select("SELECT (SUM(amount) + SUM(portion_amount)) inputs FROM inputs WHERE extract(month FROM due_date) = '$month' AND extract(year FROM due_date) =  '$year' AND account_id = $account_id AND payment_status = true");

            $accounts[$i]->inputs = $inputs[0]->inputs != null ? $inputs[0]->inputs : 0;

            $outputs = DB::select("SELECT SUM(portion) outputs FROM recurrences r INNER JOIN outputs o ON r.output_id = o.id WHERE o.account_id = $account_id AND r.output_id > 0 AND extract(month FROM r.due_date) = '$month' AND extract(year FROM r.due_date) =  '$year' AND r.payment_status = true");

            // $outputs = DB::select("SELECT (SUM(amount) + SUM(portion_amount)) outputs FROM outputs WHERE extract(month FROM due_date) = '$month' AND extract(year FROM due_date) =  '$year' AND account_id = $account_id AND payment_status = true");

            $accounts[$i]->outputs = $outputs[0]->outputs != null ? $outputs[0]->outputs : 0;

            $val1 = $inputs[0] ? $inputs[0]->inputs : 0;
            $val2 = $outputs[0] ? $outputs[0]->outputs : 0;

            $accounts[$i]->total = $val1 - $val2;
            $accounts[$i]->total = floatval($accounts[$i]->total);
        }

        return response(['data' => $accounts], 200);

    }

    public function showRecurrencesPrevision(Request $request, $id) {

        $date = strtotime($request->date);
        $month = date("m", $date);
        $year = date("Y", $date);

        $accounts = DB::select("SELECT * FROM accounts WHERE id = $id");

        for ($i=0; $i < sizeof($accounts); $i++) {
            $account_id = $accounts[$i]->id;

            $inputs = DB::select("SELECT r.id recurrence_id, r.portion, r.due_date, r.payment_slip, r.payment_voucher, r.payment_status FROM recurrences r INNER JOIN inputs i ON r.input_id = i.id WHERE i.account_id = $id AND r.input_id > 0 AND extract(month FROM r.due_date) = '$month' AND extract(year FROM r.due_date) =  '$year' AND r.payment_status = false");

            $outputs = DB::select("SELECT r.id recurrence_id, r.portion, r.due_date, r.payment_slip, r.payment_voucher, r.payment_status FROM recurrences r INNER JOIN outputs o ON r.output_id = o.id WHERE o.account_id = $id AND r.output_id > 0 AND extract(month FROM r.due_date) = '$month' AND extract(year FROM r.due_date) =  '$year' AND r.payment_status = false");

            $accounts[$i]->inputs = $inputs;
            $accounts[$i]->outputs = $outputs;
        }

        return response(['data' => $accounts], 200);

    }

    public function showRecurrencesMadeEffective(Request $request, $id) {

        $date = strtotime($request->date);
        $month = date("m", $date);
        $year = date("Y", $date);

        $accounts = DB::select("SELECT * FROM accounts WHERE id = $id");

        for ($i=0; $i < sizeof($accounts); $i++) {
            $account_id = $accounts[$i]->id;

            $inputs = DB::select("SELECT r.id recurrence_id, r.portion, r.due_date, r.payment_slip, r.payment_voucher, r.payment_status FROM recurrences r INNER JOIN inputs i ON r.input_id = i.id WHERE i.account_id = $id AND r.input_id > 0 AND extract(month FROM r.due_date) = '$month' AND extract(year FROM r.due_date) =  '$year' AND r.payment_status = true");

            $outputs = DB::select("SELECT r.id recurrence_id, r.portion, r.due_date, r.payment_slip, r.payment_voucher, r.payment_status FROM recurrences r INNER JOIN outputs o ON r.output_id = o.id WHERE o.account_id = $id AND r.output_id > 0 AND extract(month FROM r.due_date) = '$month' AND extract(year FROM r.due_date) =  '$year' AND r.payment_status = true");

            $accounts[$i]->inputs = $inputs;
            $accounts[$i]->outputs = $outputs;
        }

        return response(['data' => $accounts], 200);

    }

    public function update(Request $request, $id) {

        $request = $request->all();
        if(!$inputs = Account::find($id)) {

            return response(["status" => "error", "message" => "Conta não encontrada!"], 500);

        } else {

            try {
                $inputs->update($request);

                return response(['status' => 'success', 'message' => 'Conta atualizada com sucesso!', 'data' => $inputs], 201);
            } catch(Exception $err) {
                return response(['status' => 'error', 'message' => $err->getMessage()], 500);
            }

        }

    }

    public function remove(Account $inputs, $id) {

        if(!$inputs = Account::find($id)) {

            return response(["status" => "error", "message" => "Conta não encontrada!"], 500);

        } else {

            try {
                $inputs->delete();

                return response([ "status" => "success", "message" => "Conta removida com sucesso!" ], 200);
            } catch(Exception $err) {
                return response([ "error" => "error", "message" => $err->getMessage()], 500);
            }
        }

    }
}
