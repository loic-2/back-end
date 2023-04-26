<?php

namespace App\Http\Controllers;

use App\Models\Personne;
use Illuminate\Http\Request;

class PersonneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Personne::all());
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
    public function show(Personne $personne)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personne $personne)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Personne $personne)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personne $personne)
    {
        //
    }

    public static function control($email,$telephone,$nom,$id) : array
    {
        $res=[
            'state'=>false,
            'message'=>''
        ];
        if (Personne::where('email',$email)->where('id_personne','<>',$id)->count()==0) {
            if (Personne::where('telephone',$telephone)->where('id_personne','<>',$id)->count()==0) {
                if (Personne::where('id_personne','<>',$id)->where('nom',$nom)->count()==0) {
                    $res['state']=true;
                    return $res;
                } else {
                    $res['message']="Nom deja utilise";
                    return $res;
                }
            } else {
                $res['message']="Numero telephone deja utilise";
                return $res;
            }
                   
        } else {
            $res['message']="Adresse email deja utilise";
            return $res;
        }
            
    }
}
