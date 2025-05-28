<?php

require_once __DIR__ . "/../Config/Banco.php";

class Usuario {
    
   public static function fazerLogin($usu, $sen){
        
        $q = "SELECT * FROM usuarios WHERE usuario='$usu'";
        $resp = Banco::getConn()->query($q);

        // var_dump($resp);
        if($resp->num_rows <= 0){
            return false; // "Usuario não encontrado...";
        }else{
            
            $obj_usuario_resposta = $resp->fetch_object();
            // var_dump($obj_usuario_resposta);

            if($sen === $obj_usuario_resposta->senha){
                $_SESSION['usuario'] = $obj_usuario_resposta->usuario;
                $_SESSION['id-usuario'] = $obj_usuario_resposta->id;
                return true; // echo "Sucesso!";
            }else{
                return false; // echo "Senha errada >.<";
            }

        }
        
    }
    
}
