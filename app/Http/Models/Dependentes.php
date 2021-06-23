<?php

namespace App\Http\Models;


use  App\Http\Helpers\API;
use Exception;
use Illuminate\Support\Facades\DB;


class Dependentes
{

    public static function dependentesPorPessoa($parameters){
        try{

            $page = (($parameters->page - 1 >= 0) ? $parameters->page - 1 : 0);
            $limit = 1;
            $offset = $page * $limit;

            $sql = "
                SELECT 
                    * 
                    FROM dependentes WHERE deleted='0' 
            ";

            $select = DB::select($sql);

            return API::res(1, "", $select);

        }catch(Exception $e){
            return API::res(0, $e->getMessage(), []);
        }
    }

    public static function adicionarDependente($parameters){
        try{

            $insert = DB::table('dependentes')->insertGetId(
                [
                    "created_by"=>1,
                    "pessoa_id"=>$parameters->pessoa_id,
                    "nome"=>$parameters->nome,
                    "data_nascimento"=>$parameters->data_nascimento
                ]
            );

            return API::res(1, "", ["inserted_id"=>$insert]);

        }catch(Exception $e){
            return API::res(0, $e->getMessage(), []);
        }
    }

    public static function deletarDependente($parameters){
        try{

            DB::beginTransaction();

            $select = DB::select("SELECT * FROM dependentes WHERE deleted='0' AND id='$parameters->dependente_id'");

            if(!$select){
                throw new Exception("O dependende_id não correspodente a uma id existente.");
            }

            $deleted = DB::table('dependentes')->where('id', '=', $parameters->dependente_id)->delete();

            DB::commit();

            return API::res(1, "", ["deleted"=>$deleted]);

        }catch(Exception $e){
            DB::rollBack();

            return API::res(0, $e->getMessage(), []);
        }        
    }

    

}
