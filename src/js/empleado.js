$(document).ready(function () {
    loadingtable();
});

const loadingtable = () =>{
    return table = $('#table_employees').DataTable({
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
            url: "backend/employee.php?type=getEmpleados",
            type: "GET"
        },
    serverSide: true,
    columns: [
        { data: "emp_no" },
        { "data": "first_name",
            "render": function (data, type, JsonResultRow, meta){
                return JsonResultRow['first_name'] + " " + JsonResultRow['last_name'];
            }
    
        },
        { data: "gender" },
        { data: "birth_date" },
        { data: "hire_date" },
        { "data": "emp_no",
            "render": function (id, type, JsonResultRow, meta){
                return "<button class='btn btn-success' onclick = updateemployees('"+id+"')>Editar</button> <span> </span>" +
                       "<button class='btn btn-danger' onclick = deleteemployees('"+id+"')>Eliminar</button>"
            }
        },
    ]
    });
}

function updateemployees(id){
    $.ajax({
        url:"backend/employee.php?type=getbyidemployee",
        type:"post",
        dataType:"json",
        data:{"id":id},
        success:function(s){
            if(s.code == 200){
                var datos = s.employee;
                
                $("#frmeditemployee").empty();
                var frm = "<div class='form-group'><input type='text' class'form-control' id='id' value='"+datos.emp_no+"' disabled/></div>" +
                            "<div class='form-group'><input type='text' class='form-control' id='nameupdate'  value='"+datos.first_name+"'/></div>" +
                            "<div class='form-group'><input type='text' class='form-control' id='lastNameupdate' value='"+datos.last_name+"'/></div>" +
                            "<div class='form-check'>";
                            if(datos.gender == 'M'){
                                frm += "<input type='radio' class='form-check-input' name='genderupdate' id='genderupdate' value='m' checked/>Masculino </br>";
                                frm += "<input type='radio' class='form-check-input' name='genderupdate' id='genderupdate' value='f'/>Femenino </br></br></div>";
                            } else if(datos.gender == 'F'){
                                frm += "<input type='radio' class='form-check-input' name='genderupdate' id='genderupdate' value='m'/>Masculino </br>";
                                frm += "<input type='radio' class='form-check-input' name='genderupdate' id='genderupdate' value='f' checked/>Femenino </br></br></div>";
                            } else {
                                frm += "<input type='radio' class='form-check-input' name='genderupdate' id='genderupdate' value='m'/>Masculino </br>";
                                frm += "<input type='radio' class='form-check-input' name='genderupdate' id='genderupdate' value='f'/>Femenino </br></br></div>";
                            }
                           
                            
                            frm += "<div class='form-group'><input type='date' class='form-control' id='birthDayupdate' value='"+datos.birth_date+"'/></div>" +
                            "<div class='form-group'><input type='date' class='form-control' id='hireDateupdate' value='"+datos.hire_date+"'/></div>";
                $("#frmeditemployee").append(frm);
                $("#updateemployeeModal").modal("show");
            }
        },
        error:function(e){
            console.log("error");
            console.log(e);
        }
    })
}

function deleteemployees(id){
    Swal.fire({
        title: 'Seguro que quieres eliminar al empleado?',
        text: "Una vez el cambio no habra reverso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url:"backend/employee.php?type=destroy",
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
                console.log("error");
                console.log(e);
            }
          })
        }
      })
}

$("#btnneweployee").click(function(e){
    var firstName = $("#firstName").val();
    var lastName = $("#lastName").val();
    var gender = $('input:radio[name=gender]:checked').val(); //$("#gender").val(); // undefined
    var birthDay = $("#birthDay").val();
    var hireDate = $("#hireDate").val();

    if(firstName != '' && lastName != '' && gender != undefined && birthDay != '' && hireDate != '' && validarFechaMenorActual(birthDay)){
        $.ajax({
            url: "backend/employee.php?type=add",
            type: "post", 
            dataType: 'json',
            data:{"firstName":firstName,"lastName":lastName,"gender": gender, "birthDay": birthDay, "hireDate": hireDate},
            success:function(s){
                Swal.fire({
                    position: 'top-end',
                    icon: s.status,
                    title: s.msm,
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#newEmployeesModal").modal("hide");
            },
            error:function(e){
                Swal.fire({
                    position: 'top-end',
                    icon: "error",
                    title: "Error al insertar el  empleado",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    } else{
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Ingrese todos los campos',
            showConfirmButton: false,
            timer: 1500
        })
    }


});

$("#btnupdateemployeesave").click(function(e){
    var id = $("#id").val();
    var firstName = $("#nameupdate").val();
    var lastName = $("#lastNameupdate").val();
    var gender = $('input:radio[name=genderupdate]:checked').val();
    var birthDay = $("#birthDayupdate").val();
    var hireDate = $("#hireDateupdate").val();

    if(firstName != '' && lastName != '' && gender != undefined && birthDay != '' && hireDate != '' && validarFechaMenorActual(birthDay)){
        $.ajax({
            url: "backend/employee.php?type=update",
            type: "post", 
            dataType: 'json',
            data:{"id":id,"firstName":firstName,"lastName":lastName,"gender": gender, "birthDay": birthDay, "hireDate": hireDate},
            success:function(s){
                Swal.fire({
                    position: 'top-end',
                    icon: s.status,
                    title: s.msm,
                    showConfirmButton: false,
                    timer: 1500
                });
                loadingtable();
                $("#updateemployeeModal").modal("hide");
            },
            error:function(e){
                Swal.fire({
                    position: 'top-end',
                    icon: "error",
                    title: "Error al insertar el  empleado",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    } else{
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Ingrese todos los campos',
            showConfirmButton: false,
            timer: 1500
        })
    }
});



function validarFechaMenorActual(date){
    var x=new Date();
    var fecha = date.split("/");
    x.setFullYear(fecha[2],fecha[1]-1,fecha[0]);
    var today = new Date();

    if (x >= today)
      return false;
    else
      return true;
}