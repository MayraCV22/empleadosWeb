<?php
    include_once("conexion.php");

    if(isset($_GET['type'])){
        if($_GET['type'] == 'getEmpleados'){
            echo json_encode(getEmpleados());
        } else if($_GET['type'] == 'add' ){
            echo json_encode(addEmpleados());
        }else if($_GET['type'] == 'destroy' ){
            echo json_encode(destroyEmpleados());
        } else if($_GET['type'] == 'getbyidemployee' ){
            echo json_encode(getEmpleadosbyid());
        }else if($_GET['type'] == 'update' ){
            echo json_encode(updateEmpleado());
        }else if($_GET['type'] == 'getemployeesselect' ){
            echo json_encode(selectEmpleado());
        }else if($_GET['type'] == 'getemployeesselectall' ){
            echo json_encode(selectallempleados());
        }
    }


    function getEmpleados(){
        $empleados = array();
        try{
            $draw = $_GET['draw'];
            $search = $_GET['search']['value'];
            $sqltotal = "SELECT * FROM employees";
            $resu = conectar()->query($sqltotal);

            $totalregistros = $resu->num_rows;
            $start = $_GET['start'];
            $end = $_GET['length'];

            $sql = "SELECT * FROM employees WHERE first_name LIKE '%" . $search . "%' OR last_name LIKE '%" . $search . "%' OR gender LIKE '%" .
                    $search . "%' LIMIT " . $start . "," . $end;

            if($resultado = conectar()->query($sql)){

                while($row = $resultado->fetch_assoc()){
                    $emp['emp_no'] = $row['emp_no'];
                    $emp['birth_date'] = $row['birth_date'];
                    $emp['first_name'] = $row['first_name'];
                    $emp['last_name'] = $row['last_name'];
                    $emp['gender'] = $row['gender'];
                    $emp['hire_date'] = $row['hire_date'];

                    array_push($empleados,$emp);
                }

            } else{
                $empleado = array();
            }
        }catch(Exception $e){
            $empleado = array();
        }
        $result['code'] = $totalregistros > 0 ? 200 : 400;
        $result['status'] = $totalregistros > 0 ? 'success' : 'error';
        $result['draw'] = $draw;
        $result['recordsTotal']= $totalregistros;//count($departamentos);
        $result['recordsFiltered']= $totalregistros;//count($departamentos);
        $result['data'] = $empleados;

        return $result;
    }
    function selectEmpleado(){
        $empleados = array();
        try{
            $sql = "SELECT * FROM employees WHERE emp_no NOT IN(SELECT emp_no FROM titles)";
            $resul = conectar()->query($sql);
            while($row = $resul->fetch_assoc()){
                $emp['emp_no'] = $row['emp_no'];
                $emp['first_name'] = $row['first_name'];
                $emp['last_name'] = $row['last_name'];
                array_push($empleados,$emp);
            }
            $result['code'] = 200;
            $result['status'] = "success";
            $result['employees'] = $empleados;

        }catch(Exception $e){
            $result['code'] = 500;
            $result['status'] = "error";
            $result['employees'] = array();
        }
        return $result;
    }
    function selectallempleados(){
      try{
        $empleados = array();
        $sql = "SELECT emp_no,first_name,last_name FROM employees LIMIT 1000";
        $responde = conectar()->query($sql);
        while($row = $responde->fetch_assoc()){
          $res['emp_no'] = $row['emp_no'];
          $res['first_name'] = $row['first_name'];
          $res['last_name'] = $row['last_name'];
          array_push($empleados,$res);
        }
        $result['code'] = 200;
        $result['status'] = 'success';
        $result['employees'] = $empleados;

      }catch(Exceptio $e){
        $result['code'] = 500;
        $result['status'] = 'error';
        $result['employees'] = array();
      }
      return $result;
    }
    function getEmpleadosbyid(){
        try{
            $sql = "SELECT * FROM employees WHERE emp_no = " . $_POST['id'];
            $resultado = conectar()->query($sql);
            $row = $resultado->fetch_assoc();

            $result['code'] = 200;
            $result['status'] = 'succes';
            $result['employee'] = $row;

        }catch(Exception $e){
            $result['code'] = 500;
            $result['status'] = 'error';
            $result['employee'] = array();
        }
        return $result;
    }
    function addEmpleados(){
        try {
            $firstname = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $gender = $_POST['gender'];
            $birthDay = $_POST['birthDay'];
            $hireDate = $_POST['hireDate'];

            // Obtener el ultimo id insertado
            $sqlinsert = "SELECT * FROM employees ORDER BY emp_no DESC LIMIT 1";
            $resultinsert =  conectar()->query($sqlinsert);
            $empleadoultimo = $resultinsert->fetch_assoc();

            $idultimo = intval($empleadoultimo['emp_no']) + 1;

            $sql = "INSERT INTO employees(emp_no,birth_date,first_name,last_name,gender,hire_date)
                    VALUES(".$idultimo.",'".$birthDay."','".$firstname."','".$lastName."', '".$gender."','".$hireDate."')";

            $respuesta = conectar()->query($sql);

            if($respuesta == 1){
                $result['code'] = 200;
                $result['status'] = 'success';
                $result['msm'] = "El registro se inserto con exito";
            }else{
                $result['code'] = 400;
                $result['status'] = 'error';
                $result['msm'] = "Error al registrar el usuario";
            }

        } catch (Exception $e) {
            $result['code'] = 500;
            $result['status'] = 'error';
            $result['msm'] = "Error al registrar el usuario";
        }
        return $result;
    }
    function updateEmpleado(){
        try {
            $id = $_POST['id'];
            $firstname = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $gender = $_POST['gender'];
            $birthDay = $_POST['birthDay'];
            $hireDate = $_POST['hireDate'];

            $sql = "UPDATE employees SET birth_date = '". $birthDay . "',first_name = '" . $firstname . "',last_name = '" . $lastName . "',gender = '" . $gender . "',hire_date = '" . $hireDate . "' WHERE emp_no = '" . $id . "'";

            $respuesta = conectar()->query($sql);

            if($respuesta == 1){
                $result['code'] = 200;
                $result['status'] = 'success';
                $result['msm'] = "El registro se modifico con exito";
            }else{
                $result['code'] = 400;
                $result['status'] = 'error';
                $result['msm'] = "Error al modificar el empleado";
            }

        } catch (Exception $e) {
            $result['code'] = 500;
            $result['status'] = 'error';
            $result['msm'] = "Error al modificar el empleado";
        }
        return $result;
    }
    function destroyEmpleados(){
        try{
            $sql = "DELETE FROM employees WHERE emp_no = " . $_POST['id'];

            $respuesta = conectar()->query($sql);

            if($respuesta == 1){
                $result['code'] = 200;
                $result['status'] = 'success';
                $result['msm'] = "El registro se elimino con exito";
            }else{
                $result['code'] = 400;
                $result['status'] = 'error';
                $result['msm'] = "Error al eliminar el usuario";
            }
        }catch(Exception $e){
            $result['code'] = 500;
            $result['status'] = 'error';
            $result['msm'] = 'error al eliminar el empleado';
        }
        return $result;
    }

?>
