<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="http://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Empleados</title>
</head>
<body>

  <div class="container">
    <div class="row">
      <div class="col-sm">
        <h3 id="userloginwelcome"></h3>
      </div>
      <div class="col-sm">
      </div>
      <div class="col-sm">
        <button type="button" class="btn btn-link" style="float:right;" id="btncerrarsesion">cerrar sesion</button>
      </div>
    </div>
  </div>



    <header>
        <nav>
            <a href="home.php">Inicio</a>
            <a href="empleados.php">Empleados</a>
            <a href="tittles.php">Puestos</a>
            <a href="salaries.php">Salarios</a>
            <a href="departamentos.php">Departamentos</a>
            <div class="animation start-home"></div>
        </nav>
    </header>

<style>
    nav {
        margin: 27px auto 0;

        position: relative;
        width: 590px;
        height: 50px;
        background-color: #34495e;
        border-radius: 8px;
        font-size: 0;
    }
    nav a {
        line-height: 50px;
        height: 100%;
        font-size: 15px;
        display: inline-block;
        position: relative;
        z-index: 1;
        text-decoration: none;
        text-transform: uppercase;
        text-align: center;
        color: white;
        cursor: pointer;
    }
    nav .animation {
        position: absolute;
        height: 100%;
        top: 0;
        z-index: 0;
        transition: all .5s ease 0s;
        border-radius: 8px;
    }
    a:nth-child(1) {
        width: 100px;
    }
    a:nth-child(2) {
        width: 110px;
    }
    a:nth-child(3) {
        width: 100px;
    }
    a:nth-child(4) {
        width: 160px;
    }
    a:nth-child(5) {
        width: 120px;
    }
    nav .start-home, a:nth-child(1):hover~.animation {
        width: 100px;
        left: 0;
        background-color: #1abc9c;
    }
    nav .start-about, a:nth-child(2):hover~.animation {
        width: 110px;
        left: 100px;
        background-color: #e74c3c;
    }
    nav .start-blog, a:nth-child(3):hover~.animation {
        width: 100px;
        left: 210px;
        background-color: #3498db;
    }
    nav .start-portefolio, a:nth-child(4):hover~.animation {
        width: 160px;
        left: 310px;
        background-color: #9b59b6;
    }
    nav .start-contact, a:nth-child(5):hover~.animation {
        width: 120px;
        left: 470px;
        background-color: #e67e22;
    }

    body {
        font-size: 12px;
        font-family: sans-serif;
        background: #fffff;
        color:#000000;
    }
    h1 {
        text-align: center;
        margin: 40px 0 40px;
        text-align: center;
        font-size: 30px;
        color: #ecf0f1;
        text-shadow: 2px 2px 4px #000000;
        font-family: 'Cherry Swash', cursive;
    }

    p {
        position: absolute;
        bottom: 20px;
        width: 100%;
        text-align: center;
        color: #ecf0f1;
        font-family: 'Cherry Swash',cursive;
        font-size: 16px;
    }

    span {
        color: #2BD6B4;
    }
</style>

<script>
  var nombre = localStorage.getItem('nombre');

  if (nombre == null){
    window.location.href = "index.php";
  } 

  var nombre = localStorage.getItem("nombre");

  $("#userloginwelcome").text("Bienvenid@ "+ nombre);

  $("#btncerrarsesion").click(function(e){
    localStorage.clear();

    window.location.href = "index.php";
  })

</script>
