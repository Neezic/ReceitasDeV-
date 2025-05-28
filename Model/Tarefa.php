<?php

require_once __DIR__ . "/../Config/Banco.php";

class Tarefa {

    public static function listarPorUsuario($idUsuario) {
        $sql = "SELECT * FROM tarefas WHERE id_usuario = $idUsuario";
        $result = Banco::getConn()->query($sql);

        $tarefas = [];
        while ($t = $result->fetch_object()) {
            $tarefas[] = $t;
        }

        return $tarefas;
    }

    public static function buscarPorId($id) {
        $sql = "SELECT * FROM tarefas WHERE id = '$id'";
        $result = Banco::getConn()->query($sql);
        return $result->fetch_object();
    }

    public static function criar($idUsuario, $texto) {
        $sql = "INSERT INTO tarefas (id, id_usuario, texto) VALUES (NULL, '$idUsuario', '$texto')";
        return Banco::getConn()->query($sql);
    }

    public static function atualizar(int $id, int $idUsuario, $texto) {
        $sql = "UPDATE tarefas SET texto='$texto', id_usuario='$idUsuario' WHERE id = '$id'";
        return Banco::getConn()->query($sql);
    }

    public static function excluir(int $id) {
        $sql = "DELETE FROM tarefas WHERE id = '$id'";
        return Banco::getConn()->query($sql);
    }
}
