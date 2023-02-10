<?php include_once("header.php"); include_once("backend/employee.php");?>
<h1>Puestos Empresariales</h1>

<button class="btn btn-primary" id"btnnewtittles" data-toggle="modal" data-target="#tittlenewModal">Nuevo Puesto</button>
</br></br>
<table id="table-tittles">
  <thead>
  	<tr>
    	<td>Empleado</td>
        <td>Puesto</td>
        <td>Inicio de trabajo</td>
        <td>Fin de trabajo</td>
        <td>Acciones</td>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="tittlenewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo puesto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
          <div class="form-group">
          	<select id="selectemployees" class="form-control"></select>
          </div>
          <div class="form-group">
          	<input type="text" class="form-control" id="puestoid" placeholder="Escribe el puesto"/>
          </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id ="btnnewtittles">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal edit salarye-->
<div class="modal fade" id="editsalaryemployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="form-group">
              <select class="form-control" id="selectemployeesedit"></select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="tittleemployees"/>
            </div>
            <div class="form-group">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="src/js/tittles.js"></script>

<?php include_once("footer.php"); ?>
