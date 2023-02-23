$(document).ready(function () {
    loadingtable();
    var tipeusr = localStorage.getItem("type");

    // Agregar
    if(tipeusr == 'usuario' || tipeusr == 'mantenimineto'){
      $("#btnmodalnewdepartament").prop( "disabled", true );
    }
});

const loadingtable = () => {
    return table = $('#table-departament').DataTable({
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
            url: "backend/departament.php?type=getdepartment",
            type: "GET"
        },
    serverSide: true,
    columns: [
        { data: "dept_no" },
        { data: "dept_name" },
        { data: "dept_no",
            "render": function (id, type, JsonResultRow, meta){
              var btns = "";
              var tipeusr = localStorage.getItem("type");

              if(tipeusr == 'adminstrador' || tipeusr == 'mantenimineto' || tipeusr == 'superusuario'){
                btns += "<button class='btn btn-info' onclick = updatedepartament('"+(id)+"')>Editar</button><span> </span>";
              }else{
                btns += "<button class='btn btn-info' disabled>Editar</button><span> </span>";
              }

              if(tipeusr == 'mantenimineto' || tipeusr == 'superusuario'){
                btns += "<button class='btn btn-danger' onclick = deletedepartament('"+(id)+"')>Eliminar</button>";
              }else{
                btns += "<button class='btn btn-danger' disabled>Eliminar</button>";
              }
              return btns;
            }
        },
    ]
    });
}

function updatedepartament(id){
    $.ajax({
        url:"backend/departament.php?type=getbyiddepartament",
        type:"post",
        dataType:"json",
        data:{"id":id},
        success:function(s){
            if(s.code == 200){
                var datos = s.departament;

                $("#frmeditdepartament").empty();
                var frm = "<div class='form-group'><input type='text' id='id' class='form-control' value='"+datos.dept_no+"' disabled/></div>" +
                           "<div class='form-group'><input type='text' id='nameupdate' class='form-control' value='"+datos.dept_name+"'/></div>";

                $("#frmeditdepartament").append(frm);
                $("#updatedepartamentModal").modal("show");
            }
        },
        error:function(e){
            console.log("errror");
            console.log(e);

        }
    })
}

function deletedepartament(id){
    Swal.fire({
        title: '¿Estas seguro de eliminar el departamento?',
        text: "Una vez el cambio no habra reverso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar'
      }).then((result) => {
        if (result.isConfirmed) {
            //aqui va el ajax
            $.ajax({
                url:"backend/departament.php?type=destroy",
                type:"post",
                dataType:"json",
                data:{"id":id},
                success:function(s){
                    Swal.fire({
                        position: 'top-end',
                        icon: s.status,
                        title: s.msm,
                        showConfirmButton: false,
                        timer: 1500
                      });
                    if(s.code == 200){
                        loadingtable();
                    }
                },
                error:function(e){
                    console.log("Error");
                    console.log(e);
                }
            });
        }
      })
}

$("#btnnewdepa").click(function(e){

    var nombre = $("#name").val();

    if(nombre != ''){
        $.ajax({
            url:"backend/departament.php?type=add",
            type:"post",
            data:{"name": nombre},
            dataType: 'json',
            success:function(s){
                Swal.fire({
                    position: 'top-end',
                    icon: s.status,
                    title: s.msm,
                    showConfirmButton: false,
                    timer: 1500
                })
                $("#departamentonewModal").modal("hide");
            },
            error:function(e){
                Swal.fire({
                    icon: "error",
                    text: "error al insertar"
                });
            }
        });
    }else{
        Swal.fire({
            icon: "warning",
            text: "Ingresa un nombre"
        });
    }
});

$("#btnupdatedepartament").click(function(e){
    var id = $("#id").val();
    var nombre = $("#nameupdate").val();

    if(nombre != ''){
        $.ajax({
            url:"backend/departament.php?type=update",
            type:"post",
            data:{"id":id,"name": nombre},
            dataType: 'json',
            success:function(s){
                Swal.fire({
                    position: 'top-end',
                    icon: s.status,
                    title: s.msm,
                    showConfirmButton: false,
                    timer: 1500
                });
                loadingtable();
                $("#updatedepartamentModal").modal("hide");
            },
            error:function(e){
                Swal.fire({
                    icon: "error",
                    text: "error al insertar"
                });
            }
        });
    }else{
        Swal.fire({
            icon: "warning",
            text: "Ingresa un nombre"
        });
    }
});
