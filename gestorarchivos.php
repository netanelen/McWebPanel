<?php

/*
This file is part of McWebPanel.
Copyright (C) 2020 Cristina Ibañez, Konata400

    McWebPanel is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    McWebPanel is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with McWebPanel.  If not, see <https://www.gnu.org/licenses/>.
*/

require_once("template/session.php");
require_once("template/errorreport.php");
require_once("config/confopciones.php");
require_once("template/header.php");

//FUNCION DEVUELVE DATOS EN EL FORMATO B/KB/MB/GB/TB
function devolverdatos($losbytes, $opcion)
{
    $eltipo = "";

    if ($losbytes >= 0) {
        $eltipo = "B";
        $result = $losbytes;
    }

    if ($losbytes >= 1024) {
        $eltipo = "KB";
        $result = $losbytes / 1024;
    }

    if ($losbytes >= 1048576) {
        $eltipo = "MB";
        $result = $losbytes / 1048576;
    }

    if ($losbytes >= 1073741824) {
        $eltipo = "GB";
        $result = $losbytes / 1073741824;
    }

    if ($losbytes >= 1099511627776) {
        $eltipo = "TB";
        $result = $losbytes / 1099511627776;
    }

    if ($opcion == 0) {
        $result = str_replace(".", ",", strval(round($result, 2)));
        return $result;
    } elseif ($opcion == 1) {
        $result = str_replace(".", ",", strval(round($result, 2))) . " " . $eltipo;
        return $result;
    }
}
?>
<!-- Custom styles for this template-->
<link href="css/test.css" rel="stylesheet">

</head>

