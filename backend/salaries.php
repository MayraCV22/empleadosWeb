<?php
  include_once("conexion.php");

  if(isset($_GET['type'])){
    if($_GET['type'] == 'getsalaries'){
        echo json_encode(getsalaries());
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

          $sql = "SELECT * FROM salary WHERE salary LIKE '%" . $search . "%' LIMIT " . $start . "," . $end;

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


 ?>
