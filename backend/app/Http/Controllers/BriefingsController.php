<?php

namespace App\Http\Controllers;

use App\Models\Briefing;
use Exception;
use Illuminate\Http\Request;

class BriefingsController extends Controller
{

    public function index() {
        $briefings = Briefing::all();

        return response(['total' => sizeof($briefings), 'data' => $briefings], 200);
    }

    public function new(Request $request) {

        try {
            $briefings = Briefing::create([
            'client_id' => $request->client_id,
            'type' => $request->type,
            'name' => $request->name,
            'cnpj' => $request->cnpj,
            'email' => $request->email,
            'phone' => $request->phone,
            'socials' => $request->socials,
            'adress' => $request->adress,
            'projectDeadline' => $request->projectDeadline,
            'hasLogo' => $request->hasLogo,
            'comments' => $request->comments,
            'hasIntegration' => $request->hasIntegration,

            /** Campos do briefing do app */
            'companyServices' => $request->companyServices,
            'appFunctions' => $request->appFunctions,
            'appRefer' => $request->appRefer,

            /** Campos do briefing do site */
            'home' => $request->home,
            'about' => $request->about,
            'contact' => $request->contact,
            'services' => $request->services,
            'competitors' => $request->competitors,
            'colors' => $request->colors,
            'colorsDont' => $request->colorsDont,
            'appearance' => $request->appearance,
            'siteRefer' => $request->siteRefer,
            'copywriting' => $request->copywriting,

            /** Campos do briefing do sistema */
            'companyDescription' => $request->companyDescription,
            'whySystem' => $request->whySystem,
            'hasSystem' => $request->hasSystem,
            'currentSystemFunction' => $request->currentSystemFunction,

            'status' => $request->status ? $request->status : true
            ]);

            return response(['status' => 'success', 'message' => 'Briefing criado com sucesso!', 'data' => $briefings], 201);
        } catch(Exception $err) {
            return response(['status' => 'error', 'message' => $err->getMessage()], 500);
        }

    }

    public function update(Request $request, $id) {

        $request = $request->all();
        if(!$briefings = Briefing::find($id)) {

            return response(["status" => "error", "message" => "Briefing não encontrado!"], 500);

        } else {

            try {
                $briefings->update($request);

                return response(['status' => 'success', 'message' => 'Briefing atualizado com sucesso!', 'data' => $briefings], 201);
            } catch(Exception $err) {
                return response(['status' => 'error', 'message' => $err->getMessage()], 500);
            }

        }

    }

    public function remove(Briefing $briefings, $id) {

        if(!$briefings = Briefing::find($id)) {

            return response(["status" => "error", "message" => "Briefing não encontrado!"], 500);

        } else {

            try {
                $briefings->delete();

                return response([ "status" => "success", "message" => "Briefing removido com sucesso!" ], 200);
            } catch(Exception $err) {
                return response([ "error" => "error", "message" => $err->getMessage()], 500);
            }
        }

    }

}
