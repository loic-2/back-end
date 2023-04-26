<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Personne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $numberPerPage=$request->get('nombre');
        $clients=Client::orderBy('created_at','desc')->paginate($numberPerPage)->toArray();
        foreach ($clients['data'] as $key => $client) {
            $details= Personne::where('id_personne','=',$client['id_personne'])->get();
            foreach ($details as $value) {
                $clients['data'][$key]["nom"]= $value["nom"];
                $clients['data'][$key]["adresse"]= $value["adresse"];
                $clients['data'][$key]["email"]= $value["email"];
                $clients['data'][$key]["telephone"]= $value["telephone"];
            }
        }
        return response()->json($clients,200,[],JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datas= $request->get('personne');
        $control=PersonneController::control($datas['email'],$datas['telephone'],$datas['nom'],-1);
        
        if ($control['state']) {
            $personne= new Personne;
            $client= new Client;

            //personne
            $personne->nom= $datas['nom'];
            $personne->adresse= $datas['adresse'];
            $personne->telephone= $datas['telephone'];
            $personne->email= $datas['email'];

            DB::beginTransaction();
            try {
                $personne->save();
                $client->id_personne=$personne->id_personne;
                $client->id_assureur=(int)$datas['assurance'];
                $client->save();
                DB::commit();
                //construction de la reponse
                $client['nom']=$personne->nom;
                $client['adresse']=$personne->adresse;
                $client['telephone']=$personne->telephone;
                $client['email']=$personne->email;
                return response()->json($client,200,[],JSON_PRETTY_PRINT);
            } catch (\Throwable $th) {
                DB::rollBack();                        
                return response()->json("Une erreur est survenu lors de l'enregistrement",500,[],JSON_PRETTY_PRINT);
            }
        } else {
            return response()->json($control['message'],402,[],JSON_PRETTY_PRINT);
        }
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $datas= $request->get('personne');
        $client= Client::find($datas['id']);
        $control=PersonneController::control($datas['email'],$datas['telephone'],$datas['nom'],$client->id_personne);
        
        if ($control['state']) {
            $personne= Personne::find($client->id_personne);

            //personne
            $personne->nom= $datas['nom'];
            $personne->adresse= $datas['adresse'];
            $personne->telephone= $datas['telephone'];
            $personne->email= $datas['email'];

            DB::beginTransaction();
            try {
                $personne->update();
                $client->id_assureur=(int)$datas['assurance'];
                $client->update();
                DB::commit();
                //construction de la reponse
                $client['nom']=$personne->nom;
                $client['adresse']=$personne->adresse;
                $client['telephone']=$personne->telephone;
                $client['email']=$personne->email;
                return response()->json($client,200,[],JSON_PRETTY_PRINT);
            } catch (\Throwable $th) {
                DB::rollBack();                        
                return response()->json("Une erreur est survenu lors de l'enregistrement",500,[],JSON_PRETTY_PRINT);
            }
        } else {
            return response()->json($control['message'],402,[],JSON_PRETTY_PRINT);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client= Client::find($id);
        try {
            $client->delete();
        } catch (\Throwable $th) {
            echo "La suppression a echoue";
        }
    }
}
