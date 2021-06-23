<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Pessoas;
use Exception;
use DateTime;

class PessoasController extends Controller
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

    public function listagemPessoas(Request $request){
        try{

            if(!isset($request->page)){
                throw new Exception("O parâmetro page não foi enviado.");
            }

            if(preg_match("/^\p{L}+$/", $request->page)){
                throw new Exception("O parâmetro page não é um inteiro válido.");
            }

            return response()->json(Pessoas::listagemPessoas($request));
        }catch(Exception $e){
            return response()->json(["success"=>0, "message"=>$e->getMessage(), "data"=>[]]);
        }
    }

    public function pessoa(Request $request){
        try{

            if(!isset($request->pessoa_id)){
                throw new Exception("O parâmetro pessoa_id não foi enviado.");
            }

            if(preg_match("/^\p{L}+$/", $request->pessoa_id)){
                throw new Exception("O parâmetro pessoa_id não é um inteiro válido.");
            }

            return response()->json(Pessoas::pessoa($request));
        }catch(Exception $e){
            return response()->json(["success"=>0, "message"=>$e->getMessage(), "data"=>[]]);
        }
    }

    public function adicionarPessoa(Request $request){
        try{

            if(!isset($request->nome)){
                throw new Exception("O parâmetro nome não foi enviado.");
            }

            if(!isset($request->data_nascimento)){
                throw new Exception("O parâmetro data_nascimento não foi enviado.");
            }

            if(!strtotime($request->data_nascimento) && !preg_match("/\d{4}\-\d{2}-\d{2}/", $request->data_nascimento)){
                throw new Exception("O parâmetro data_nascimento não representa uma data.");
            }


            $age = date_diff(date_create($request->data_nascimento), date_create('now'))->y;

            if($age>120){
                throw new Exception("O parâmetro data_nascimento corresponde a uma idade acima de 120 anos.");
            }

            

            if(!isset($request->email)){
                throw new Exception("O parâmetro email não foi enviado.");
            }

            if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("O parâmetro email não corresponde a um padrão válido.");
            }

            if(!$request->hasFile('file')){
                throw new Exception("O parâmetro file não foi enviado.");
            }

            if($request->file('file')->getSize()>200000){
                throw new Exception("O arquivo da foto é muito grande.");
            }

            $foto = $request->file('file');
            $hash = $foto->hashName();

            $foto->move('fotos', $hash);

            $request->uploaded_file = $hash;

            return response()->json(Pessoas::adicionarPessoa($request));
        }catch(Exception $e){
            return response()->json(["success"=>0, "message"=>$e->getMessage(), "data"=>[]]);
        }
    }

    public function deletarPessoa(Request $request){
        try{

            if(!isset($request->pessoas_id)){
                throw new Exception("O parâmetro pessoa_id não foi enviado.");
            }

            if(!is_array($request->pessoas_id)){
                throw new Exception("O parâmetro pessoas_id não é uma array válida.");
            }

            return response()->json(Pessoas::deletarPessoa($request));
        }catch(Exception $e){
            return response()->json(["success"=>0, "message"=>$e->getMessage(), "data"=>[]]);
        }
    }

    public function atualizarPessoa(Request $request){
        try{

            if(!isset($request->pessoa_id)){
                throw new Exception("O parâmetro pessoa_id não foi enviado.");
            }

            if(preg_match("/^\p{L}+$/", $request->pessoa_id)){
                throw new Exception("O parâmetro pessoa_id não é um inteiro válido.");
            }

            if(isset($request->nome)){
                Pessoas::updateNome($request->nome);
            }

            if(isset($request->data_nascimento)){
                Pessoas::updateDataNascimento($request->data_nascimento);
            }

            if(isset($request->email)){
                Pessoas::updateEmail($request->email);
            }

            if(isset($request->foto)){
                Pessoas::updateFoto($request->foto);
            }

            if(isset($request->status)){
                Pessoas::updateStatus($request->pessoa_id, $request->status);
            }

            return response()->json(["success"=>1, "message"=>"", "data"=>[]]);
        }catch(Exception $e){
            return response()->json(["success"=>0, "message"=>$e->getMessage(), "data"=>[]]);
        }
    }


}
