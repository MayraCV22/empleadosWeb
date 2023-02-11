$(document).ready(function () {
    loadingtable();
});


const loadingtable = () =>{
  return table = $('#table-salaries').DataTable({
    language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    },
    destroy: true,
    processing: true,
    serverSide: true,
    stateSave: true,
    paging: true,
    "paging": true,
    lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, 100, "All"] ],
    pagingType: "full_numbers",
    pageLength: 10,
    dom: 'lfrtipB',
    ajax: {
        url: "backend/salaries.php?type=getsalaries",
        type: "GET"
    },
serverSide: true,
columns: [
    { data: "emp_no" },
    { data: "salary" },
    { "data": "emp_no",
        "render": function (id, type, JsonResultRow, meta){
            return "<button class='btn btn-success' onclick = updatetittleemployees('"+id+"')>Editar</button> <span> </span>" +
                   "<button class='btn btn-danger' onclick = deletetittleemployees('"+id+"')>Eliminar</button>"
        }
    },
]
  });
}
