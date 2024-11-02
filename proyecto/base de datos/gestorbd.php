<?php
class GestorVeryDeli {
    private $conn; //conexion a la bd
    private $stmt; //maneja los "statements" (sentencias)

    public function __construct() {
        include "conectardb.php";
        $this->conn = $conexion;
    }

    public function insertar_usuario($id, $nombre, $apellido, $dni, $resp, $email, $domicilio, $codPostal, $pwd, $img) {
        try {
            $this->stmt = $this->conn->prepare("INSERT INTO usuario(idUsuario, nombre, apellido, dni, responsable,
            email, domicilio, codPostal, contraseña, imagen) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $this->stmt->bind_param($id, $nombre, $apellido, $dni, $resp, $email, $domicilio, $codPostal, $pwd, $img);
            $this->stmt->execute();
            return $this->stmt->affected_rows;
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al insertar un nuevo usuario: " . $e->getMessage());
        }
    }

    public function insertar_publicacion($idPublicacion, $idUsuario, $volumen, $peso, $origen, $destino) {
        try {
            $this->stmt = $this->conn->prepare("INSERT INTO publicacion(idPublicacion, idUsuario, volumen, peso, origen, destino)
            VALUES (?,?,?,?,?,?)");
            $this->stmt->bind_param($idPublicacion, $idUsuario, $volumen, $peso, $origen, $destino);
            $this->stmt->execute();
            return $this->stmt->affected_rows;
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al insertar un nuevo usuario: " . $e->getMessage());
        }
    }

    public function insertar_mensaje($idUsuario, $idPublicacion, $comentario) {
        try {
            $this->stmt = $this->conn->prepare("INSERT INTO mensaje(idUsuario, idPublicacion, comentario)
            VALUES (?,?,?)");
            $this->stmt->bind_param($idUsuario, $idPublicacion, $comentario);
            $this->stmt->execute();
            return $this->stmt->affected_rows;
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al insertar un nuevo usuario: " . $e->getMessage());
        }
    }

    public function insertar_postulacion($idPostulacion, $idUsuario, $idPublicacion, $monto) {
        try {
            $this->stmt = $this->conn->prepare("INSERT INTO postulacion(idPostulacion, idUsuario, idPublicacion, monto)
            VALUES (?,?,?,?)");
            $this->stmt->bind_param($idPostulacion, $idUsuario, $idPublicacion, $monto);
            $this->stmt->execute();
            return $this->stmt->affected_rows;
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al insertar un nuevo usuario: " . $e->getMessage());
        }
    }

    public function insertar_calificacion($idCalificacion, $idCalifica, $idCalificado, $puntaje, $comentario) {
        try {
            $this->stmt = $this->conn->prepare("INSERT INTO calificacion(idCalificacion, idCalifica, puntaje,
            comentario, idCalificado) VALUES (?,?,?,?,?)");
            $this->stmt->bind_param($idCalificacion, $idCalifica, $puntaje, $comentario, $idCalificado);
            $this->stmt->execute();
            return $this->stmt->affected_rows;
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al insertar un nuevo usuario: " . $e->getMessage());
        }
    }

    public function insertar_vehiculo($patente, $idUsuario, $modelo, $categoria) {
        try {
            $this->stmt = $this->conn->prepare("INSERT INTO vehiculo(patente, idUsuario, modelo, categoria)
            VALUES (?,?,?,?)");
            $this->stmt->bind_param($patente, $idUsuario, $modelo, $categoria);
            $this->stmt->execute();
            return $this->stmt->affected_rows;
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al insertar un nuevo usuario: " . $e->getMessage());
        }
    }

    public function fetch_usuarios() {
        try {
            $this->stmt = $this->conn->prepare("SELECT * FROM usuario");
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_usuario_por_id($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * FROM usuario WHERE idUsuario = ?");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_assoc();
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    //retorna un booleano
    public function fetch_usuario_es_responsable($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT responsable FROM usuario WHERE idUsuario = ?");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_assoc() == 1;
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }
    
    //retorna un booleano
    public function usuario_puede_publicar($idUsuario) {
        if($this->fetch_usuario_es_responsable($idUsuario)) {
            return true;
        } else {
            try {
                //reemplazar 3 por el estado que implica que la publicacion está terminada
                $this->stmt = $this->conn->prepare("SELECT COUNT(*) FROM publicacion WHERE idUsuario = ? AND estado != 3");
                $this->stmt->bind_param("i", $idUsuario);
                $this->stmt->execute();
                $this->stmt->bind_result($cant_publicaciones);
                $this->stmt->fetch();

                // si el usuario no tiene mas de 3 publicaciones activas
                if($cant_publicaciones >= 3) {
                    return false;
                } else {
                    return true;
                }
            } catch (mysqli_sql_exception $e) {
                throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
                return false;
            }
        }
    }

    //retorna un booleano
    public function usuario_puede_postularse($idUsuario) {
        if($this->fetch_usuario_es_responsable($idUsuario)) {
            return true;
        } else {
            try {
                //reemplazar 3 por el estado que implica que la publicacion está terminada
                $this->stmt = $this->conn->prepare("SELECT COUNT(*) FROM postulacion p JOIN publicacion pub
                 ON p.idPublicacion = pub.idPublicacion WHERE p.idUsuario = ? AND pub.estado != 3");
                $this->stmt->bind_param("i", $idUsuario);
                $this->stmt->execute();
                $this->stmt->bind_result($cant_publicaciones);
                $this->stmt->fetch();
    
                if($cant_publicaciones >= 1) {
                    return false;
                } else {
                    return true;
                }
            } catch (mysqli_sql_exception $e) {
                throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
                return false;
            }
        }
    }

    public function fetch_publicaciones_por_origen($origen) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * FROM publicacion WHERE origen = ?");
            $this->stmt->bind_param("s", $origen);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_publicaciones_por_usuario($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * FROM publicacion WHERE idUsuario = ?");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_publicaciones() {
        try {
            $this->stmt = $this->conn->prepare("
                SELECT 
                    u.imagen AS usuarioImagen, 
                    u.nombre AS usuarioNombre, 
                    u.apellido AS usuarioApellido, 
                    p.volumen, 
                    p.peso, 
                    p.origen, 
                    p.destino, 
                    p.imagenProducto 
                FROM publicacion p
                JOIN usuario u ON p.idUsuario = u.idUsuario
            ");

            // Comprobación de errores en la preparación de la consulta
            if (!$this->stmt) {
                throw new Exception("Error en la consulta SQL: " . $this->conn->error);
            }
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    // Función para mostrar las publicaciones en HTML
    public function mostrar_publicaciones() {
        $publicaciones = $this->fetch_publicaciones();


        foreach ($publicaciones as $publicacion) { ?>
            <div class="post">
                <div class="post__top">
                    <img class="user__avatar post__avatar" src="data:image/png;base64,<?= $publicacion['usuarioImagen'] ?>" alt="xd">
                    <div class="post__topInfo">
                        <h3><?= htmlspecialchars($publicacion['usuarioNombre'])?> <?php htmlspecialchars($publicacion['usuarioApellido']) ?></h3>
                        <p> <?= date("d M Y H:i") ?></p>
                    </div>
                </div>

            
                <div class="post__details">
                    <p>Volumen: <?= htmlspecialchars($publicacion['volumen']) ?> m³</p>
                    <p>Peso: <?= htmlspecialchars($publicacion['peso']) ?> kg</p>
                    <p>Origen: <?= htmlspecialchars($publicacion['origen']) ?></p>
                    <p>Destino: <?= htmlspecialchars($publicacion['destino']) ?></p>
                </div>

            
                <div class="post__image">
                    <?php //Si la publicación no tiene imagen definida se muestra la imagen por defecto
                    if(empty($publicacion['imagenProducto'])) { ?>
                        <img src="imagenes/publicacionDefault.jpg" alt="Imagen del producto">
                    <?php } else {?>
                        <img src="data:image/png;base64,<?=$publicacion['imagenProducto']?>" alt="Imagen del producto">
                    <?php } ?>
                </div>
                <div class="post__options">

                <div class="post__option">
                <span class="material-icons"> near_me </span>
                <p>Postularse</p>
                </div>
            </div>
            </div>
        <?php }
    }

    public function fetch_postulaciones_por_publicacion($idPublicacion) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * FROM postulacion WHERE idPublicacion = ?");
            $this->stmt->bind_param("i", $idPublicacion);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_postulaciones_por_usuario($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * FROM postulacion WHERE idUsuario = ?");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_calificaciones_por_usuario($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * FROM calificacion WHERE idUsuario = ?");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_calificaciones_por_usuario_ultimas3($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * FROM calificacion WHERE idUsuario = ? ORDER BY idCalificacion DESC LIMIT 3");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_vehiculos_por_usuario($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * FROM vehiculos WHERE idUsuario = ?");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_promedio_calificaciones_por_usuario($idUsuario) {
        $cant_calif = 0;
        $suma_puntajes = 0;
        $calificaciones = $this->fetch_calificaciones_por_usuario($idUsuario);
        foreach($calificaciones as $calif) {
            if($calif["puntaje"] != -1) {
                $cant_calif++;
                $suma_puntajes += $calif["puntaje"];
            }
        }
        $promedio = $suma_puntajes / $cant_calif;
        return round($promedio * 2) / 2; // Esta expresión trunca el promedio a intervalos de 0.5
    }

    public function fetch_mensajes_por_publicacion($idPublicacion) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * FROM mensaje WHERE idPublicacion = ?");
            $this->stmt->bind_param("i", $idPublicacion);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }
}