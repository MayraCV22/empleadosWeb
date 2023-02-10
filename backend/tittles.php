<?php
    include_once("conexion.php");

    if(isset($_GET['type'])){
        if($_GET['type'] == 'gettittles'){
            echo json_encode(getTittles());
        } else if($_GET['type'] == 'add'){
            echo json_encode(addTittle());
        } else if($_GET['type'] == 'delete'){
            echo json_encode(deleteTittle());
        } else if($_GET['type'] == 'getemployeessalarybyid'){
            echo json_encode(getemployeessalarybyid());
        }

    }

    function getTittles(){
        $tittles = array();
        try{
            $draw = $_GET['draw'];
            $search = $_GET['search']['value'];
            $sqltotal = "SELECT * FROM titles";
            $resu = conectar()->query($sqltotal);

            $totalregistros = $resu->num_rows;
            $start = $_GET['start'];
            $end = $_GET['length'];

            $sql = "SELECT * FROM titles WHERE title LIKE '%" . $search . "%' LIMIT " . $start . "," . $end;

            if($resultado = conectar()->query($sql)){

                while($row = $resultado->fetch_assoc()){
                    $emp['emp_no'] = $row['emp_no'];
                    $emp['title'] = $row['title'];
                    $emp['from_date'] = $row['from_date'];
                    $emp['to_date'] = $row['to_date'];

                    array_push($tittles,$emp);
                }

            } else{
                $tittles = array();
            }
        }catch(Exception $e){
            $tittles = array();
        }
        $result['code'] = $totalregistros > 0 ? 200 : 400;
        $result['status'] = $totalregistros > 0 ? 'success' : 'error';
        $result['draw'] = $draw;
        $result['recordsTotal']= $totalregistros;//count($departamentos);
        $result['recordsFiltered']= $totalregistros;//count($departamentos);
        $result['data'] = $tittles;

        return $result;
    }

    function addTittle(){
        try{
            $sqlemployee = "SELECT * FROM employees WHERE emp_no = " . $_POST['empleado'] . " LIMIT 1";
            $resp = conectar()->query($sqlemployee);
            $emp = $resp->fetch_assoc();

            // buscar ese empleado para ver si no existe en la tabla de title, si existe decirle que ese usuario ya tiene un puesto
            $sqlexist = "SELECT * FROM titles WHERE emp_no = " . $_POST['empleado'];
            $respexist = conectar()->query($sqlexist);
            $employeeexist = $respexist->fetch_assoc();

            if($employeeexist == null){
                $sql ="INSERT INTO titles(emp_no,title,from_date) VALUES(".$_POST['empleado'].",'".$_POST['puesto']."','".$emp['hire_date']."')";
                $responde = conectar()->query($sql);

                if($responde == 1){
                    $result['code'] = 200;
                    $result['status'] = 'success';
                    $result['msm'] = 'Se inserto con exito el nuevo puesto par el empleado ' . $emp['first_name'] . " " . $emp['last_name'];
                } else{
                    $result['code'] = 202;
                    $result['status'] = 'warning';
                    $result['msm'] = "Error al guardar el puesto para el empleado";
                }
            } else{
                $result['code'] = 202;
                $result['status'] = 'warning';
                $result['msm'] = 'El empleado ya cuenta con un puesto';
            }

        }catch(Exception $e){
            $result['code']=500;
            $result['status']="error";
            $result['msm']="No se pudo insertar el puesto";
            $result['sms'] = $e->getMessage();
        }

        return $result;
    }

    function deleteTittle(){
      try {
        $sql = "DELETE FROM titles WHERE emp_no = " . $_POST["id"];
        $responde = conectar()->query($sql);
        if($responde == 1){
          $result['code'] = 200;
          $result['status'] = 'success';
          $result['msm'] = 'el salario del empleado ha sido eliminado con exito';
        }else{
          $result['code'] = 202;
          $result['status'] = 'warning';
          $result['msm'] = 'el salario del empleado no se ha eliminado correctamente';
        }
      } catch (Exception $e) {
        $result['code'] = 500;
        $result['status'] = 'error';
        $result['msm'] = 'Error al eliminar el salario del empleado';
      }
      return $result;
    }

    function getemployeessalarybyid(){
      try{
        $sql="SELECT * FROM titles WHERE emp_no = " . $_POST['id'];
        $responde = conectar()->query($sql);
        $empleado = $responde->fetch_assoc();

        $result['code'] = 200;
        $result['status'] = 'success';
        $result['empleado'] = $empleado;
      }catch(Exception $e){
        $result['code'] = 500;
        $result['status'] = 'error';
        $result['empleado'] = array();
      }
      return $result;
    }


?>
