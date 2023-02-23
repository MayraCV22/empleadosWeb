<?php
  include_once("conexion.php");

  if(isset($_GET['type'])){
    if($_GET['type'] == 'getlogin'){
        echo json_encode(getuserlogin());
    }else if($_GET['type'] == 'add'){
      echo json_encode(adduserlogin());
    }
  }

  function getuserlogin(){
    try {
      $correo = $_POST['email'];
      $password = $_POST['password'];
      $sql = "SELECT * FROM usuarios_login WHERE correo= '" . $correo . "' AND contrasena= '" . $password . "'";
      $responde = conectar()->query($sql);
      $user = $responde->fetch_assoc();

      $result['code'] = 200;
      $result['status'] = "success";
      $result['data'] = $user;

    } catch (Exception $e) {
      $result['code'] = 500;
      $result['status'] = "error";
      $result['data'] = array();
    }
    return $result;

  }
  function adduserlogin(){
    try {
      // validar que las contraseñas sean iguales
      if($_POST['password'] == $_POST['passw']){
        // comprobar que no existe el usuarios
        $sqlexist = "SELECT * FROM usuarios_login WHERE correo = '" . $_POST['correo'] . "'";
        $respondeexist = conectar()->query($sqlexist);
        $userexist = $respondeexist->fetch_assoc();
        if($userexist != 'null'){
          //insertar el usuario
          $name = $_POST['name'];
          $correo = $_POST['correo'];
          $password = $_POST['password'];
          $typeuser = $_POST['typeuser'];

          $sql = "INSERT INTO usuarios_login(usuario,correo,contrasena,tipo) VALUES('$name','$correo','$password','$typeuser')";
          $responde = conectar()->query($sql);

          if($responde == 1){
            $sqlconsult = "SELECT * FROM usuarios_login WHERE correo = '" . $correo . "'";
            $respconsult = conectar()->query($sqlconsult);
            $userconsult = $respconsult->fetch_assoc();
            $result['code'] = 200;
            $result['satus'] = 'success';
            $result['data'] = $userconsult;
          }else{
            $result['code'] = 202;
            $result['satus'] = 'warning';
            $result['msm'] = 'Error al registrar el usuario';
            $result['csdo'] = $responde;
          }
        }else {
          $result['code'] = 202;
          $result['satus'] = 'warning';
          $result['msm'] = 'El usuario ya existe';
        }
      }else{
        $result['code'] = 202;
        $result['satus'] = 'warning';
        $result['msm'] = 'Las contraseñas no coinciden';
      }

    } catch (Exception $e) {
      $result['code'] = 500;
      $result['satus'] = 'error';
      $result['msm'] = 'error al registrar el usuario';
    }
    return $result;
  }
 ?>
