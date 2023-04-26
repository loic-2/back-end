<?php

namespace App\Http\Controllers;

use App\Models\Personne;
use App\Models\Personnel;
use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $numberPerPage=$request->get('nombre');
        $personnels=Personnel::orderBy('created_at','desc')->paginate($numberPerPage)->toArray();
        foreach ($personnels['data'] as $key => $personnel) {
            $details= Personne::where('id_personne','=',$personnel['id_personne'])->get();
            foreach ($details as $value) {
                $personnels['data'][$key]["nom"]= $value["nom"];
                $personnels['data'][$key]["adresse"]= $value["adresse"];
                $personnels['data'][$key]["email"]= $value["email"];
                $personnels['data'][$key]["telephone"]= $value["telephone"];
            }
        }
        return response()->json($personnels,200,[],JSON_PRETTY_PRINT);
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
            $control=self::control($datas['matricule'],-1);
            if ($control['state']) {
                $personne= new Personne;
                $personnel= new Personnel;

                //personne
                $personne->nom= $datas['nom'];
                $personne->adresse= $datas['adresse'];
                $personne->telephone= $datas['telephone'];
                $personne->email= $datas['email'];

                //personnel
                $personnel->prenom= $datas['prenom'];
                $personnel->matricule= $datas['matricule'];
                $personnel->id_assureur= $datas['assurance'];

                DB::beginTransaction();

                try {
                    $personne->save();
                    $personnel->id_personne= $personne->id_personne;
                    $personnel->save();
                    DB::commit();
                    //construction de la reponse
                    $personnel['nom']=$personne->nom;
                    $personnel['adresse']=$personne->adresse;
                    $personnel['telephone']=$personne->telephone;
                    $personnel['email']=$personne->email;
                    return response()->json($personnel,200,[],JSON_PRETTY_PRINT);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $res= "Erreur est survenu lors de l'enregistrement";
                    return response()->json($res,500,[],JSON_PRETTY_PRINT);
                }
            } else {
                return response()->json($control['message'],500,[],JSON_PRETTY_PRINT);
            }
            
        }else{
            return response()->json($control['message'],500,[],JSON_PRETTY_PRINT);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Personnel $personnel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personnel $personnel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $datas= $request->get('personne');
        //retrieve personnel
        $personnel= Personnel::find($datas['id']);

        $control=PersonneController::control($datas['email'],$datas['telephone'],$datas['nom'],$personnel->id_personne);
        if ($control['state']) {
            $control=self::control($datas['matricule'],$personnel->id_personnel);
            if ($control['state']) {
                
                $personnel->matricule=$datas['matricule'];
                $personnel->prenom=$datas['prenom'];
                $personnel->id_assureur=$datas['assurance'];
                //retieve personne
                $personne= Personne::find($personnel->id_personne);

                $personne->nom=$datas['nom'];
                $personne->email=$datas['email'];
                $personne->adresse=$datas['adresse'];
                $personne->telephone=$datas['telephone'];

                DB::beginTransaction();
                try {
                    $personne->update();
                    $personnel->update();
                    DB::commit();
                    return response()->json("Modification reusssi",200,[],JSON_PRETTY_PRINT);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json("Echec de la modification",500,[],JSON_PRETTY_PRINT);
                }
            } else {
                return response()->json($control['message'],402,[],JSON_PRETTY_PRINT);
            }
            
        }else{
            return response()->json($control['message'],402,[],JSON_PRETTY_PRINT);
        }

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $personnel= Personnel::find($id);
        try {
            $taches= Tache::where('id_personnel','=',$personnel['id_personnel'])->get();
            if ($taches!=NULL) {
                foreach ($taches as $tache) {
                    $tache->delete();
                }
            }
            $personnel->delete();
        } catch (\Throwable $th) {
            echo 'echec de la suppresion';
        }
    }

    //control method
    public static function control($matricule,$id) : array
    {
        $res=[
            'state'=>false,
            'message'=>''
        ];
        if (Personnel::where('matricule',$matricule)->where('id_personnel','<>',$id)->count()==0) {
            $res['state']=true;
            return $res;
              
        } else {
            $res['message']="Matricule deja utilise";
            return $res;  
        }

    }
}
