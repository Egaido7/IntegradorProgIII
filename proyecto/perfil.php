<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Perfil Usuario</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos.css" />
    <link rel="stylesheet" href="estilosPerfil.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="validarRegistro.js" defer></script>
</head>

<body>
    <div class="header">
        <div class="header__left">
            <img src="LogoVeryDeli.svg" alt="Logo" class="logo">
            <div class="header__input" id="header_busqueda">
                <span class="material-icons"> search </span>
                <input type="text" placeholder="Buscar publicaciones" id="barraBusqueda" />
            </div>
        </div>

        <div class="header__middle" id="header_medio">
            <div class="header__option active">
                <span class="material-icons"> home </span>
            </div>
            <div class="header__option">
                <span class="material-icons"> storefront </span>
            </div>
            <div class="header__option">
                <span class="material-icons"> supervised_user_circle </span>
            </div>
        </div>

        <div class="header__right">
            <div class="header__info">
                <?php if (isset($_SESSION["logeado"]) && $_SESSION["logeado"]) { ?>
                    <form action="cerrarSesion.php" method="post">
                        <button type="submit" class="btn btn-secondary">Cerrar Sesión</button>
                    </form>
                <?php } else { ?>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</button>
                <?php } ?>
            </div>
        </div>

        <div class="header__responsive">
            <a href="buscador.php" class="header__option">
                <span class="material-icons"> home </span>
                <span>Inicio</span>
            </a>
            <a href="#buscar" class="header__option">
                <span class="material-icons"> search </span>
                <span>Buscar Pedidos</span>
            </a>
            <a href="#favoritos" class="header__option">
                <span class="material-icons"> rocket_launch </span>
                <span>Mis pedidos</span>
            </a>
            <a href="#perfil" class="header__option">
                <span class="material-icons"> person </span>
                <span>Perfil</span>
            </a>
        </div>
    </div>

    <div class="container">

        <div class="row">
            <div class="col-sm-4" style="margin-top: 50px;">
                <div class="text-center">
                    <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail"
                        alt="avatar">
                    <h3>Somanath Goudar</h3>
                </div>
                </hr><br>



                <ul class="list-group">
                    <li class="list-group-item text-right"><span class="pull-left"><strong>Calificacion Promedio</strong></span> 4.5</li>
                    <li class="list-group-item text-right">
                        <span class="pull-left">
                            <strong>Usuario Responsable</strong>
                        </span>
                        <span class="material-icons"> check_circle </span>
                    </li>

                    </li>
                </ul>
            </div>

            <div class="col-sm-8" style="margin-top: 50px;">
                <ul class="nav nav-tabs" id="secciones" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="postulaciones-tab" data-bs-toggle="tab" href="#postulaciones" role="tab" aria-controls="postulaciones" aria-selected="true">Postulaciones (2)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="publicaciones-tab" data-bs-toggle="tab" href="#publicaciones" role="tab" aria-controls="profile" aria-selected="false">Mis Publicaciones (3)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="vehiculos-tab" data-bs-toggle="tab" href="#vehiculos" role="tab" aria-controls="vehiculos" aria-selected="false">Vehículos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="calificaciones-tab" data-bs-toggle="tab" href="#calificaciones" role="tab" aria-controls="calificaciones" aria-selected="false">Calificaciones</a>
                    </li>
                </ul>


                <div class="tab-content">
                    <div class="tab-pane fade show active" id="postulaciones" role="tabpanel" aria-labelledby="postulaciones-tab">
                        <hr>
                        <form class="form" action="##" method="post" id="registrationForm">
                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label for="nombre">
                                        <h4>Nombre</h4>
                                    </label>
                                    <input type="text" class="form-control" name="nombre" id="nombre"
                                        placeholder="nombre">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label for="last_name">
                                        <h4>Apellido</h4>
                                    </label>
                                    <input type="text" class="form-control" name="apellidos" id="apellidos"
                                        placeholder="apellidos">
                                </div>
                            </div>

                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label for="dni">
                                        <h4>DNI</h4>
                                    </label>
                                    <input type="text" class="form-control" name="dni" id="dni"
                                        placeholder="46260606">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="localidad">
                                        <h4>Localidad</h4>
                                    </label>
                                    <input type="text" class="form-control" name="localidad" id="localida"
                                        placeholder="introduce tu localidad">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label for="domicilio">
                                        <h4>Domicilio</h4>
                                    </label>
                                    <input type="text" class="form-control" id="domicilio" placeholder="domicilio">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label for="email">
                                        <h4>Email</h4>
                                    </label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="you@email.com">
                                </div>
                            </div>

                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label for="password">
                                        <h4>Contraseña</h4>
                                    </label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="contraseña">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label for="password2">
                                        <h4>Verifica la contraseña</h4>
                                    </label>
                                    <input type="password" class="form-control" name="password2" id="password2"
                                        placeholder="password2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <br>
                                    <button class="btn btn-success" type="submit"><i
                                            class="glyphicon glyphicon-ok-sign"></i> Guardar</button>
                                    <button class="btn btn-danger" type="reset"><i
                                            class="glyphicon glyphicon-repeat"></i> Limpiar</button>
                                </div>
                            </div>
                        </form>

                        <hr>

                    </div>
                    <div class="tab-pane fade" id="publicaciones" role="tabpanel" aria-labelledby="publicaciones-tab">
                        <a href="#">
                            <div class="card border-success">
                                <div class="card-body card-publicacion">
                                    <h5 class="card-title">Titulo Publicacion</h5>
                                    <h6 class="card-subtitle mb-2 text-success">En Espera</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Provincia 1 - Provincia 2</h6>
                                    <p class="card-text">descripcion: Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat tenetur quia adipisci. Dolores magni animi repellendus quod eligendi, ipsam nulla!</p>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="card border-muted">
                                <div class="card-body card-publicacion">
                                    <h5 class="card-title">Titulo Publicacion</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Finalizado</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Provincia 1 - Provincia 2</h6>
                                    <p class="card-text">descripcion: Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat tenetur quia adipisci. Dolores magni animi repellendus quod eligendi, ipsam nulla!</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="tab-pane fade" id="vehiculos" role="tabpanel" aria-labelledby="vehiculos-tab">
                        <button type="button" class="btn btn-primary">Nuevo Vehículo</button>
                        <div class="card border-success">
                            <img class="card-img-top" src="imagenes/publicacionDefault.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Modelo de vehículo</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Nro Patente: 1234</h6>
                                <p class="card-text">Categoría: 2</p>
                            </div>
                        </div>
                        <div class="card border-success">
                            <img class="card-img-top" src="imagenes/publicacionDefault.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Modelo de vehículo</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Nro Patente: NR55</h6>
                                <p class="card-text">Categoría: 1</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="calificaciones" role="tabpanel" aria-labelledby="calificaciones-tab">
                        <div class="card border-success">
                            <img class="card-img-top" src="imagenes/publicacionDefault.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Somanath Goudar</h5>
                                <h6 class="card-subtitle mb-2 text-muted">2024-11-07   objeto bonito</h6>
                                <form method="post" action="#">
                                    <label for="calificacion">Calificación:</label>
                                    <select name="calificacion" id="calificacion">
                                        <option  name="calificacion" value="0">0</option>
                                        <option  name="calificacion" value="1">1</option>
                                        <option  name="calificacion" value="2">2</option>
                                        <option  name="calificacion" value="3">3</option>
                                        <option  name="calificacion" value="4">4</option>
                                        <option  name="calificacion" value="5">5</option>
                                    </select>

                                    <p><label for="opinion">opinion</label><input type="text" name="opinion" id="opinion"></p>
                                    <p><input type="submit" name="enviarCalificaion"></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                var readURL = function(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('.avatar').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $(".file-upload").on('change', function() {
                    readURL(this);
                });
            });
        </script>
    </div>
    <?php include 'modalLoginRegistro.html'; ?>
</body>

</html>