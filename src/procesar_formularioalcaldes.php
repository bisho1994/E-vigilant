<?php
// Incluir el archivo de conexión a la base de datos
include 'db/asambleistas.php';

// Establecer la zona horaria local
date_default_timezone_set('America/Guayaquil'); // Cambia según tu ubicación

// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario y sanearlos
    $username = mb_strtoupper(trim($_POST['username']), 'UTF-8'); // Usar mb_strtoupper para manejar tildes correctamente
    $numero_de_votos_totales = trim($_POST['numero_de_votos_totales']);
    $nombre_del_recinto = mb_strtoupper(trim($_POST['nombre_del_recinto']), 'UTF-8'); // Usar mb_strtoupper para manejar tildes correctamente
    $numero_de_mesa = trim($_POST['numero_de_mesa']);
    $Numero_de_acta = trim($_POST['Numero_de_acta']);
    $provincia = mb_strtoupper(trim($_POST['provincia']), 'UTF-8'); // Usar mb_strtoupper para manejar tildes correctamente
    $canton = mb_strtoupper(trim($_POST['canton']), 'UTF-8'); // Usar mb_strtoupper para manejar tildes correctamente
    $parroquia = mb_strtoupper(trim($_POST['parroquia']), 'UTF-8'); // Usar mb_strtoupper para manejar tildes correctamente

    // Obtener la fecha y hora local para registrar
    $fecha_registro = date("Y-m-d H:i:s");

    // Manejar la carga de la imagen
    $imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['imagen']['tmp_name'];
        $name = basename($_FILES['imagen']['name']);
        $upload_dir = 'uploads/'; // Directorio para almacenar las imágenes
        $target_file_name = pathinfo($name, PATHINFO_FILENAME) . '.webp'; // Cambiar extensión a .webp
        $target_file = $upload_dir . $target_file_name;

        // Verificar si el directorio existe, si no, crearlo
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Convertir la imagen cargada a formato webp
        $image_info = getimagesize($tmp_name); // Obtener tipo de imagen
        if ($image_info !== false) {
            switch ($image_info['mime']) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($tmp_name);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($tmp_name);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($tmp_name);
                    break;
                default:
                    echo '
                        <script>
                            alert("El archivo cargado no es una imagen válida.");
                            window.location = "alcaldes.php";
                        </script>
                    ';
                    exit();
            }

            // Guardar la imagen en formato webp
            if (imagewebp($image, $target_file)) {
                imagedestroy($image); // Liberar la memoria
                $imagen = $target_file; // Guardar la ruta del archivo .webp
            } else {
                echo '
                    <script>
                        alert("Error al convertir la imagen a formato webp.");
                        window.location = "alcaldes.php";
                    </script>
                ';
                exit();
            }
        } else {
            echo '
                <script>
                    alert("El archivo cargado no es una imagen válida.");
                    window.location = "alcaldes.php";
                </script>
            ';
            exit();
        }
    }

    // Preparar la declaración SQL para insertar los datos en la base de datos
    $sql = "INSERT INTO usuarios (username, numero_de_votos_totales, nombre_del_recinto, numero_de_mesa, Numero_de_acta, provincia, canton, parroquia, imagen, fecha_registro) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Error en la preparación de la declaración: ' . $conn->error);
    }

    // Vincular los parámetros (s = string, i = integer)
    $stmt->bind_param('sissssssss', $username, $numero_de_votos_totales, $nombre_del_recinto, $numero_de_mesa, $Numero_de_acta, $provincia, $canton, $parroquia, $imagen, $fecha_registro);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        echo '
            <script>
                alert("Datos del almacenados correctamente");
                window.location = "alcaldes.php"; // Redirigir a la página de inicio (ajústalo según tu caso)
            </script>
        '; 
    } else {
        echo '
            <script>
                alert("Hubo un error al almacenar los datos");
                window.location = "alcaldes.php"; // Redirigir al formulario para corregir
            </script>
        ';
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>