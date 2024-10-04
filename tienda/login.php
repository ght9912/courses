<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="src/style.css">
    <link rel="stylesheet" href="vendors/fontawesome/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css"
    <link rel="stylesheet" type="text/css" href="vendors/daterangepicker/daterangepicker.css" />
</head>

<body >
<nav class="navbar bg-dark text-light">
  <div class="container-fluid justify-content-start">
    <button class="navbar-toggler border-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon icon-white"></span>
    </button>
    <a class="navbar-brand ms-2 color-white" href="#">SoftTienda</a>
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header text-dark">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">SoftTienda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="clientes.php">Clientes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="proveedores.php">Proveedores</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="productos.php">Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="inventario.php">Inventario</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pdv.php">Punto de Venta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="resultados.php">Resultados</a>
          </li>
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li> -->
        </ul>
        <form class="d-flex mt-3" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>
</nav>   

<main class="container text-center d-flex justify-content-center">
<div class="col-5">
<form id="loginForm">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Usuario</label>
    <input type="text" class="form-control" id="username" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Contraseña</label>
    <input type="password" class="form-control" id="pass">
  </div>
 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>


<?php require "inc/scripts.php";?>
<script>
 $("#loginForm").submit((e)=>{
    e.preventDefault();
    let fd={
        action:"login",
        nombre:$("#username").val(),
        pass:$("#pass").val()
    }
    $.ajax({
                type: "POST",
                url: "controllers/usuarios.php",
                data: fd,
                success: function (response) {
                   response= JSON.parse(response)
                   if(response.success){                    
                    window.location="index.php"
                   }else{
                    alert(response.message);
                   }
                },
                error: function(jqHXR,textStatus,errorThrow){
                    console.log(jqHXR,textStatus,errorThrow);
                }
            });
 })

</script>

<?php require "inc/foot.php";?>