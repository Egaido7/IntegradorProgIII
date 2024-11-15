<?php
class GestorVeryDeli {
    private $conn; //conexion a la bd
    private $stmt; //maneja los "statements" (sentencias)

    public function __construct() {
        include "conectardb.php";
        $this->conn = $conexion;
    }

    public function insertar_usuario($nombre, $apellido, $dni, $email, $pwd) {
        try {
            $this->stmt = $this->conn->prepare("INSERT INTO usuario(nombre, apellido, dni, email, contraseña) VALUES (?,?,?,?,?)");
            $dni = intval($dni);
            $this->stmt->bind_param("ssiss", $nombre, $apellido, $dni, $email, $pwd);
            $this->stmt->execute();
            return $this->stmt->affected_rows;
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al insertar un nuevo usuario: " . $e->getMessage());
        }
    }
    
    public function fetch_escape_string($str) {
        return $this->conn->escape_string($str);
    }

    public function insertar_publicacion($idUsuario, $volumenProducto, $pesoProducto, $fechaPublicacion, $imagen, $descripcionProducto, $nombreRecibir, $nombreContacto, $titulo, $localidadOrigen, $localidadDestino, $domicilioOrigen, $domicilioDestino) {
        try {
            // Preparar la sentencia SQL sin el campo de autoincremento `idPublicacion`
            $this->stmt = $this->conn->prepare("INSERT INTO publicacion(idUsuario, volumen, peso, fechaPublicacion, imagenPublicacion, descripcion, nombreRecibir, contacto, titulo, localidadOrigen, localidadDestino, domicilioOrigen, domicilioDestino) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
    
            // Definir tipos de parámetros: 'i' para integer, 'd' para double, 's' para string
            $this->stmt->bind_param("iddssssssssss", $idUsuario, $volumenProducto, $pesoProducto, $fechaPublicacion, $imagen, $descripcionProducto, $nombreRecibir, $nombreContacto, $titulo, $localidadOrigen, $localidadDestino, $domicilioOrigen, $domicilioDestino);
    
            // Ejecutar la consulta
            $this->stmt->execute();
    
            // Retornar el número de filas afectadas
            return $this->stmt->affected_rows;
        } catch (mysqli_sql_exception $e) {
            // Manejo de errores
            throw new Exception("Error al insertar una nueva publicación: " . $e->getMessage());
        }
    }
    
    public function insertar_mensaje($idUsuario, $idPublicacion, $comentario,$fecha,$hora) {
        try {
            $this->stmt = $this->conn->prepare("INSERT INTO mensaje(idUsuario, idPublicacion, comentario,fechaComentario,hora)
            VALUES (?,?,?,?,?)");
            $this->stmt->bind_param("iisss",$idUsuario, $idPublicacion, $comentario,$fecha,$hora);
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

    public function insertar_calificacion($idCalifica, $puntaje, $comentario,$idCalificado,$idPublicacion ,$fecha) {
        try {
            $this->stmt = $this->conn->prepare("INSERT INTO calificacion(idCalifica, puntaje,
            comentario, idCalificado,idPublicacion,fecha) VALUES (?,?,?,?,?,?)");
            $this->stmt->bind_param("iisiis", $idCalifica, $puntaje, $comentario, $idCalificado,$idPublicacion,$fecha);
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
            $this->stmt->bind_param("siss",$patente, $idUsuario, $modelo, $categoria);
            $this->stmt->execute();
            return $this->stmt->affected_rows;
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al insertar un nuevo vehiculo: " . $e->getMessage());
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

    public function fetch_nombre_usuario_por_id($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT nombre, apellido FROM usuario WHERE idUsuario = ?");
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
                $this->stmt = $this->conn->prepare("SELECT COUNT(*) FROM publicacion WHERE idUsuario = ? AND estado != 2");
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
                 ON p.idPublicacion = pub.idPublicacion WHERE p.idUsuario = ? AND pub.estado != 2");
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

    public function fetch_publicaciones_por_origen($localidadOrigen) {
        try {
            $sql = "
            SELECT 
                u.imagen AS usuarioImagen, 
                u.nombre AS usuarioNombre, 
                u.apellido AS usuarioApellido, 
                p.localidadOrigen,
                pr_origen.nombre AS nombreProvinciaOrigen,
                p.localidadDestino,
                pr_destino.nombre AS nombreProvinciaDestino,
                p.volumen, 
                p.peso, 
                p.imagenPublicacion,
                p.titulo,
                p.descripcion,
                p.estado
            FROM publicacion p
            JOIN usuario u ON p.idUsuario = u.idUsuario
            JOIN localidad l_origen ON p.localidadOrigen = l_origen.idLocalidad
            JOIN provincia pr_origen ON pr_origen.idProvincia = l_origen.idProvincia
            JOIN localidad l_destino ON p.localidadDestino = l_destino.idLocalidad
            JOIN provincia pr_destino ON pr_destino.idProvincia = l_destino.idProvincia
            WHERE p.localidadOrigen = ?
            AND p.estado = 0
        ";
            $this->stmt = $this->conn->prepare($sql);
            $this->stmt->bind_param("i", $localidadOrigen);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_publicaciones_por_destino($localidadDestino) {
        try {
            $sql = "
            SELECT 
                u.imagen AS usuarioImagen, 
                u.nombre AS usuarioNombre, 
                u.apellido AS usuarioApellido, 
                p.localidadOrigen,
                pr_origen.nombre AS nombreProvinciaOrigen,
                p.localidadDestino,
                pr_destino.nombre AS nombreProvinciaDestino,
                p.volumen, 
                p.peso, 
                p.imagenPublicacion,
                p.titulo,
                p.descripcion,
                p.estado
            FROM publicacion p
            JOIN usuario u ON p.idUsuario = u.idUsuario
            JOIN localidad l_origen ON p.localidadOrigen = l_origen.idLocalidad
            JOIN provincia pr_origen ON pr_origen.idProvincia = l_origen.idProvincia
            JOIN localidad l_destino ON p.localidadDestino = l_destino.idLocalidad
            JOIN provincia pr_destino ON pr_destino.idProvincia = l_destino.idProvincia
            WHERE p.localidadDestino = ?
            AND p.estado = 0
        ";
            $this->stmt = $this->conn->prepare($sql);
            $this->stmt->bind_param("i", $localidadDestino);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }


    public function fetch_publicaciones_por_origen_y_destino($localidadOrigen, $localidadDestino) {
        try {
            $sql = "
            SELECT 
                u.imagen AS usuarioImagen, 
                u.nombre AS usuarioNombre, 
                u.apellido AS usuarioApellido, 
                p.localidadOrigen,
                pr_origen.nombre AS nombreProvinciaOrigen,
                p.localidadDestino,
                pr_destino.nombre AS nombreProvinciaDestino,
                p.volumen, 
                p.peso, 
                p.imagenPublicacion,
                p.titulo,
                p.descripcion,
                p.estado
            FROM publicacion p
            JOIN usuario u ON p.idUsuario = u.idUsuario
            WHERE p.localidadOrigen = ? AND p.localidadDestino= ?
            AND p.estado = 0
        ";
            $this->stmt = $this->conn->prepare($sql);
            $this->stmt->bind_param("ss", $localidadOrigen, $localidadDestino);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }


    


    public function fetch_publicaciones_por_peso($pesoPaquete) {
        try {
            $sql = "
                SELECT 
                    u.imagen AS usuarioImagen, 
                    u.nombre AS usuarioNombre, 
                    u.apellido AS usuarioApellido, 
                    p.volumen, 
                    p.peso, 
                    p.localidadOrigen, 
                    p.localidadDestino, 
                    p.imagenPublicacion,
                    p.titulo,
                    p.descripcion,
                    p.estado
                FROM publicacion p
                JOIN usuario u ON p.idUsuario = u.idUsuario
                WHERE p.volumen = ?
                AND p.estado = 0
            ";
            
            $this->stmt = $this->conn->prepare($sql);
            $this->stmt->bind_param("i", $pesoPaquete);
            $this->stmt->execute();
            
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_publicaciones_por_usuario($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * FROM publicacion WHERE idUsuario = ? ORDER BY estado ASC;");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_num_publicaciones_activas_por_usuario($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT COUNT(*) FROM publicacion WHERE idUsuario = ? AND estado != 2");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_row()[0];
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_publicaciones_filtradas($localidadOrigen, $pesoPaquete, $localidadDestino) {
        try {
            $sql = "
                SELECT 
                    u.imagen AS usuarioImagen, 
                    u.nombre AS usuarioNombre, 
                    u.apellido AS usuarioApellido, 
                    p.volumen, 
                    p.peso, 
                    p.localidadOrigen, 
                    p.localidadDestino, 
                    p.localidadOrigen, 
                    p.localidadDestino, 
                    p.imagenPublicacion,
                    p.titulo,
                    p.descripcion,
                    p.estado
                FROM publicacion p
                JOIN usuario u ON p.idUsuario = u.idUsuario
                WHERE p.localidadOrigen = ? AND p.volumen = ? AND p.localidadDestino = ? AND
                p.estado = 0
            ";
            
            $this->stmt = $this->conn->prepare($sql);
            if (!$this->stmt) {
                throw new Exception("Error en la consulta SQL: " . $this->conn->error);
            }
            
            $this->stmt->bind_param("sis", $localidadOrigen, $pesoPaquete, $localidadDestino);
            $this->stmt->execute();
            
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_provinciaYLocalidad_por_idLocalidad($idLocalidad) {
        try {
            $this->stmt = $this->conn->prepare("SELECT p.nombre, l.Nombrelocalidad FROM provincia p
            JOIN localidad l ON p.idProvincia = l.idProvincia
            WHERE l.idLocalidad = ?");
            $this->stmt->bind_param("i", $idLocalidad);
            $this->stmt->execute();
            $resultado = $this->stmt->get_result()->fetch_assoc();
            return $resultado["Nombrelocalidad"] . ", " . $resultado["nombre"];
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
                    p.idPublicacion,
                    p.localidadOrigen, 
                    p.localidadDestino, 
                    p.imagenPublicacion,
                    p.titulo,
                    p.descripcion,
                    p.estado 
                FROM publicacion p
                JOIN usuario u ON p.idUsuario = u.idUsuario AND
                p.estado = 0
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
                    <img class="user__avatar post__avatar" src="imagenes/<?php echo $publicacion['usuarioImagen'] ?>" alt="xd">
                    <div class="post__topInfo">
                        <h3><?= htmlspecialchars($publicacion['usuarioNombre'])?> <?php htmlspecialchars($publicacion['usuarioApellido']) ?></h3>
                        <p> <?= date("d M Y H:i") ?></p>
                    </div>
                </div>

            
                <div class="post__details">
                <p>nombre de producto: <?= htmlspecialchars($publicacion['titulo']) ?></p>
                <p>Descripcion: <?= htmlspecialchars($publicacion['descripcion']) ?></p>
                    <p>Volumen: <?= htmlspecialchars($publicacion['volumen']) ?> m³</p>
                    <p>Peso: <?= htmlspecialchars($publicacion['peso']) ?> kg</p>
                    <p>Origen: <?= $this->fetch_provinciaYLocalidad_por_idLocalidad($publicacion['localidadOrigen']) ?></p>
                    <p>Destino: <?= $this->fetch_provinciaYLocalidad_por_idLocalidad($publicacion['localidadDestino']) ?></p>
                </div>

            
                <div class="post__image">
                    <?php //Si la publicación no tiene imagen definida se muestra la imagen por defecto
                  if(!isset($publicacion['imagenPublicacion'])) { ?>
                        <img src="imagenes/publicacionDefault.jpg" alt="Imagen del producto">
                    <?php } else {?>
                        <img src="<?=$publicacion['imagenPublicacion']?>" alt="Imagen del producto">
                    <?php } ?>
                </div>
                <div class="post__options">
                        
                <div class="post__option">
                <span class="material-icons"> near_me </span>
                <form action="./index.php" method="POST">
                    <input type="submit"  id="verPublicacion"  name = "verPublicacion"value="postularse"  class="btn btn-link p-0" style="text-decoration: none; color: inherit;">     
                    <input type="hidden" name="Publicacion" value="<?= $publicacion['idPublicacion'] ?>">
                </form>
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
            $this->stmt = $this->conn->prepare("SELECT * FROM calificacion WHERE idCalificado = ?");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_calificaciones_hechas_por_usuario($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * FROM calificacion WHERE idCalifica = ?");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_num_calificaciones_por_usuario($idUsuario) {
        return count($this->fetch_calificaciones_por_usuario($idUsuario));
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
            $this->stmt = $this->conn->prepare("SELECT * FROM vehiculo WHERE idUsuario = ?");
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
        if($cant_calif == 0) {
            return "";
        } else {
            $promedio = $suma_puntajes / $cant_calif;
            return round($promedio * 2) / 2; // Esta expresión trunca el promedio a intervalos de 0.5
        }
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
    public function fetch_publicacion($idPublicacion) {
        try {
            $this->stmt = $this->conn->prepare("SELECT 
                    u.imagen AS usuarioImagen, 
                    u.nombre AS usuarioNombre, 
                    u.apellido AS usuarioApellido, 
                    p.volumen, 
                    p.peso, 
                    p.idPublicacion,
                    p.idUsuario,
                    p.descripcion,
                    p.titulo,
                    p.imagenPublicacion,
                    p.contacto,
                    p.postulanteElegido,
                    p.estado,
                    p.localidadOrigen,
                    p.localidadDestino,
                    p.domicilioOrigen,
                    p.domicilioDestino,
                    p.nombreRecibir,
                    p.fechaPublicacion
                FROM publicacion p
                JOIN usuario u ON p.idUsuario = u.idUsuario
                WHERE p.idPublicacion = ?");
    
            // Comprobación de errores en la preparación de la consulta
            if (!$this->stmt) {
                throw new Exception("Error en la consulta SQL: " . $this->conn->error);
            }
    
            // Vincular el parámetro
            $this->stmt->bind_param("i", $idPublicacion);
            $this->stmt->execute();
    
            // Obtener solo un resultado
            $result = $this->stmt->get_result();
            return $result->fetch_assoc(); // Devolver solo la primera fila como un arreglo asociativo
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        } finally {
            // Cerrar la declaración si se ha creado
            if ($this->stmt) {
                $this->stmt->close();
            }
        }
    }
    public function insertar_postulante($usuario_id, $monto, $publicacion_id, $estado) {
        // Preparar la sentencia
        $stmt = $this->conn->prepare("INSERT INTO postulacion (idUsuario, monto, idPublicacion, alerta) VALUES (?, ?, ?, ?)");
    
        // Verificar si la preparación fue exitosa
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conn->error);
        }
    
        // Ligar los parámetros y ejecutar la consulta
        $stmt->bind_param("iiii", $usuario_id, $monto, $publicacion_id, $estado);
        
        if (!$stmt->execute()) {
            die("Error en la ejecución de la consulta: " . $stmt->error);
        }
    
        // Cerrar la declaración
        $stmt->close();
    }
    public function tiene_vehiculo_por_usuario($idUsuario) {
        try {
            // Verificar si la conexión está bien establecida
            if (!$this->conn) {
                throw new Exception("Error de conexión a la base de datos: " . mysqli_connect_error());
            }
    
            // Preparamos la consulta SQL con COUNT(*) para optimización
            $sql = "SELECT COUNT(*) FROM vehiculo WHERE idUsuario = ?";
            $this->stmt = $this->conn->prepare($sql);
            
            // Verificamos si la consulta se preparó correctamente
            if (!$this->stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            }
    
            // Vinculamos el parámetro
            $this->stmt->bind_param("i", $idUsuario);
            
            // Ejecutamos la consulta
            $this->stmt->execute();
            
            // Obtenemos el resultado
            $result = $this->stmt->get_result();
            
            // Verificamos si el usuario tiene vehículos asociados
            $row = $result->fetch_row();
            if ($row[0] > 0) {
                // Si tiene vehículos, devolvemos true
                return true;
            } else {
                // Si no tiene vehículos, devolvemos false
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            // Manejo de excepciones con un mensaje más descriptivo
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }
    public function es_postulante($idUsuario, $idPublicacion) {
        try {
            // Verificar si la conexión está bien establecida
            if (!$this->conn) {
                throw new Exception("Error de conexión a la base de datos: " . mysqli_connect_error());
            }
    
            // Preparamos la consulta SQL con COUNT(*) para optimización
            $sql = "SELECT COUNT(*) FROM postulacion WHERE idUsuario = ? AND idPublicacion = ?";
            $stmt = $this->conn->prepare($sql);
            
            // Verificamos si la consulta se preparó correctamente
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            }
    
            // Vinculamos los parámetros
            $stmt->bind_param("ii", $idUsuario, $idPublicacion); // Cambié $idPostulacion por $idPublicacion
            
            // Ejecutamos la consulta
            $stmt->execute();
            
            // Obtenemos el resultado
            $result = $stmt->get_result();
            
            // Verificamos si el usuario tiene postulacion en la publicacion
            $row = $result->fetch_row();
            
            // Si COUNT(*) es mayor que 0, el usuario ha postulado a la publicación
            if ($row[0] > 0) {
                // Si tiene postulacion, devolvemos true
                return true;
            } else {
                // Si no tiene postulacion, devolvemos false
                return false;
            }
            
        } catch (Exception $e) {
            // Manejo de excepciones con un mensaje más descriptivo
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        } finally {
            // Cerramos la consulta preparada
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }
    public function actualizar_postulanteElegido($idPublicacion, $postulante) {
        try {
            // Preparar la consulta SQL para actualizar el postulante elegido
            $this->stmt = $this->conn->prepare("UPDATE publicacion SET postulanteElegido = ?, estado = 1 WHERE idPublicacion = ?;");
            
            // Enlazar los parámetros: 'i' para enteros
            $this->stmt->bind_param("ii", $postulante, $idPublicacion);
            
            // Ejecutar la consulta
            $this->stmt->execute();
            
            // Verificar cuántas filas fueron afectadas
            $filasAfectadas = $this->stmt->affected_rows;
            
            // Retornar el número de filas afectadas
            return $filasAfectadas;
    
        } catch (mysqli_sql_exception $e) {
            // Lanzar una excepción en caso de error
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }
    public function usuario_califico($idUsuario,$idPublicacion) {
    
            try {
            
                $this->stmt = $this->conn->prepare("SELECT COUNT(*) FROM calificacion WHERE idCalifica = ? AND idPublicacion = ?");
                $this->stmt->bind_param("ii", $idUsuario,$idPublicacion);
                $this->stmt->execute();
                $this->stmt->bind_result($cant_calificacion);
                $this->stmt->fetch();

                // si el usuario califico la publicacion
                if($cant_calificacion == 1) {
                    return 0;
                } else {
                    return 1;
                }
            } catch (mysqli_sql_exception $e) {
                throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
                return false;
            
        }
    }

    public function publicacion_calificada($idPublicacion) {
        try {
            // Preparar la consulta
            $this->stmt = $this->conn->prepare("SELECT COUNT(*) FROM calificacion WHERE idPublicacion = ?");
    
            // Verifica si `prepare()` ha fallado
            if (!$this->stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->conn->error);
            }
    
            // Enlaza el parámetro
            if (!$this->stmt->bind_param("i", $idPublicacion)) {
                throw new Exception("Error al enlazar el parámetro: " . $this->stmt->error);
            }
    
            // Ejecuta la consulta
            if (!$this->stmt->execute()) {
                throw new Exception("Error en la ejecución de la consulta: " . $this->stmt->error);
            }
    
            // Enlaza el resultado
            $this->stmt->bind_result($cant_calificacion);
            $this->stmt->fetch();
    
            // Si se calificaron ambos usuarios
            return $cant_calificacion == 2 ? 1 : 0;
        } catch (Exception $e) {
            // Mostrar el mensaje de error
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            // Cierra la declaración
            if ($this->stmt) {
                $this->stmt->close();
            }
        }
    }
    public function usuario_yaExiste($email) {
        try {
            $this->stmt = $this->conn->prepare("SELECT email FROM usuario WHERE email = ?");
            $this->stmt->bind_param("s", $email);
            $this->stmt->execute();
            return $this->stmt->num_rows() > 0;
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    //Retorna el ID autoincremental generado en la última consulta
    public function fetch_insert_id() {
        return $this->conn->insert_id;
    }

    public function verificar_credenciales_usuario($email, $pwd) {
        try {
            $this->stmt = $this->conn->prepare("SELECT idUsuario FROM usuario WHERE email = ? AND contraseña = ?");
            $this->stmt->bind_param("ss", $email, $pwd);
            $this->stmt->execute();
            return $this->stmt->get_result();
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }
    public function fetch_calificaciones_por_publicacion($idUsuario, $idPublicacion) {
        try {
            // Prepara la consulta
            $this->stmt = $this->conn->prepare("SELECT * FROM calificacion WHERE idCalifica = ? AND idPublicacion = ?");
            
            // Verifica si la preparación fue exitosa
            if ($this->stmt === false) {
                throw new Exception("Error al preparar la consulta SQL.");
            }
            
            // Vincula los parámetros
            $this->stmt->bind_param("ii", $idUsuario, $idPublicacion);
            
            // Ejecuta la consulta
            $this->stmt->execute();
            
            // Obtiene todos los resultados
            $resultado = $this->stmt->get_result()->fetch_assoc();
            
            // Si no hay resultados, retorna null
            if (empty($resultado)) {
                return null;
            }
            
            return $resultado;  // Devuelve el arreglo con todas las calificaciones encontradas
        } catch (Exception $e) {
            // Captura el error y muestra un mensaje controlado
            error_log("Error al ejecutar la consulta: " . $e->getMessage()); // Log del error para desarrolladores
            return null; // Retorna null si ocurre un error
        }
        }
    public function actualizar_publicacionFinalizada($idPublicacion,$fecha) {
        try {
            // Preparar la consulta SQL para actualizar el postulante elegido
            $this->stmt = $this->conn->prepare("UPDATE publicacion SET fechaPublicacion = ?, estado = 2 WHERE idPublicacion = ?;");
            
            // Enlazar los parámetros: 'i' para enteros
            $this->stmt->bind_param("si", $fecha, $idPublicacion);
            
            // Ejecutar la consulta
            $this->stmt->execute();
            
            // Verificar cuántas filas fueron afectadas
            $filasAfectadas = $this->stmt->affected_rows;
            
            // Retornar el número de filas afectadas
            return $filasAfectadas;
    
        } catch (mysqli_sql_exception $e) {
            // Lanzar una excepción en caso de error
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function tiene_maximo_vehiculos($idPublicacion) {
        try {
            // Preparar la consulta
            $this->stmt = $this->conn->prepare("SELECT COUNT(*) FROM vehiculo WHERE idUsuario = ?");
    
            // Verifica si `prepare()` ha fallado
            if (!$this->stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->conn->error);
            }
    
            // Enlaza el parámetro
            if (!$this->stmt->bind_param("i", $idPublicacion)) {
                throw new Exception("Error al enlazar el parámetro: " . $this->stmt->error);
            }
    
            // Ejecuta la consulta
            if (!$this->stmt->execute()) {
                throw new Exception("Error en la ejecución de la consulta: " . $this->stmt->error);
            }
    
            // Enlaza el resultado
            $this->stmt->bind_result($tiene);
            $this->stmt->fetch();
    
            // Si se calificaron ambos usuarios
            return $tiene == 2 ? 1 : 0;
        } catch (Exception $e) {
            // Mostrar el mensaje de error
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            // Cierra la declaración
            if ($this->stmt) {
                $this->stmt->close();
            }
        }
    }



    public function tiene_maximo_vehiculos_para_Ingresar($idUsuario) {
        try {
            if (!$this->conn) {
                throw new Exception("Error de conexión a la base de datos: " . mysqli_connect_error());
            }
    
            $sql = "SELECT COUNT(*) FROM vehiculo WHERE idUsuario = ?";
            $this->stmt = $this->conn->prepare($sql);
            
            if (!$this->stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            }
    
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
    
            $result = $this->stmt->get_result();
            $row = $result->fetch_row();
    
            // Verifica si el número de vehículos es 2 o más
            return $row[0] >= 2; // Devuelve true solo si el usuario tiene 2 o más vehículos
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function obtener_vehiculos_por_usuario($idUsuario) {
        try {
            $sql = "SELECT patente, modelo, categoria FROM vehiculo WHERE idUsuario = ?";
            $stmt = $this->conn->prepare($sql);
    
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            }
    
            $stmt->bind_param("i", $idUsuario);
            $stmt->execute();
            $result = $stmt->get_result();
    
            // Crea un arreglo para almacenar los vehículos
            $vehiculos = [];
            while ($row = $result->fetch_assoc()) {
                $vehiculos[] = $row;
            }
    
            return $vehiculos;
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al obtener vehículos: " . $e->getMessage());
        }
    }
    
    

    public function fetch_nombre_provincia_por_id($idProvincia) {
        try {
            $this->stmt = $this->conn->prepare("SELECT nombre FROM provincia WHERE idProvincia = ?");
            $this->stmt->bind_param("i", $idProvincia);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_assoc()["nombre"];
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_nombre_localidad_por_id($idLocalidad) {
        try {
            $this->stmt = $this->conn->prepare("SELECT Nombrelocalidad FROM localidad WHERE idLocalidad = ?");
            $this->stmt->bind_param("i", $idLocalidad);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_assoc()["Nombrelocalidad"];
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_provincias() {
        try {
            $this->stmt = $this->conn->prepare("SELECT * FROM provincia");
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_provincias_ALL() {
        try {
            $sql = "SELECT nombreProvincia, idProvincia FROM provincia";
            $this->stmt = $this->conn->prepare($sql);
    
            if (!$this->stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            }
    
            $this->stmt->execute();
            $result = $this->stmt->get_result();
    
            // Devuelve todas las provincias en un arreglo
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    
    public function fetch_publicaciones_por_busqueda($localidad) { 
        try {
            $sql = "
            SELECT 
                u.imagen AS usuarioImagen, 
                u.nombre AS usuarioNombre, 
                u.apellido AS usuarioApellido, 
                p.volumen, 
                p.peso, 
                p.localidadOrigen,
                p.localidadDestino,
                p.imagenPublicacion,
                p.idPublicacion,
                p.titulo,
                p.descripcion,
                p.estado
            FROM publicacion p
            JOIN usuario u ON p.idUsuario = u.idUsuario
            WHERE (p.localidadOrigen = ? OR p.localidadDestino = ?)
            AND p.estado = 0
            ";
            
            $this->stmt = $this->conn->prepare($sql);
    
            if (!$this->stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            }
    
            // Vincula el parámetro en las cuatro condiciones de búsqueda
            $this->stmt->bind_param("ss", $localidad, $localidad);
            $this->stmt->execute();
            
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }
    
    
}
