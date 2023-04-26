<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Personnel;
use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taches= Tache::all();
        foreach ($taches as $tache) {
            $personnel= Personnel::where('id_personnel','=',$tache['id_personnel'])->get();
            $activite= Activite::where('id_activite','=',$tache['id_activite'])->get();
            foreach ($personnel as $value) {
                $tache["personnel"]= $value["prenom"];
            }
            foreach($activite as $value){
                $tache["activite"]= $value["nom"];
            }
        }
        return response()->json($taches,200,[],JSON_PRETTY_PRINT);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tache $tache)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tache $tache)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tache $tache)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tache= Tache::find($id);
        try {
            $tache->delete();
        } catch (\Throwable $th) {
            echo "echec de la suppression";
        }
    }
}
