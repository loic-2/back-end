<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActiviteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Activite::all());
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
        $nom=$request->get('nom');
        $debut=$request->get('debut');
        $fin=$request->get('fin');
        $couleur=$request->get('couleur');
        $activite= new Activite();

        DB::beginTransaction();
        try {
           $activite->nom=$nom;
           $activite->fin=$fin;
           $activite->debut=$debut;
           $activite->couleur=$couleur;

           $activite->save();
           DB::commit();
           $res="Enregistrement reussi";
            return response()->json($res,202,[],JSON_PRETTY_PRINT);
        } catch (\Throwable $th) {
            DB::rollBack();
            $res="Une erreur est survenue veillez reessayer";
            return response()->json($res,500,[],JSON_PRETTY_PRINT);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Activite $activite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activite $activite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activite $activite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $activite= Activite::find($id);
        try {
            $taches=Tache::where('id_activite','=',$activite['id_activite'])->get();
            if($taches!=NULL){
                foreach($taches as $tache){
                    $tache->delete();
                }
            }
            $activite->delete();
        } catch (\Throwable $th) {
            echo "La suppression a echoue";
        }
    }
}
