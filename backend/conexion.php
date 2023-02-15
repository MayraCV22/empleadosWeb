<?php
include_once("config.php");
    $con;
    function conectar(){
        $con = mysqli_connect(SERVER, USER, PASSWORD, BD);

        if(!$con){
            echo 'Error en la conexion';
        }
        return $con;
    }

    function desconectar($con){
        mysqli_close($con);
    }

?>
