<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Inputs;
use App\Models\Outputs;
use App\Models\Recurrence;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OverviewController extends Controller
{
    // Resumo contabilizando somente os valores pagos (baixados)
    public function show(Request $request)
    {
        $date = strtotime($request->date);
        $month = date("m", $date);
        $year = date("Y", $date);

        $inputs = DB::select("SELECT (SUM(amount) + SUM(portion_amount)) total FROM inputs WHERE extract(month FROM receipt_date) = '$month' AND extract(year FROM receipt_date) =  '$year' AND payment_status = true");

        $outputs = DB::select("SELECT (SUM(amount) + SUM(portion_amount)) total FROM outputs WHERE extract(month FROM receipt_date) = '$month' AND extract(year FROM receipt_date) = '$year' AND payment_status = true");

        $inputs = $inputs[0]->total;
        $outputs = $outputs[0]->total;

        $inputs = floatval($inputs);
        $outputs = floatval($outputs);

        return response(['data' => ['inputs' => $inputs, 'outputs' => $outputs]], 200);
    }

    // Resumo contabilizando somente os valores a serem pagos (previsão)
    public function showPrevision(Request $request)
    {
        $date = strtotime($request->date);
        $month = date("m", $date);
        $year = date("Y", $date);

        $inputs = DB::select("SELECT (SUM(amount) + SUM(portion_amount)) total FROM inputs WHERE extract(month FROM receipt_date) = '$month' AND extract(year FROM receipt_date) =  '$year' AND payment_status = false");

        $outputs = DB::select("SELECT (SUM(amount) + SUM(portion_amount)) total FROM outputs WHERE extract(month FROM receipt_date) = '$month' AND extract(year FROM receipt_date) = '$year' AND payment_status = false");

        $inputs = $inputs[0]->total;
        $outputs = $outputs[0]->total;

        $inputs = floatval($inputs);
        $outputs = floatval($outputs);

        return response(['data' => ['inputs' => $inputs, 'outputs' => $outputs]], 200);
    }

}
