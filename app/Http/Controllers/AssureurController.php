<?php

namespace App\Http\Controllers;

use App\Models\Assureur;
use App\Models\Personne;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssureurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $numberPerPage=$request->get('nombre');
        $assureurs=Assureur::orderBy('created_at','desc')->paginate($numberPerPage)->toArray();
        foreach ($assureurs['data'] as $key => $assureur) {
            $details= Personne::where('id_personne','=',$assureur['id_personne'])->get();
            foreach ($details as $value) {
                $assureurs['data'][$key]["nom"]= $value["nom"];
                $assureurs['data'][$key]["adresse"]= $value["adresse"];
                $assureurs['data'][$key]["email"]= $value["email"];
                $assureurs['data'][$key]["telephone"]= $value["telephone"];
            }
        }
        return response()->json($assureurs,200,[],JSON_PRETTY_PRINT);
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
            $personne = new Personne;
            $assureur= new Assureur;

            //personne
            $personne->nom= $datas['nom'];
            $personne->adresse= $datas['adresse'];
            $personne->telephone= $datas['telephone'];
            $personne->email= $datas['email'];

            DB::beginTransaction();
            try {
                $personne->save();
                $assureur->id_personne=$personne->id_personne;
                $assureur->save();
                DB::commit();

                //construction de la reponse
                $assureur['nom']=$personne->nom;
                $assureur['adresse']=$personne->adresse;
                $assureur['telephone']=$personne->telephone;
                $assureur['email']=$personne->email;
                return response()->json($assureur,200,[],JSON_PRETTY_PRINT);
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
    public function show(Assureur $assureur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assureur $assureur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $datas= $request->get('personne');
        $assureur= Assureur::find($datas['id']);
        $control=PersonneController::control($datas['email'],$datas['telephone'],$datas['nom'],$assureur->id_personne);
        
        if ($control['state']) {
            $personne = Personne::find($assureur->id_personne);

            //personne
            $personne->nom= $datas['nom'];
            $personne->adresse= $datas['adresse'];
            $personne->telephone= $datas['telephone'];
            $personne->email= $datas['email'];

            DB::beginTransaction();
            try {
                $personne->update();
                $assureur->update();
                DB::commit();

                //construction de la reponse
                $assureur['nom']=$personne->nom;
                $assureur['adresse']=$personne->adresse;
                $assureur['telephone']=$personne->telephone;
                $assureur['email']=$personne->email;
                return response()->json($assureur,200,[],JSON_PRETTY_PRINT);
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
        $assureur= Assureur::find($id);
        try {
            $personnels= Personnel::where('id_assureur','=',$assureur['id_assureur'])->get();
            if ($personnels!=NULL) {
                foreach ($personnels as $personnel) {
                    $personnel->delete();
                }
            }
            $assureur->delete();
        } catch (\Throwable $th) {
            echo 'echec de la suppression';
        }
    }
}
