<?php

namespace App\Http\Models;


use  App\Http\Helpers\API;
use Exception;
use Illuminate\Support\Facades\DB;


class Pessoas
{

    public static function listagemPessoas($parameters){
        try{

            $page = (($parameters->page - 1 >= 0) ? $parameters->page - 1 : 0);
            $limit = 3;
            $offset = $page * $limit;

            $sql = "

                SELECT 
                    * 
                    FROM pessoas WHERE deleted='0' LIMIT $limit OFFSET $offset

            ";

            $select_page = DB::select($sql);

            $select_all = DB::select("SELECT COUNT(id) AS total FROM pessoas WHERE deleted='0'");

            $total_de_registros = $select_all[0]->total;
            $total_de_paginas = ceil($total_de_registros / $limit);

            return API::res(1, "", ["lista"=>$select_page, "pagina_atual"=>$page, "total_de_paginas"=>$total_de_paginas, "total_de_registros"=>$total_de_registros]);

        }catch(Exception $e){
            return API::res(0, $e->getMessage(), []);
        }
    }

    public static function pessoa($parameters){
        try{

            $sql = "
                SELECT 
                    * 
                    FROM pessoas WHERE deleted='0' AND id='$parameters->pessoa_id' LIMIT 1 
            ";

            $select = DB::select($sql);

            return API::res(1, "", $select);

        }catch(Exception $e){
            return API::res(0, $e->getMessage(), []);
        }
    }

    public static function adicionarPessoa($parameters){
        try{

            $inserted_id = DB::table('pessoas')->insertGetId([
                "created_by"=>1,
                "foto_uri"=>"/fotos/".$parameters->uploaded_file,
                "nome"=>$parameters->nome,
                "data_nascimento"=>$parameters->data_nascimento,
                "email"=>$parameters->email
            ]);

            return API::res(1, "", ["inserted_id"=>$inserted_id]);

        }catch(Exception $e){
            return API::res(0, $e->getMessage(), []);
        }
    }

    public static function deletarPessoa($parameters){
        try{

            DB::beginTransaction();

            $dependentes_deleted = DB::table('dependentes')->whereIn('pessoa_id', $parameters->pessoas_id)->delete();
            $pessoas_deleted = DB::table('pessoas')->whereIn('id', $parameters->pessoas_id)->delete();

            DB::commit();

            return API::res(1, "", []);

        }catch(Exception $e){
            DB::rollBack();

            return API::res(0, $e->getMessage(), []);
        }        
    }

    public static function updateNome($nome){
        try{

            DB::beginTransaction();

            

            DB::commit();

            return API::res(1, "", []);

        }catch(Exception $e){
            DB::rollBack();

            return API::res(0, $e->getMessage(), []);
        }
    }

    public static function updateDataNascimento($data_nascimento){
        try{

            DB::beginTransaction();

            

            DB::commit();

            return API::res(1, "", []);

        }catch(Exception $e){
            DB::rollBack();

            return API::res(0, $e->getMessage(), []);
        }
    }

    public static function updateEmail($email){
        try{

            DB::beginTransaction();

            

            DB::commit();

            return API::res(1, "", []);

        }catch(Exception $e){
            DB::rollBack();

            return API::res(0, $e->getMessage(), []);
        }
    }

    public static function updateFoto($foto){
        try{

            DB::beginTransaction();

            

            DB::commit();

            return API::res(1, "", []);

        }catch(Exception $e){
            DB::rollBack();

            return API::res(0, $e->getMessage(), []);
        }
    }

    public static function updateStatus($pessoa_id, $status){
        try{

            DB::beginTransaction();

            $affected = DB::table('pessoas')
              ->where('id', $pessoa_id)
              ->update(['status' => $status]);

            DB::commit();

            return API::res(1, "", []);

        }catch(Exception $e){
            DB::rollBack();

            return API::res(0, $e->getMessage(), []);
        }
    }

}
