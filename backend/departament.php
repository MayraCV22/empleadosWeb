<?php
    include_once("conexion.php");

    if(isset($_GET['type'])){
        if($_GET['type'] == 'getdepartment'){
            echo json_encode(getDepartamentos());
        } else if($_GET['type'] == 'add' ){
            echo json_encode(adddepartamento($_POST['name']));
        }else if($_GET['type'] == 'destroy'){
            echo json_encode(destroydepartament());
        }else if($_GET['type'] == 'getbyiddepartament'){
            echo json_encode(getdepartamentbyid());
        } else if($_GET['type'] == 'update'){
            echo json_encode(updatedepartament($_POST['id'],$_POST['name']));
        }
    }

    function getDepartamentos(){
        $departamentos = array();
        try{            
            $draw = $_GET['draw'];
            $search = $_GET['search']['value'];
            $sqltotal = "SELECT * FROM departments";
            $resu = conectar()->query($sqltotal);
            $totalregistros = $resu->num_rows; 
            $start = $_GET['start'];
            $end = $_GET['length'];
            
            $sql = "SELECT * FROM departments WHERE dept_name LIKE '%" . $search . "%' ORDER BY dept_no ASC LIMIT " . $start . "," . $end;
            if ($datos = conectar()->query($sql)){
                                
                while($row = $datos->fetch_assoc()){
                    $depa['dept_no'] = $row['dept_no'];
                    $depa['dept_name'] = $row['dept_name'];
                    array_push($departamentos,$depa);
                }

            } else {
                $departamentos = array();
            }
            

        }catch(Exception $e){
            $departamentos = array();
        }
        $result['code'] = count($departamentos) > 0 ? 200 : 400;
        $result['status'] = count($departamentos) > 0 ? 'success' : 'error';
        $result['draw'] = $draw;
        $result['recordsTotal']= $totalregistros;//count($departamentos);
        $result['recordsFiltered']= $totalregistros;//count($departamentos);
        $result['data'] = $departamentos;

        return $result;
    }
    function getdepartamentbyid(){
        try{
            $sql = "SELECT * FROM  departments WHERE dept_no = '" . $_POST['id'] . "'";

            $datos = conectar()->query($sql);
            $row = $datos->fetch_assoc();

            $result['code'] = 200;
            $result['status'] = 'success';
            $result['departament'] = $row;
        }catch(Exception $e){
            $result['code'] = 500;
            $result['estatus'] = 'error';
            $result['departament'] = array();
        }
        return $result;
    }

    function adddepartamento($nombre){

        try{
            $id = rand(1,10000);
            $sql = "INSERT INTO departments(dept_no,dept_name) VALUES('d".$id."','".$nombre."')";
            
            $exec = conectar()->query($sql);
            if($exec == 1){
                $result['code'] = 200;
                $result['status'] = 'success';
                $result['msm'] = "El registro se inserto con exito";
            }else{
                $result['code'] = 400;
                $result['status'] = 'error';
                $result['msm'] = "Error al registrar el usuario";
            }

        }catch(Exception $e){
            $result['code'] = 500;
            $result['ms'] = $e->getMessage();
            $result['status'] = 'error';
            $result['msm'] = "Error al registrar el departamento";
        }
        return $result;
    }

    function updatedepartament($id,$nombre){

        try{
            $sqlexist = "SELECT * FROM departments WHERE dept_name = '" . $nombre . "'";
            $results = conectar()->query($sqlexist);
            $depart = $results->fetch_assoc(); 
            
            if($depart == null){
                $sql = "UPDATE departments SET dept_name = '" . $nombre . "' WHERE dept_no = '" . $id . "'"; 

                $exec = conectar()->query($sql);
                if($exec == 1){
                    $result['code'] = 200;
                    $result['status'] = 'success';
                    $result['msm'] = "El registro se modifico con exito";
                }else{
                    $result['code'] = 400;
                    $result['status'] = 'warning';
                    $result['msm'] = "Error al modificar el departamento";
                }
            } else{
                $result['code'] = 202;
                $result['status'] = 'warning';
                $result['msm'] = "Ya existe el departamento";
            }
            
            
        }catch(Exception $e){
            $result['code'] = 500;
            $result['ms'] = $e->getMessage();
            $result['status'] = 'error';
            $result['djr'] = count($depart);
            $result['msm'] = "Error al modificar el departamento";
        }
        return $result;
    }

    function destroydepartament(){
        try{
            $sql = "DELETE FROM departments WHERE dept_no = '" . trim($_POST['id']) ."'";
            $exec = conectar()->query($sql);
            if($exec == 1){
                $result['code'] = 200;
                $result['status'] = 'success';
                $result['msm'] = "El registro se eliminado con exito";
            }else{
                $result['code'] = 400;
                $result['status'] = 'error';
                $result['msm'] = "Error al eliminar el departamento";
            }
        }catch(Exception $e){
            $result['code'] = 500;
            $result['status'] = 'error';
            $result['msm'] = 'error al eliminar el departamento';
        }
        return $result;
    }

?>