<body id="page-top">

    <?php

    //COMPROVAR SI SESSION EXISTE SINO CREARLA CON NO
    if (!isset($_SESSION['VALIDADO']) || !isset($_SESSION['KEYSECRETA'])) {
        $_SESSION['VALIDADO'] = "NO";
        $_SESSION['KEYSECRETA'] = "0";
        header("location:index.php");
    }

    //VALIDAMOS SESSION SINO ERROR
    if ($_SESSION['VALIDADO'] == $_SESSION['KEYSECRETA']) {
    ?>

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <?php
            require_once("template/menu.php");
            ?>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <div class="card border-left-primary shadow h-100">
                                <div class="card-body">

                                    <!-- Page Heading -->
                                    <div class="py-1">
                                        <div class="container">
                                            <h1 class="">Gestor Archivos</h1>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php

                                                    //INICIAR VARIABLES
                                                    $contadorarchivos = 0;
                                                    $eltamano = "";
                                                    $archivoconcreto = "";
                                                    $tipoarchivo = "";
                                                    $getinfofile = "";
                                                    $getrutalimpia = "";
                                                    $getrutaparseada = "";
                                                    $valencontrado = 0;
                                                    $rutahta = "";

                                                    $recpuerto = CONFIGPUERTO;
                                                    $recram = CONFIGRAM;
                                                    $rectiposerv = CONFIGTIPOSERVER;
                                                    $recnombreserv = CONFIGNOMBRESERVER;
                                                    $reccarpmine = CONFIGDIRECTORIO;
                                                    $recarchivojar = CONFIGARCHIVOJAR;
                                                    $receulaminecraft = CONFIGEULAMINECRAFT;

                                                    //OBTENER RUTA SERVIDOR MINECRAFT
                                                    $rutaarchivo = getcwd();
                                                    $rutaarchivo = trim($rutaarchivo);
                                                    $rutaarchivo .= "/" . $reccarpmine;

                                                    //FORZAR .htaccess CARPETA SERVIDOR MINECRAFT
                                                    $rutahta = $rutaarchivo . "/.htaccess";
                                                    $file = fopen($rutahta, "w");
                                                    fwrite($file, "deny from all" . PHP_EOL);
                                                    fclose($file);

                                                    //INICIALIZAR SESSION RUTACTUAL Y RUTALIMITE
                                                    if (!isset($_SESSION['RUTACTUAL'])) {
                                                        $_SESSION['RUTACTUAL'] = $rutaarchivo;
                                                        $_SESSION['RUTALIMITE'] = $rutaarchivo;
                                                        $_SESSION['COPIARFILES'] = "0";
                                                    } else {
                                                        $rutaarchivo = $_SESSION['RUTACTUAL'];
                                                    }

                                                    //COMPROVAR SI EXISTE CARPETA SERVIDOR MINECRAF
                                                    if (!file_exists($rutaarchivo)) {
                                                        echo "<div class='alert alert-danger' role='alert'>Error: No existe la carpeta servidor minecraft.</div>";
                                                        exit;
                                                    }

                                                    clearstatcache();

                                                    //COMPROVAR SI SE PUEDE LEER CARPETA
                                                    if (!is_readable($rutaarchivo)) {
                                                        echo "<div class='alert alert-danger' role='alert'>Error: La carpeta servidor minecraft no tiene permisos de lectura.</div>";
                                                        exit;
                                                    }

                                                    clearstatcache();

                                                    //COMPROVAR SI SE PUEDE ESCRIVIR EN CARPETA
                                                    if (!is_writable($rutaarchivo)) {
                                                        echo "<div class='alert alert-danger' role='alert'>Error: La carpeta servidor minecraft no tiene permisos de escritura.</div>";
                                                        exit;
                                                    }

                                                    //SEPARAR RUTA EN ARRAY
                                                    $getrutalimpia = explode("/", $_SESSION['RUTACTUAL']);

                                                    //RECORRER ARRAY Y OBTENER SOLO A PARTIR DE LA CARPETA SERVER MINECRAFT
                                                    for ($a = 0; $a < count($getrutalimpia); $a++) {
                                                        if ($getrutalimpia[$a] == $reccarpmine) {
                                                            $valencontrado = 1;
                                                        }

                                                        if ($valencontrado == 1) {
                                                            $getrutaparseada .= $getrutalimpia[$a] . " / ";
                                                        }
                                                    }

                                                    ?>

                                                    <nav aria-label="breadcrumb">
                                                        <ol class="breadcrumb">
                                                            <li class="breadcrumb-item active"><?php echo "Carpeta: / " . $getrutaparseada; ?></li>
                                                        </ol>
                                                    </nav>
                                                    <button type="button" id="bnactualizar" class="btn btn-primary mr-1" title="Actualizar"><img src="img/botones/refresh.png" alt="Actualizar"></button>
                                                    <button type="button" id="bnnuevacarpeta" class="btn btn-primary mr-1" value="<?php echo $_SESSION['RUTACTUAL']; ?>" title="Crear Carpeta"><img src="img/botones/new.png" alt="+"> Crear Carpeta</button>
                                                    <button type="button" id="bcopiar" class="btn btn-primary mr-1" title="Copiar"><img src="img/botones/copiar.png" alt="+"> Copiar</button>
                                                    <?php
                                                    if ($_SESSION['COPIARFILES'] != "0") {
                                                        echo ('<button type="button" id="bpegar" class="btn btn-primary mr-1" title="Pegar"><img src="img/botones/pegar.png" alt="+"> Pegar</button>');
                                                    }
                                                    ?>
                                                    <button type="button" id="beliminarseleccion" class="btn btn-danger mr-1" title="Eliminar Seleccionados"><img src="img/botones/borrar.png" alt=""> Eliminar Seleccionados</button>


                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-borderless">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Nombre</th>
                                                                    <th scope="col">Fecha</th>
                                                                    <th scope="col">Tamaño</th>
                                                                    <th scope="col">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php

                                                                clearstatcache();

                                                                //CONTAR CUANTOS ARCHIVOS TIENE LA CARPETA
                                                                $files = array();
                                                                if ($handle = opendir($rutaarchivo)) {
                                                                    while (false !== ($file = readdir($handle))) {
                                                                        $fileNameCmps = explode(".", $file);
                                                                        $fileExtension = strtolower(end($fileNameCmps));
                                                                        $contadorarchivos++;
                                                                    }
                                                                    closedir($handle);
                                                                }

                                                                //SI NO HAY ARCHIVOS MOSTRAR INFORMACION
                                                                if ($contadorarchivos == 0) {
                                                                    echo ('<tr>');
                                                                    echo ('<th scope="row">Actualmente no hay archivos servidor minecraft.</th><td></td><td></td><td></td>');
                                                                    echo ('</tr>');
                                                                } else {

                                                                    //CARGAR ARRAYS
                                                                    $files = array();
                                                                    $fcarpetas = array();
                                                                    $farchivos = array();

                                                                    //OBTENER CARPETAS Y DIRECTORIOS
                                                                    $a = scandir($rutaarchivo);

                                                                    //SEPARAR CARPETAS Y DIRECTORIOS
                                                                    for ($i = 0; $i < count($a); $i++) {
                                                                        $rutfil = $rutaarchivo . "/" . $a[$i];
                                                                        if (is_dir($rutfil)) {
                                                                            //Evitar mostrar .
                                                                            if ($a[$i] != ".") {
                                                                                $fcarpetas[] = $a[$i];
                                                                            }
                                                                        } else {
                                                                            //Evitar mostrar .htaccess
                                                                            if ($a[$i] != ".htaccess") {
                                                                                $farchivos[] = $a[$i];
                                                                            }
                                                                        }
                                                                    }

                                                                    //JUNTAR ARRAYS
                                                                    for ($i = 0; $i < count($farchivos); $i++) {
                                                                        $fcarpetas[] = $farchivos[$i];
                                                                    }

                                                                    //RECORRER ARRAY Y AÑADIR LAS PROPIEDADES Y LOS BOTONES
                                                                    for ($i = 0; $i < count($fcarpetas); $i++) {
                                                                        $archivoconcreto = $rutaarchivo . "/" . $fcarpetas[$i];
                                                                        echo ('<tr class = "menu-hover">');

                                                                        echo ('<th scope="row">');

                                                                        if ($fcarpetas[$i] != "." && $fcarpetas[$i] != "..") {
                                                                            echo ('<input class="laseleccion mr-2" type="checkbox" value="' . $archivoconcreto . '">');
                                                                        }

                                                                        $getinfofile = pathinfo($archivoconcreto);

                                                                        if (is_dir($archivoconcreto)) {
                                                                            echo ('<img class="mr-2" src="img/gestorarchivos/carpeta.png">' . $fcarpetas[$i] . '</th>');
                                                                        } else {
                                                                            $tipoarchivo = "." . strtolower($getinfofile['extension']);

                                                                            //VER TIPO Y AÑADIR ICONO
                                                                            if ($tipoarchivo == ".txt") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/txt.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".jar") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/java.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".yml") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/yml.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".json") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/json.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".htaccess") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/htaccess.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".properties") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/mine.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".bmp") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/img.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".dib") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/img.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".jpg") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/img.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".jpeg") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/img.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".jpe") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/img.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".jfif") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/img.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".gif") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/img.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".tiff") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/img.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".png") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/img.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".heic") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/img.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".zip") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/zip.png">' . $fcarpetas[$i] . '</th>');
                                                                            } elseif ($tipoarchivo == ".gz" || $tipoarchivo == ".tar" || $tipoarchivo == ".bz2") {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/tar.png">' . $fcarpetas[$i] . '</th>');
                                                                            } else {
                                                                                echo ('<img class="mr-2" src="img/gestorarchivos/void.png">' . $fcarpetas[$i] . '</th>');
                                                                            }
                                                                        }

                                                                        //AÑADIR FECHA ARCHIVO/CARPETA
                                                                        if (!is_dir($archivoconcreto)) {
                                                                            echo ('<td>' . date("d/m/Y H:i:s", filemtime($archivoconcreto)) . '</td>');
                                                                        } else {
                                                                            echo ('<td>' . date("d/m/Y H:i:s", filemtime($archivoconcreto)) . '</td>');
                                                                        }

                                                                        //AÑADIR TAMAÑO ARCHIVO
                                                                        if (!is_dir($archivoconcreto)) {
                                                                            $eltamano = devolverdatos(filesize($archivoconcreto), 1);
                                                                        } else {
                                                                            $eltamano = ".";
                                                                        }
                                                                        echo ('<td>' . $eltamano . '</td>');
                                                                        echo ('<td>');

                                                                        //CREAR BOTONES ARCHIVOS Y CARPETAS
                                                                        if (!is_dir($archivoconcreto)) {
                                                                ?>
                                                                            <button type="button" class="descargarfile btn btn-primary mr-1" value="<?php echo $archivoconcreto; ?>" title="Descargar"><img src="img/botones/down.png" alt="Descargar"></button>
                                                                            <?php
                                                                            if ($tipoarchivo == ".gz" || $tipoarchivo == ".tar" || $tipoarchivo == ".bz2") {
                                                                                echo ('<button type="button" class="descomprimirtar btn btn-primary mr-1" value="' . $archivoconcreto . '" title="Descomprimir"><img src="img/botones/descomprimir.png" alt="Descomprimir"></button>');
                                                                            } elseif ($tipoarchivo == ".zip") {
                                                                                echo ('<button type="button" class="descomprimirzip btn btn-primary mr-1" value="' . $archivoconcreto . '" title="Descomprimir"><img src="img/botones/descomprimir.png" alt="Descomprimir"></button>');
                                                                            }
                                                                            ?>
                                                                            <button type="button" class="editarfile btn btn-info text-white mr-1" value="<?php echo $archivoconcreto; ?>" title="Editar"><img src="img/botones/editar.png" alt="Editar"></button>
                                                                            <button type="button" class="renamefile btn btn-warning text-white mr-1" id="<?php echo $fcarpetas[$i]; ?>" value="<?php echo $archivoconcreto; ?>" title="Renombrar"><img src="img/botones/rename.png" alt="Renombrar"></button>
                                                                            <button type="button" class="borrarfile btn text-white btn-danger" id="<?php echo $fcarpetas[$i]; ?>" value="<?php echo $archivoconcreto; ?>" title="Borrar"><img src="img/botones/borrar.png" alt="Borrar"></button>

                                                                            </td>
                                                                            </tr>
                                                                            <?php
                                                                        } else {
                                                                            if ($fcarpetas[$i] == "..") {
                                                                            ?>
                                                                                <button type="button" class="atras btn btn-info text-white mr-1" value="<?php echo $getinfofile['dirname']; ?>" title="Atras"><img src="img/botones/atras.png" alt="Atras"> Atras</button>
                                                                            <?php
                                                                            } elseif ($fcarpetas[$i] == ".") {
                                                                            ?>

                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <button type="button" class="entrar btn btn-info text-white mr-1" value="<?php echo $archivoconcreto ?>" title="Entrar"><img src="img/botones/entrar.png" alt="Entrar"></button>
                                                                                <button type="button" class="comprimirzipfolder btn btn-warning text-white mr-1" value="<?php echo $archivoconcreto; ?>" title="Comprimir carpeta en Zip"><img src="img/botones/comprimir.png" alt="Comprimir carpeta en Zip"></button>
                                                                                <button type="button" id="<?php echo $fcarpetas[$i] ?>" class="renamefolder btn btn-warning text-white mr-1" value="<?php echo $archivoconcreto; ?>" title="Renombrar"><img src="img/botones/rename.png" alt="Renombrar"></button>
                                                                                <button type="button" id="<?php echo $fcarpetas[$i] ?>" class="borrarcarpeta btn text-white btn-danger" value="<?php echo $archivoconcreto ?>" title="Borrar"><img src="img/botones/borrar.png" alt="Borrar"></button>
                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        <p class="lead" id="textoretorno"></p>
                                                    </div>
                                                    <hr>
                                                    <h1 class="">Subir Archivo</h1>
                                                    <div class="row">
                                                        <div class="col-md-4">

                                                            <p>(Limite Subida: <?php echo ini_get("upload_max_filesize"); ?>B)</p>

                                                            <form id="form" action="function/gestoruploadfile.php" method="post" enctype="multipart/form-data">

                                                                <div class="custom-file mb-3">
                                                                    <input type="file" class="custom-file-input" id="fileName" name="uploadedFile">
                                                                    <label class="custom-file-label" for="fileName">Elija el archivo</label>
                                                                </div>

                                                                <button class="btn btn-primary btn-block btn-lg text-white mt-2" id="botonsubir" type="submit" value="Upload">Subir Archivo</button>
                                                            </form>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <img class="" src="img/loading.gif" id="gifloading" alt="loading">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p class="lead" id="textouploadretorno"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <!-- End of Footer -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

        <script src="js/gestorarchivos.js"></script>

    <?php

        //FINAL VALIDAR SESSION
    } else {
        header("location:index.php");
    }
    ?>

</body>

</html>