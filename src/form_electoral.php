<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    header("Location: inicio.php"); // Redirigir al inicio si no está autenticado
    exit();
}

// Generar un token CSRF único si no existe
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Token único
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Alcaldes</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="/assets/vote.ico" type="image/x-icon">

    

    <style>
        /* Estilo general */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            box-sizing: border-box;
            overflow-y: auto; /* Permite desplazarse verticalmente */
            background-image: url('assets/login.jpg'); /* Ruta de la imagen */
            background-size: cover; /* Hace que la imagen cubra toda la pantalla */
            background-position: center; /* Centra la imagen */
            background-attachment: fixed; /* Fija la imagen mientras haces scroll */
            background-repeat: no-repeat; /* Evita que la imagen se repita */
           
        }
        .responsive-image {
            display: block; /* Hace que la imagen sea un bloque */
            margin: 40px auto; /* Centra la imagen y agrega margen arriba */
            max-width: 90%; /* Asegura que la imagen no se desborde en pantallas pequeñas */
            height: auto; /* Mantiene la relación de aspecto de la imagen */
            
        }
        
    


        .login {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 40px 30px;
            max-width: 600px;
            width: 100%;
            margin: 20px; /* Espacio adicional en móviles para permitir desplazamiento */
            box-sizing: border-box;
            ;
        }

        h1 {
            font-size: 25px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
             margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input, select, button {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input:focus, select:focus {
            border-color: #0061ff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 97, 255, 0.5);
        }

        button {
            background-color: #0061ff;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0051d4;
        }

        button:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(0, 97, 255, 0.5);
        }

        #espera {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none;
        }

        /* Estilo del botón de cerrar sesión */
        .logout-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #FF5733;
            color: white;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .logout-button:hover {
            background-color: #C70039;
        }

        /* Responsividad */
        @media (max-width: 600px) {
            
            .logout-button {
            margin: 100px  ; /* Centrar el botón debajo del formulario */
            text-align: center;
            width: fit-content; /* Ajusta el ancho al contenido */
            top: 1120px;
            right: 20px;
            
            }

            .responsive-image {
            display: block; /* Hace que la imagen sea un bloque */
            margin: -40px auto; /* Centra la imagen y agrega margen arriba */
            max-width: 100%; /* Asegura que la imagen no se desborde en pantallas pequeñas */
            height: auto; /* Mantiene la relación de aspecto de la imagen */
            }

            .login {
                
                padding: 70px 20px;
            }

            h1 {
                font-size: 30px;
                margin: 70px auto;
                margin-bottom: 25px;
            }

            label {
                font-size: 14px;
            }

            input, select, button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <!-- Div de espera -->
    <div id="espera">
        <div style="background: white; padding: 20px; border-radius: 8px; text-align: center;">
            <p><strong>Guardando datos...</strong></p>
            <img src="https://i.gifer.com/ZZ5H.gif" alt="Cargando..." width="50" height="50"> <!-- Un gif de carga -->
        </div>
    </div>

    


    
    <!-- Botón de cerrar sesión -->
    <a href="logout.php?csrf_token=<?= $_SESSION['csrf_token'] ?>" class="logout-button">Cerrar sesión</a>

    <div class="login">
        <form action="procesar_formularioalcaldes.php" method="post" style="text-transform: uppercase;" enctype="multipart/form-data">
            <div>
            <img src="/assets/voto.jpg" alt="Imagen descriptiva" class="responsive-image">
            </div>

            <h1>Registro de Datos</h1>

            <label for="username">Nombre del candidato</label>
            <input type="text" id="username" name="username" list="delegado-list" style="text-transform: uppercase;" required>
            <datalist id="delegado-list">
                <option value="Candidato 1">
                <option value="Candidato 2">
                <option value="Candidato 3">
            </datalist>

            <label for="numero_de_votos_totales">Votos totales del Candidato en el acta</label>
            <input type="number" id="numero_de_votos_totales" name="numero_de_votos_totales" min="0" style="text-transform: uppercase;" required>

            <label for="nombre_del_recinto">Nombre del recinto</label>
            <input type="text" id="nombre_del_recinto" name="nombre_del_recinto" list="recinto-list" style="text-transform: uppercase;" required>
            <datalist id="recinto-list">
                <option value="UNIDAD EDUCATIVA COMUNITARIA INTERCULTURAL BILINGUE ALMINDARIS">
                <option value="UNIDAD EDUCATIVA COMUNITARIA INTERCULTURAL BILINGUE GONZALO DAVID AVILEZ TANGUILA">
                <option value="CENTRO DE EDUCACIÓN BÁSICA 5 DE MARZO">
                <option value="UNIDAD EDUCATIVA COMUNITARIA INTERCULTURAL BILINGUE HUAMANI">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL LEONARDO MURIALDO / EDUCACION BASICA">
                <option value="CECIB PUMA URKU">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL JAIME ROLDOS AGUILERA / ELEMENTAL">
                <option value="UNIDAD EDUCATIVA COMUNITARIA INTERCULTURAL BILINGUE POROTOYACU">
                <option value="CANCHA CUBIERTA DE SAN PABLO DE USHPAYACU">
                <option value="UNIDAD EDUCATIVA ARCHIDONA / ESCUELA BLOQUE 2">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL MARIA INMACULADA/BACHILLERATO">
                <option value="UNIDAD EDUCATIVA ARCHIDONA / COLEGIO BLOQUE 1">
                <option value="UNIDAD EDUCATIVA JONDACHI">
                <option value="UNIDAD EDUCATIVA COMUNITARIO INTERCULTURAL BILINGUE BARTOLOME MARIN">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL JAIME ROLDOS AGUILERA / MEDIO">
                <option value="UNIDAD EDUCATIVA COMUNITARIA INTERCULTURAL BILINGUE 'MIGUEL TUNAY'">
                <option value="ESCUELA EDUCACION BASICA GENERAL MIGUEL ITURRALDE">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL JAIME ROLDOS AGUILERA/BACHILLERATO">
                <option value="UNIDAD EDUCATIVA COMUNITARIO INTERCULTURAL BILINGUE DE SAN PABLO">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL MARIA INMACULADA/EDUCACION BASICA">
                <option value="CENTRO EDUCATIVO INTERCULTURAL BILINGUE BASICA YAWARI">
                <option value="ESCUELA DE EDUCACIÓN BÁSICA FISCOMISIONAL 'PADRE JUAN VELASCO'">
                <option value="UNIDAD EDUCATIVA CARLOS JULIO AROSEMENA TOLA / BACHILLERATO">
                <option value="UNIDAD EDUCATIVA CARLOS JULIO AROSEMENA TOLA /EDUCACIÓN BÁSICA">
                <option value="ESCUELA DE EDUCACIÓN BÁSICA GENERAL MARAÑÓN">
                <option value="UNIDAD EDUCATIVA EL CHACO">
                <option value="ESCUELA DE EDUCACIÓN BÁSICA NAPO">
                <option value="ESCUELA FRAY VACAS GALINDO">
                <option value="UNIDAD EDUCATIVA DEL MILENIO DE SANTA ROSA">
                <option value="ESCUELA DE EDUCACIÓN GENERAL BÁSICA MÉXICO">
                <option value="ESCUELA DE EDUCACION BASICA GUSTAVO ADOLFO BECQUER">
                <option value="UNIDAD EDUCATIVA PADRE RAFAEL FERRER">
                <option value="ESCUELA FISCAL MIXTA 12 DE FEBRERO">
                <option value="ESCUELA DE ECUCACION BASICA NAPO - BLOQUE 2">
                <option value="ESCUELA DE EDUCACION BASICA ENRIQUE AVELINO SILVA">
                <option value="ESCUELA DE EDUCACIÓN GENERAL BÁSICA GIL RAMIREZ DAVALOS">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL JUAN BAUTISTA MONTINI / BACHILLERATO">
                <option value="UNIDAD EDUCATIVA BAEZA / BACHILLERATO">
                <option value="ESCUELA DE EDUCACIÓN BÁSICA MANUEL VILLAVICENCIO">
                <option value="UNIDAD EDUCATIVA QUISQUIS">
                <option value="GAD PARROQUIAL SUMACO /ESCUELA FISCAL MIXTA QUIJOS">
                <option value="UNIDAD EDUCATIVA BAEZA / BLOQUE 2">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL JUAN BAUTISTA MONTINI /ESCUELA">
                <option value="ESCUELA DE EDUCACIÓN BÁSICA 6 DE MARZO">
                <option value="UNIDAD EDUCATIVA MONSEÑOR EMILIO CECCO">
                <option value="UNIDAD EDUCATIVA MISAHUALLI - EDUCACIÓN BASICA">
                <option value="CANCHA CUBIERTA DE LA COMUNIDAD GARENO">
                <option value="UNIDAD EDUCATIVA JOSE PELAEZ">
                <option value="UNIDAD EDUCATIVA NACIONAL TENA /BACHILLERATO">
                <option value="UNIDAD EDUCATIVA MONSEÑOR MAXIMILIANO SPILLER / COLEGIO">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL PADRE RENATO SELVA">
                <option value="UNIDAD EDUCATIVA MONSEÑOR MAXIMILIANO SPILLER / ESCUELA">
                <option value="UNIDAD EDUCATIVA FISCO MISIONAL PADRE OTTORINO TODESCATO / EDUCACION BASICA">
                <option value="UNIDAD EDUCATIVA FISCO MISIONAL PADRE OTTORINO TODESCATO /BACHILLERATO">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL JUAN ARTEAGA">
                <option value="ESCUELA LEONIDAS PLAZA GUTIERREZ">
                <option value="UNIDAD EDUCATIVA HERMANO MIGUEL / BLOQUE 2">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL JUAN TANCA MARENGO">
                <option value="UNIDAD EDUCATIVA GUILLERMO KADLE">
                <option value="ESCUELA DE EDUCACIÓN BÁSICA 20 DE JULIO">
                <option value="CANCHA CUBIERTA DE LA COMUNIDAD DE SHIRIPUNO GUAYUSA YAKU">
                <option value="CASA COMUNAL FUERZAS UNIDAS">
                <option value="UNIDAD EDUCATIVA 'ANTONIO NEUMANE'">
                <option value="ESCUELA PADRE CÉSAR BERTOGLIO">
                <option value="UNIDAD EDUCATIVA MILENIO AHUANO / ESCUELA SHIRY WALCOPO">
                <option value="CANCHA CUBIERTA DE LA COMUNIDAD ÑUCANCHI ALPA">
                <option value="UNIDAD EDUCATIVA INTERCULTURAL BILINGUE LORENZO CERDA">
                <option value="UNIDAD EDUCATIVA COMUNITARIA INTERCULTURAL BILINGUE HONORABLE CONSEJO PROVINCIAL DE NAPO">
                <option value="ESCUELA DE EDUCACION BÁSICA ALEJANDRO HUMBOLDT">
                <option value="ESCUELA DE EDUCACIÓN GENERAL BÁSICA DOLORES SUCRE LAVAYEN">
                <option value="UNIDAD EDUCATIVA HERMANO MIGUEL / BLOQUE 3">
                <option value="UNIDAD EDUCATIVA CIUDAD DE TENA">
                <option value="CANCHA CUBIERTA DE LA COMUNIDAD VENECIA DERECHA">
                <option value="UNIDAD EDUCATIVA PADRE HUGO MENA">
                <option value="UNIDAD EDUCATIVA SAN FRANCISCO JAVIER">
                <option value="UNIDAD EDUCATIVA DEL MILENIO 'SAN JOSE DE CHONTA PUNTA'">
                <option value="UNIDAD EDUCATIVA DOCTOR JAIME HURTADO GONZALEZ">
                <option value="UNIDAD EDUCATIVA PATRIOTA MICHILENA">
                <option value="CENTRO EDUCATIVO COMUNITARIO ROSA MARIA TANGUILA">
                <option value="ESCUELA FISCAL MIXTA LOS PURUHAES">
                <option value="UNIDAD EDUCATIVA INTERCULTURAL BILINGUE DAVID MILLER.">
                <option value="CASA COMUNAL DE SANTA BARBARA">
                <option value="UNIDAD EDUCATIVA HERMANO HERMENEGILDO GUERRINI">
                <option value="UNIDAD EDUCATIVA 'TELMO TAPUY'">
                <option value="UNIDAD EDUCATIVA COMUNITARIA INTERCULTURAL BILINGUE INTILLACTA">
                <option value="ESCUELA EDUCACION BASICA HNO. CAYETANO DANZO - CALVARIO">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL ERNESTO OPHULS">
                <option value="ESCUELA DE EDUCACION BASICA GENERAL ELOY ALFARO">
                <option value="UNIDAD EDUCATIVA NACIONAL TENA / EDUCACION BASICA Y MEDIA">
                <option value="CENTRO EDUCATIVO COMUNITARIO INTERCULTURAL BILINGUE CRISTOBAL VARGAS">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL SAN JOSE / BACHILLERATO">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL SAN JOSE / EDUCACION BÁSICA">
                <option value="UNIDAD EDUCATIVA COMUNITARIA INTERCULTURAL BILINGUE PANO">
                <option value="UNIDAD EDUCATIVA MISAHUALLI /COLEGIO">
                <option value="UNIDAD EDUCATIVA FISCOMISIONAL JUAN XXIII">
                <option value="CECIB CAPIRONA">



                
            </datalist>

            <label for="numero_de_mesa">Número de Mesa</label>
            <input type="number" id="numero_de_mesa" name="numero_de_mesa" style="text-transform: uppercase;" required>

            <label for="Numero_de_acta">Número de Acta</label>
            <input type="number" id="Numero_de_acta" name="Numero_de_acta" style="text-transform: uppercase;">

            <label for="provincia">Provincia</label>
            <input type="text" id="provincia" name="provincia" list="provincia-list" style="text-transform: uppercase;" required>
            <datalist id="provincia-list">
                <option value="Napo">
            </datalist>

            <label for="canton">Cantón</label>
            <input type="text" id="canton" name="canton" list="canton-list" style="text-transform: uppercase;" required pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" title="Solo se permiten letras y             espacios.">
            <datalist id="canton-list">
                <option value="TENA">
                <option value="EL CHACO">
                <option value="CARLOS JULIO AROSEMENA TOLA">
                <option value="QUIJOS">
                <option value="ARCHIDONA">

            </datalist>

            <label for="parroquia">Parroquia</label>
            <input type="text" id="parroquia" name="parroquia" list="parroquia-list" style="text-transform: uppercase;" required pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" title="Solo se permiten             letras y espacios.">
            <datalist id="parroquia-list">
            
            <option value="HATUN SUMAKU">
            <option value="ARCHIDONA">
            <option value="COTUNDO">
            <option value="SAN PABLO DE USHPAYACU">
            <option value="CARLOS J. AROSEMENA TOLA">
            <option value="LINARES">
            <option value="EL CHACO">
            <option value="GONZALO DIAZ DE PINEDA">
            <option value="SANTA ROSA DE QUIJOS">
            <option value="SARDINAS">
            <option value="OYACACHI">
            <option value="COSANGA">
            <option value="SAN FRANCISCO DE BORJA">
            <option value="BAEZA">
            <option value="CUYUJA">
            <option value="PAPALLACTA">
            <option value="SUMACO">
            <option value="TALAG">
            <option value="SAN JUAN DE MUYUNA">
            <option value="PUERTO MISAHUALLI">
            <option value="CHONTAPUNTA">
            <option value="TENA">
            <option value="AHUANO">
            <option value="PUERTO NAPO">
            <option value="PANO">

            </datalist>

            <label for="imagen">Subir imagen del Acta</label>
            <input type="file" id="imagen" name="imagen" accept="image/*" required>

            <button type="submit">Guardar</button>
        </form>
    </div>

    <script>
        // Mostrar el div de espera cuando se envía el formulario
        document.querySelector('form').addEventListener('submit', function(event) {
            // Mostrar el div de espera
            document.getElementById('espera').style.display = 'flex';
        });
    </script>
    
</body>
</html>
