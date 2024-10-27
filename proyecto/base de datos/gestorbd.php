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
            $this->stmt = $this->conn->prepare("SELECT * from usuario");
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_usuario_por_id($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * from usuario WHERE idUsuario = ?");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_assoc();
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_publicaciones_por_origen($origen) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * from publicacion WHERE origen = ?");
            $this->stmt->bind_param("s", $origen);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_publicaciones_por_usuario($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * from publicacion WHERE idUsuario = ?");
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

        // Iterar sobre cada publicación y generar el HTML
        foreach ($publicaciones as $publicacion) {
            echo '<div class="post">';
            echo '  <div class="post__top">';
            echo '      <img class="user__avatar post__avatar" src="data:image/png;base64,' . $publicacion['usuarioImagen'] . '" alt="Foto de usuario">';
            echo '      <div class="post__topInfo">';
            echo '          <h3>' . htmlspecialchars($publicacion['usuarioNombre']) . ' ' . htmlspecialchars($publicacion['usuarioApellido']) . '</h3>';
            echo '          <p>' . date("d M Y H:i") . '</p>'; // Ejemplo de fecha actual, ajustar si se requiere un campo de fecha específico
            echo '      </div>';
            echo '  </div>';

            // Detalles de la publicación
            echo '  <div class="post__details">';
            echo '      <p>Volumen: ' . htmlspecialchars($publicacion['volumen']) . ' m³</p>';
            echo '      <p>Peso: ' . htmlspecialchars($publicacion['peso']) . ' kg</p>';
            echo '      <p>Origen: ' . htmlspecialchars($publicacion['origen']) . '</p>';
            echo '      <p>Destino: ' . htmlspecialchars($publicacion['destino']) . '</p>';
            echo '  </div>';

            // Imagen del producto
            echo '  <div class="post__image">';
            echo '      <img src="data:image/png;base64,' . $publicacion['imagenProducto'] . '" alt="Imagen del producto">';
            echo '  </div>';
            echo '</div>';
        }
    }

    public function fetch_postulaciones_por_publicacion($idPublicacion) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * from postulacion WHERE idPublicacion = ?");
            $this->stmt->bind_param("i", $idPublicacion);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_postulaciones_por_usuario($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * from postulacion WHERE idUsuario = ?");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_calificaciones_por_usuario($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * from calificacion WHERE idUsuario = ?");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_calificaciones_por_usuario_ultimas3($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * from calificacion WHERE idUsuario = ? ORDER BY idCalificacion DESC LIMIT 3");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }

    public function fetch_vehiculos_por_usuario($idUsuario) {
        try {
            $this->stmt = $this->conn->prepare("SELECT * from vehiculos WHERE idUsuario = ?");
            $this->stmt->bind_param("i", $idUsuario);
            $this->stmt->execute();
            return $this->stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Error al acceder a la base de datos: " . $e->getMessage());
        }
    }
    
}