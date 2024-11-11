<?php
include 'loginRegistro.php';

if(!isset($_SESSION["usuario"])) {
    header("Location: index.php");
} else {

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
</head>

<body>
    <div class="header">
        <div class="header__left">
            <a href="index.php">
                <img src="LogoVeryDeli.svg" alt="Logo" class="logo">
            </a>
            <div class="header__input" id="header_busqueda">
                <span class="material-icons"> search </span>
                <input type="text" placeholder="Buscar publicaciones" id="barraBusqueda" />
            </div>
        </div>

        <div class="header__middle" id="header_medio">
            <div class="header__option">
                <a href="index.php"><span class="material-icons"> home </span></a>
            </div>
            <div href="buscador.php" class="header__option">
                <a href="buscador.php"><span class="material-icons"> storefront </span></a>
            </div> 
            <div class="header__option active">
                <a href="perfil.php"><span class="material-icons"> account_circle </span></a>
            </div>
        </div>

        <div class="header__right">
            <div class="header__info">
                <?php if (isset($_SESSION["usuario"])) { ?>
                    <form action="cerrarSesion.php" method="post">
                        <button type="submit" class="btn btn-secondary">Cerrar Sesión</button>
                    </form>
                <?php } else { ?>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</button>
                <?php } ?>
            </div>
        </div>

        <div class="header__responsive">
            <?php if (isset($_SESSION["usuario"])) { ?>
            <a href="index.php" class="header__option">
                <span class="material-icons"> home </span>
                <span>Inicio</span>
            </a>
            <a href="buscador.php" class="header__option">
                <span class="material-icons"> search </span>
                <span>Buscar Pedidos</span>
            </a>
            <a href="perfil.php?tab=calificaciones" class="header__option">
                <span class="material-icons"> star </span>
                <span>Calificaciones</span>
            </a>
            <a href="perfil.php?tab=publicaciones" class="header__option">
                <span class="material-icons"> person </span>
                <span>Perfil</span>
            </a>
            <?php } else { ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</button>
            <?php } ?>
        </div>
    </div>

    <div class="container">

        <div class="row">
            <div class="col-sm-4" style="margin-top: 50px;">
                <div class="text-center">
                    <!-- Se muestra imagen y -->
                    <?php if(!isset($usuario['imagen'])) { ?>
                        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar rounded-circle img-fluid border"
                        alt="avatar">
                    <?php } else { ?>
                        <img src="imagenes/<?= $usuario["imagen"] ?>" alt="avatar" class="avatar rounded-circle img-fluid border">
                    <?php } ?>
                    <h3><?= ucfirst($usuario["nombre"]) . " " . ucfirst($usuario["apellido"]) ?></h3>
                </div>
                </hr><br>


                
                <ul class="list-group">
                    <li class="list-group-item text-right">
                        <span class="pull-left">
                            <strong>Calificación:</strong>
                        </span>
                        <?= $gestor->fetch_promedio_calificaciones_por_usuario($usuario["idUsuario"]) ?>
                        <span class="text-muted"> - Total: <?= $gestor->fetch_num_calificaciones_por_usuario($usuario["idUsuario"]) ?></span>
                    </li>
                    <?php if($gestor->fetch_usuario_es_responsable($usuario["idUsuario"])) { ?>
                    <li class="list-group-item text-right">
                        <span class="pull-left">
                            <strong class="text-success">Usuario Responsable</strong>
                        </span>
                        <span class="material-icons text-success"> check_circle </span>
                    </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="col-sm-8" style="margin-top: 50px;">
                <ul class="nav nav-tabs" id="secciones" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="postulaciones-tab" data-bs-toggle="tab" href="#postulaciones" role="tab" aria-controls="postulaciones" aria-selected="true">Postulaciones (2)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="publicaciones-tab" data-bs-toggle="tab" href="#publicaciones" role="tab" aria-controls="profile" aria-selected="false">Mis Publicaciones (<?= $gestor->fetch_num_publicaciones_activas_por_usuario($usuario["idUsuario"]) ?>)</a>
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
    <?php 
    $publicaciones = $gestor->fetch_publicaciones_por_usuario($usuario["idUsuario"]);
    foreach ($publicaciones as $pub) { 
        if ($pub["estado"] != 2) { ?>
            <a href="publicacionSimple.php?idPublicacion=<?= $pub['idPublicacion'] ?>" class="text-decoration-none">
                <div class="card border-success">
                    <div class="card-body card-publicacion">
                        <h5 class="card-title"><?= htmlspecialchars($pub["titulo"]) ?></h5>
                        <h6 class="card-subtitle mb-2 text-success">
                            <?= ($pub["estado"] == 0) ? "Disponible" : "En espera"; ?>
                        </h6>
                        <h6 class="card-subtitle mb-2 text-muted">Origen: <?= htmlspecialchars($pub["localidadOrigen"]) ?> - <?= htmlspecialchars($pub["provinciaOrigen"]) ?></h6>
                        <h6 class="card-subtitle mb-2 text-muted">Destino: <?= htmlspecialchars($pub["localidadDestino"]) ?> - <?= htmlspecialchars($pub["provinciaDestino"]) ?></h6>
                        <p class="card-text">Descripción: <?= htmlspecialchars($pub["descripcion"]); ?></p>
                    </div>
                </div>
            </a>
        <?php } else { ?>
            <a href="publicacionSimple.php?idPublicacion=<?php echo $pub['idPublicacion'] ?>" class="text-decoration-none">
                <div class="card border-muted">
                    <div class="card-body card-publicacion">
                        <h5 class="card-title"><?= htmlspecialchars($pub["titulo"]) ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Finalizada</h6>
                        <h6 class="card-subtitle mb-2 text-muted">Origen: <?= htmlspecialchars($pub["localidadOrigen"]) ?> - <?= htmlspecialchars($pub["provinciaOrigen"]) ?></h6>
                        <h6 class="card-subtitle mb-2 text-muted">Destino: <?= htmlspecialchars($pub["localidadDestino"]) ?> - <?= htmlspecialchars($pub["provinciaDestino"]) ?></h6>
                        <p class="card-text">Descripción: <?= htmlspecialchars($pub["descripcion"]) ?></p>
                    </div>
                </div>
            </a>
        <?php }
    }
    ?>
</div>
                        
                        
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
    <?php 
    include 'modalLoginRegistro.php';
    include 'validarRegistro.php';
    ?>

<script>
    window.onload = function() {
        // Obtiene el valor del parámetro 'tab' en la URL
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');

        // Si existe el parámetro 'tab' y corresponde a 'publicaciones', activa la tab
        if (tab === 'publicaciones') {
            const publicacionesTab = new bootstrap.Tab(document.getElementById('publicaciones-tab'));
            publicacionesTab.show(); // Activa la tab 'publicaciones'
        } else if (tab === 'calificaciones') {
            const calificacionesTab = new bootstrap.Tab(document.getElementById('calificaciones-tab'));
            calificacionesTab.show(); // Activa la tab 'publicaciones'
        }
    };
</script>
</body>

</html>

<?php }