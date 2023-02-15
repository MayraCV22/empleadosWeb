$(document).ready(function () {
    loadingtable();
    loadingempleados($("#employees"));
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
            return "<button class='btn btn-success' onclick = updatesalaryemployees('"+id+"')>Editar</button> <span> </span>" +
                   "<button class='btn btn-danger' onclick = deletesalarymployees('"+id+"')>Eliminar</button>"
        }
    },
]
  });
}
const loadingempleados = (select) => {
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

function deletesalarymployees(id){
  Swal.fire({
  title: '¿Estas seguro que quieres eliminar el registro?',
  text: "¡Una vez eliminado no podra recuperar registro!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Aceptar'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
      url:"backend/salaries.php?type=destroy",
      type:"post",
      dataType:"json",
      data:{"id":id},
      success:function(s){
        Swal.fire({
          position: 'top-end',
          icon: s.status,
          title: s.msm,
          showConfirmButton: false,
          timer: 1500,
        });
        if(s.code == 200){
          loadingtable();
        }
      },
      error:function(e){
        console.log("error");
        console.log(e);
      }
    })
  }
})
}
function updatesalaryemployees(id){
  $.ajax({
    url:"backend/salaries.php?type=getbysalaries",
    type:"post",
    dataType:"json",
    data:{"id": id},
    success:function(s){
      if(s.code == 200){
        var datos = s.salary;
        $("#frmEditSalaries").empty();
        var frm =
           "<div class='form-group'>" +
            "<input type='text' id='employeeidedit' class='form-control' value='"+datos['emp_no']+"' disabled/>" +
          "</div> " +
          "<div class='form-group'>" +
          "<input type = 'numeric' id='salaryemployeeedit' class='form-control' value='"+datos['salary']+"'/>" +
          "</div>";

        $("#frmEditSalaries").append(frm);
        $("#modificarSalariesModal").modal("show");

      }
    },
    error:function(e){
      console.log("error");
      console.log(e);
    }
  })
}


$("#btnnewsalary").click(function(e){
  var empleado = $("#employees").val();
  var salario = $("#salaryemployee").val();

  if(empleado !=0 && salario !=0){
    $.ajax({
      url:"backend/salaries.php?type=add",
      type:"post",
      dataType:"json",
      data:{"empleado":empleado,"salary":salario},
      success:function(s){
        Swal.fire({
          position: 'top-end',
          icon: s.status,
          title: s.msm,
          showConfirmButton: false,
          timer: 1500
        });
        loadingtable();
        $("#addsalariesModal").modal("hide");
      },
      error:function(e){
        console.log("error");
        console.log(e);
      }
    })
  }else{
    Swal.fire({
    position: 'top-end',
    icon: 'warning',
    title: 'Ingresa todos los campos',
    showConfirmButton: false,
    timer: 1500
  })
  }
});
$("#btnsavesalaryedit").click(function(e){
  var empleado = $("#employeeidedit").val();
  var salario = $("#salaryemployeeedit").val();

  if(empleado !=0 && salario !=0){
    $.ajax({
      url:"backend/salaries.php?type=updatesalaryemployees",
      type:"post",
      dataType:"json",
      data:{"id":empleado, "salaries":salario},
      success:function(s){
        Swal.fire({
          position: 'top-end',
          icon: s.status,
          title: s.msm,
          showConfirmButton: false,
          timer: 1500
        })

        if(s.code == 200){
          loadingtable();
          $("#modificarSalariesModal").modal("hide");
        }
      },
      error:function(e){
        console.log("error");
        console.log(e);
      }
    })
  } else{
    Swal.fire({
      position: 'top-end',
      icon: 'warning',
      title: 'Ingresa todos los campos',
      showConfirmButton: false,
      timer: 1500
    });
  }
});
