<?php
  include_once("conexion.php");

  if(isset($_GET['type'])){
    if($_GET['type'] == 'getsalaries'){
        echo json_encode(getsalaries());
    } else if($_GET['type'] == 'add'){
      echo json_encode(addsalaries());
    } else if($_GET['type'] == 'destroy') {
      echo json_encode(destroysalaries());
    } else if($_GET['type'] == 'getbysalaries'){
      echo json_encode(getsalariesbyid());
    } else if($_GET['type'] == 'updatesalaryemployees'){
      echo json_encode(update());
    }
  }

  function getsalaries(){
      $salaries = array();
      try{
          $draw = $_GET['draw'];
          $search = $_GET['search']['value'];
          $sqltotal = "SELECT * FROM titles";
          $resu = conectar()->query($sqltotal);

          $totalregistros = $resu->num_rows;
          $start = $_GET['start'];
          $end = $_GET['length'];

          $sql = "SELECT * FROM salaries WHERE salary LIKE '%" . $search . "%' LIMIT " . $start . "," . $end;

          if($resultado = conectar()->query($sql)){

              while($row = $resultado->fetch_assoc()){
                  $emp['emp_no'] = $row['emp_no'];
                  $emp['salary'] = $row['salary'];
                  $emp['from_date'] = $row['from_date'];
                  $emp['to_date'] = $row['to_date'];

                  array_push($salaries,$emp);
              }

          } else{
              $salaries = array();
          }
      }catch(Exception $e){
          $salaries = array();
      }
      $result['code'] = $totalregistros > 0 ? 200 : 400;
      $result['status'] = $totalregistros > 0 ? 'success' : 'error';
      $result['draw'] = $draw;
      $result['recordsTotal']= $totalregistros;//count($departamentos);
      $result['recordsFiltered']= $totalregistros;//count($departamentos);
      $result['data'] = $salaries;

      return $result;
  }
  function addsalaries(){
    try {
      $sqlemployees = "SELECT * FROM employees WHERE emp_no =" . $_POST['empleado'];
      $rptemployee = conectar()->query($sqlemployees);
      $empt = $rptemployee->fetch_assoc();

      if($empt != null){
        $sql="INSERT INTO salaries(emp_no,salary,from_date) VALUES(".$_POST['empleado'].", ".$_POST['salary'].", ".$empt['hire_date'].")";
        $rpt = conectar()->query($sql);

        if($rpt == 1){
          $result['code'] = 200;
          $result['status'] = 'success';
          $result['msm'] = 'Se inserto correctamente';
        }else{
          $result['code'] = 202;
          $result['status'] = 'warning';
          $result['msm'] = 'error al insertar el salario del empleados';
        }
      }else{
        $result['code'] = 202;
        $result['status'] = 'warning';
        $result['msm'] = 'error al insertar el salario del empleados';
      }
    } catch (Exception $e) {
      $result['code'] = 500;
      $result['status'] = 'error';
      $result['msm'] = 'error al insertar el salario del empleados';
    }
    return $result;
  }
  function destroysalaries(){
    try{
      $sql = "DELETE FROM salaries WHERE emp_no = " . $_POST['id'];

      $responde = conectar()->query($sql);

      if($responde == 1){
        $result['code'] = 200;
        $result['status'] = 'success';
        $result['msm'] = 'El registro se elimino con exito';
      }else{
        $result['code'] = 400;
        $result['status'] = 'error';
        $result['msm'] = 'Error al eliminar el salario';
      }
    }catch(Exception $e){
      $result['code'] = 500;
      $result['status'] = 'error';
      $result['msm'] = 'Error al eliminar el salario';
    }
    return $result;
  }
  function getsalariesbyid(){
    try{
      $sql = "SELECT * FROM salaries WHERE emp_no = " . $_POST['id'];
      $resultado = conectar()->query($sql);
      $row = $resultado->fetch_assoc();

      $result['code'] = 200;
      $result['status'] = 'success';
      $result['salary'] = $row;

    }catch(Exception $e){
      $result['code'] = 500;
      $result['status'] = 'error';
      $result['salary'] = array();
      $result['sql'] = $sql;
    }
    return $result;
  }
  function update(){
    try {
      $sql = "UPDATE salaries SET salary= " . $_POST['salaries'] . " WHERE emp_no=" . $_POST['id'];
      $resultado = conectar()->query($sql);
      if($resultado == 1){
        $result['code'] = 200;
        $result['status'] = 'success';
        $result['msm'] = 'El salario se modifico correctamente';
      }else{
        $result['code'] = 202;
        $result['status'] = 'warning';
        $result['msm'] = 'Error al modificar el salario';
      }

    } catch (Exception $e) {
      $result['code'] = 500;
      $result['status'] = 'error';
      $result['msm'] = 'Error al modificar el salario';
    }
    return $result;

  }

 ?>
