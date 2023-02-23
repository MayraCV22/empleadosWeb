<?php include_once("header.php"); include_once("backend/departament.php");?>

<h1>Departamentos</h1>

<button type="button" id="btnmodalnewdepartament" class="btn btn-primary" data-toggle="modal" data-target="#departamentonewModal">
  nuevo departamento
</button>

<table id="table-departament"  class="display" style="width:100%">
    <thead>
        <tr>
            <th>id</th>
            <th>nombre</th>
            <th>acciones</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<!-- Modal de nuevo departamento -->
<div class="modal fade" id="departamentonewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Departamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
            <div class="form-group">
                <input type="text" id="name" class="form-control" placeholder="escribe nombre" />
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnnewdepa">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de modificar departamento -->
<div class="modal fade" id="updatedepartamentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar Departamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="frmeditdepartament"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnupdatedepartament">Guardar</button>
      </div>
    </div>
  </div>
</div>


<script src="src/js/departamentos.js"></script>
<?php include_once("footer.php"); ?>
