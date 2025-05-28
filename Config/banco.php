<?php

    // $banco = new mysqli("localhost", "root", "", "php-segunda-noite");
    
    abstract class Banco {
        private static $conn;

        public static function getConn()
        {
            if (!isset(self::$conn)) {
                self::$conn = new mysqli("localhost", "root", "", "php-segunda-noite");

                // Verifica se houve erro de conexão
                if (self::$conn->connect_error) {
                    die("Erro ao conectar ao banco: " . self::$conn->connect_error);
                }
            }

            return self::$conn;
        }
    }

?>