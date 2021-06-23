<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Dependentes;
use Exception;

class DependentesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //

    public function dependentesPorPessoa(Request $request){
        try{

            if(!isset($request->pessoa_id)){
                throw new Exception("O parâmetro pessoa_id não foi enviado.");
            }

            if(preg_match("/^\p{L}+$/", $request->pessoa_id)){
                throw new Exception("O parâmetro pessoa_id não é um inteiro válido.");
            }

            return response()->json(Dependentes::dependentesPorPessoa($request));
        }catch(Exception $e){
            return response()->json(["success"=>0, "message"=>$e->getMessage(), "data"=>[]]);
        }
    }

    public function adicionarDependente(Request $request){
        try{

            if(!isset($request->pessoa_id)){
                throw new Exception("O parâmetro pessoa_id não foi enviado.");
            }

            if(preg_match("/^\p{L}+$/", $request->pessoa_id)){
                throw new Exception("O parâmetro pessoa_id não é um inteiro válido.");
            }


            if(!isset($request->nome)){
                throw new Exception("O parâmetro nome não foi enviado.");
            }
            
            if(strlen($request->nome)==0){
                throw new Exception("O parâmetro nome está vazio.");
            }


            if(!strtotime($request->data_nascimento) && !preg_match("/\d{4}\-\d{2}-\d{2}/", $request->data_nascimento)){
                throw new Exception("O parâmetro data_nascimento não representa uma data.");
            }

            $age = date_diff(date_create($request->data_nascimento), date_create('now'))->y;

            if($age>120){
                throw new Exception("O parâmetro data_nascimento corresponde a uma idade acima de 120 anos.");
            }



            return response()->json(Dependentes::adicionarDependente($request));
        }catch(Exception $e){
            return response()->json(["success"=>0, "message"=>$e->getMessage(), "data"=>[]]);
        }
    }

    public function deletarDependente(Request $request){
        try{

            if(!isset($request->dependente_id)){
                throw new Exception("O parâmetro dependente_id não foi enviado.");
            }

            if(preg_match("/^\p{L}+$/", $request->dependente_id)){
                throw new Exception("O parâmetro dependente_id não é um inteiro válido.");
            }

            return response()->json(Dependentes::deletarDependente($request));
        }catch(Exception $e){
            return response()->json(["success"=>0, "message"=>$e->getMessage(), "data"=>[]]);
        }        
    }

}
