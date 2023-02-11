$(document).ready(function () {
    loadingtable();
    loadingselectemployees($("#selectemployees")); // cargar select nuevo
    loadingselectemployeesedit($("#selectemployeesedit")); // cargar select de edit
});


const loadingtable = () =>{
    return table = $('#table-tittles').DataTable({
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
            url: "backend/tittles.php?type=gettittles",
            type: "GET"
        },
    serverSide: true,
    columns: [
        { data: "emp_no" },
        { data: "title" },
        { data: "from_date" },
        { data: "to_date" },
        { "data": "emp_no",
            "render": function (id, type, JsonResultRow, meta){
                return "<button class='btn btn-success' onclick = updatetittleemployees('"+id+"')>Editar</button> <span> </span>" +
                       "<button class='btn btn-danger' onclick = deletetittleemployees('"+id+"')>Eliminar</button>"
            }
        },
    ]
    });
}

const loadingselectemployees = (select) => {
    $.ajax({
        url:"backend/employee.php?type=getemployeesselect",
        type:"post",
        dataType:"json",
        success:function(s){
            if(s.code == 200){

                var datos = s.employees;
                var option = "";

                select.empty();
                option += "<option value='0'>Seleccione un empleado</option>";

                datos.forEach(function(e){
                    option += "<option value='"+e.emp_no+"'>"+e.first_name +"</option>";
                });

                select.append(option);
            }
        },
        error:function(e){
            console.log("error");
            console.log(e);
        }
    })
}
const loadingselectemployeesedit = (select) =>{
  $.ajax({
    url:"backend/employee.php?type=getemployeesselectall",
    type:"POST",
    dataType:"json",
    success:function(s){
      if(s.code == 200){

          var datos = s.employees;
          var option = "";

          select.empty();
          option += "<option value='0'>Seleccione un empleado</option>";

          datos.forEach(function(e){
              option += "<option value='"+e.emp_no+"'>"+e.first_name +"</option>";
          });

          select.append(option);
      }
    },
    error:function(e){
      console.log("error");
      console.log(e);
    }
  });
}
const updatetittleemployees = (id)=>{

  $.ajax({
    url:"backend/tittles.php?type=getemployeessalarybyid",
    type:"post",
    dataType:"json",
    data:{"id":id},
    success:function(s){
      if(s.code == 200){

        var empleado = s.empleado;
        $("#idemp").val(id)
        $("#selectemployeesedit").val(empleado.emp_no);
        $("#tittleemployees").val(empleado.title);
        $("#editsalaryemployeeModal").modal("show");


      }
    },
    error:function(e){
      console.log ("error");
      console.log(e);
    }
  })
}
const deletetittleemployees = (id)=>{
  Swal.fire({
    title: '¿Estas seguro que deseas eliminar el salario del empleado con id ' + id + '?',
    text: "Una vez eliminado no se podra recuperar!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url:"backend/tittles.php?type=delete",
        type:"post",
        dataType:"json",
        data:{"id":id},
        success: function(s){
          Swal.fire({
            position: 'top-end',
            icon: s.status,
            title: s.msm,
            showConfirmButton: false,
            timer: 1500
          })

          if(s.code ==200){
            loadingtable();
          }
        },
        error: function(e){
          console.log("error");
          console.log(e);
        }
      });
    }
  })
  }

$("#btnnewtittles").click(function(e){
    $("#tittlenewModal").modal("show");
});
$("#btnnewtittlessave").click(function(e){
    var empleado = $("#selectemployees").val();
    var puesto = $("#puestoid").val();

    $.ajax({
        url:"backend/tittles.php?type=add",
        type:"post",
        dataType:"json",
        data:{"empleado":empleado,"puesto":puesto},
        success:function(s){
            if(s.code == 200){
                Swal.fire({
                    position: 'top-end',
                    icon: s.status,
                    title: s.msm,
                    showConfirmButton: false,
                    timer: 2500
                  });
                $("#tittlenewModal").modal("hide");
                loadingtable();
            }
        },
        error:function(e){
            console.log("error");
            console.log(e);
        }
    });
});


$("#btnedittittle").click(function (e) {
  var empleado = $("#selectemployeesedit").val();
  var puesto = $("#tittleemployees").val();

  if(empleado != 0 && puesto != ''){
    $.ajax({
      url: "backend/tittles.php?type=updatetittle",
      type: "post",
      dataType: "json",
      data: {"id":empleado,"puesto":puesto},
      success:function(s){
        console.log(s);
        Swal.fire({
          position: 'top-end',
          icon: s.status,
          title: s.msm,
          showConfirmButton: false,
          timer: 1500
        });
        loadingtable();
        $("#editsalaryemployeeModal").modal("hide");

      },
      error:function(e){
        console.log(error);
        console.log(e);
      }
    })
  }
});
