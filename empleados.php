<?php include_once("header.php"); include_once("backend/employee.php");?>
<h1>Empleados</h1>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newEmployeesModal">
  Nuevo empleado
</button>

    <table id="table_employees">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Genero</th>
                <th>Cumpleaños</th>
                <th>Fecha contratacion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

<!-- Modal Nuevo empledao-->
<div class="modal fade" id="newEmployeesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo empleado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
            <div class="form-group">
                <input type="text" class="form-control" id="firstName" placeholder="Escribe el nombre"/>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="lastName" placeholder="Escribe los apellidos"/>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="gender" id="gender" value="m"/>Masculino </br>
                <input type="radio" class="form-check-input" name="gender" id="gender" value="f"/>Femenino </br></br>
            </div>
            <div class="form-group">
                <input type="date" id="birthDay" class="form-control"/>
            </div>
            <div class="form-group">
                <input type="date" id="hireDate" class="form-control"/>
            </div>            
            
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id = "btnneweployee">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal modifica Empleado-->
<div class="modal fade" id="updateemployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar Empleado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="frmeditemployee"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnupdateemployeesave">Guardar</button>
      </div>
    </div>
  </div>
</div>


<script src="src/js/empleado.js"></script>
<?php include_once("footer.php"); ?>