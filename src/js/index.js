$(document).ready(function () {
  var nombre = localStorage.getItem('nombre');
  if(nombre != null){
    window.location.href = "home.php";
  }
});
//sessionStorage.getItem("nombre");

$("#btnLoginUser").click(function(e){
  var user = $("#emailUser").val();
  var passw = $("#passwUser").val();

  if(user != '' && passw != ''){
    $.ajax({
      url:"backend/index.php?type=getlogin",
      type:"post",
      dataType:"json",
      data:{"email": user, "password": passw},
      success:function(s){
        var datos = s.data;

        if(s.code == 200){
          if(datos != null){
            localStorage.setItem('id', datos['id']);
            localStorage.setItem('nombre', datos['usuario']);
            localStorage.setItem('correo', datos['correo']);
            localStorage.setItem('type', datos['tipo']);

            window.location.href = "home.php";
          } else{
            //window.location.href = "index.php";
            Swal.fire({
              position: 'top-end',
              icon: 'error',
              title: 'Credenciales incorrectas',
              showConfirmButton: false,
              timer: 1500
            });
            console.log("ddhgdhg");

          }
        } else{
          //window.location.href = "index.php";
          Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Credenciales incorrectas',
            showConfirmButton: false,
            timer: 1500
          })
        }

      },
      error:function(e){
        //window.location.href = "index.php";
        Swal.fire({
          position: 'top-end',
          icon: 'error',
          title: 'Credenciales incorrectas',
          showConfirmButton: false,
          timer: 1500
        })
        console.log("error");
        console.log(e);
      }
    });
  }else{
    Swal.fire({
      position: 'top-end',
      icon: 'warning',
      title: 'Ingresa el correo y contraseña',
      showConfirmButton: false,
      timer: 1500
    })
  }

});
$("#btnsaveuser").click(function(e){
  var name = $("#name").val();
  var correo = $("#useremail").val();
  var password = $("#passworduser").val();
  var passw = $("#passworduser2").val();
  var typeuser = $("#selecttypeuser").val();

  if(name != '' && correo != '' && password != '' && passw != '' && typeuser != '0'){
    if(password == passw){
      $.ajax({
        url:"backend/index.php?type=add",
        type:"post",
        dataType:"json",
        data:{"name":name,"correo":correo,"password":password,"passw":passw,"typeuser":typeuser},
        success:function(s){

          if(s.code == 200){
            var datos = s.data;

            if(datos != null){
              localStorage.setItem('id', datos['id']);
              localStorage.setItem('nombre', datos['usuario']);
              localStorage.setItem('correo', datos['correo']);
              localStorage.setItem('type', datos['tipo']);

              window.location.href = "home.php";
            }
          } else{
            //window.location.href = "index.php";
            Swal.fire({
              position: 'top-end',
              icon: 'error',
              title: 'error al registrar el usuario',
              showConfirmButton: false,
              timer: 1500
            })
          }
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
        title: 'Las constraseñas no coinciden',
        showConfirmButton: false,
        timer: 2500
      })
    }
  }else{
    Swal.fire({
      position: 'top-end',
      icon: 'warning',
      title: 'Llene todos los campos',
      showConfirmButton: false,
      timer: 2500
    })
  }
})
