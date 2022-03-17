<?php


namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Exception;

class HelperController extends Controller {

        /**
     * Função de recorrências de data
     * - Incrementa meses
     * - Se dia 30 ou 31 seta o mês de fevereiro como dia 28
     * - Valida ano bissexto
     *
     * @param  String $date
     * @param  Int $initial
     * @param  Int $qtd
     * @return array
     */
    public static function dateRecurrences(String $date, Int $initial, Int $qtd)
    {

        $date = strtotime($date);

        $year = date("Y", $date);
        $month = date("m", $date);
        $day = date("d", $date);

        for ($i = $initial; $i < $qtd; $i++) {

            if ($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12) {
                if ($day == 31) {
                    $date = "$year-$month-31";
                } else {
                    $date = "$year-$month-$day";
                }
            } else if ($month == 4 || $month == 6 || $month == 9 || $month == 11) {
                if ($day > 30) {
                    $date = "$year-$month-30";
                } else {
                    $date = "$year-$month-$day";
                }
            } else if ($month == 2) {
                if ($day > 29) {
                    $leap = date('L', mktime(0, 0, 0, 1, 1, $year));
                    if ($leap) {
                        $date = "$year-$month-29";
                    } else {
                        $date = "$year-$month-28";
                    }
                } else {
                    if ($day > 28) {
                        $date = "$year-$month-28";
                    } else {
                        $date = "$year-$month-$day";
                    }
                }
            }

            if ($month == 12) {
                $month = 0;
                $year++;
            }

            $month++;

            $dates[$i] = $date;
        }

        return $dates;
    }

    public static function sendNotification ($notification) {
        $users = User::all();

        for ($i = 0; $i < sizeof($users); $i++) {

            $user_id = $users[$i]->id;

            try {
                $ticket = Notification::create([
                    'user_id' => $user_id,
                    'client_id' => $notification->client_id,
                    'created_by' => $notification->user_id,
                    'message' => $notification->message,
                    'read' => 0
                ]);

                return response(['status' => 'success', 'message' => 'Notificação criada com sucesso!', 'data' => $ticket], 201);
            } catch (Exception $err) {
                return response(['status' => 'error', 'message' => $err->getMessage()], 500);
            }
        }
    }


}
