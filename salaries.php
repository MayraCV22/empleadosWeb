<?php include_once("header.php"); include_once("backend/employee.php");?>
<h1>salarios de los empleados</h1>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addsalariesModal">
Agregar salario
</button>
</br></br>

<table id="table-salaries">
  <thead>
    <tr>
      <th>Empleado</th>
      <th>Salario</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>



<!-- Modal nuevo salario -->
<div class="modal fade" id="addsalariesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Salario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id=>Guardas</button>
      </div>
    </div>
  </div>
</div>

<script src="src/js/salaries.js"></script>

<?php include_once("footer.php"); ?>
