<?php

require_once __DIR__ . "/../Model/Tarefa.php";

class TarefasController {

    static function index() {
        session_start();
        $codUsuario = $_SESSION['id-usuario'] ?? null;
        $nomeUsuario = $_SESSION['usuario'] ?? null;

        if (is_null($codUsuario)) {
            header("Location: login");
        }

        $tarefas = Tarefa::listarPorUsuario($codUsuario);
        // var_dump($tarefas);

        include __DIR__ . '/../View/dashboard.php';
    }

    static function addTarefa() {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            session_start();

            $tarefa = $_POST['nova-tarefa'] ?? null;
            $codUsuario = $_SESSION['id-usuario'] ?? null;

            if (!is_null($tarefa) && !is_null($codUsuario)) {
                Tarefa::criar($codUsuario, $tarefa);
            }

            header("Location: dashboard");
        } else {
            echo "erro";
        }

        //include __DIR__ . '/../View/editar.php';
    }

    static function editarTarefa($idTarefa) {
        // $idTarefa = $_GET['id'] ?? null;

        if (is_null($idTarefa)) {
            header("Location: dashboard");
        }
        
        $tarefa = Tarefa::buscarPorId($idTarefa);
        include __DIR__ . '/../View/editar.php';
        // var_dump($tarefa);
    }

    static function atualizarTarefa() {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $idTarefa = $_POST['id-tarefa'] ?? null;
            $idUsuario = $_POST['id-usuario'] ?? null;
            $texto = $_POST['texto'] ?? null;

            if (!is_null($idTarefa)) {
                Tarefa::atualizar($idTarefa, $idUsuario, $texto);
            }

        }

        header("Location: dashboard");
    }

    static function apagarTarefa($idTarefa) {
        // var_dump($_GET);

        // $idTarefa = $_GET['id'] ?? null;
        
        if (!is_null($idTarefa)) {
            Tarefa::excluir((int)$idTarefa);
            header("Location: ../dashboard");
            exit;
        }

        header("Location: ../dashboard");
        exit;
    }
}
