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
                                    <div class="py-1">
                                        <div class="container">
                                            <h1 class="mb-5">System Config</h1>
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <!-- Page Heading -->
                                                    <?php

                                                    //VARIABLES
                                                    $contadorarchivos = 0;
                                                    $contadorsiexiste = 0;

                                                    $recpuerto = CONFIGPUERTO;
                                                    $recram = CONFIGRAM;
                                                    $rectiposerv = CONFIGTIPOSERVER;
                                                    $recnombreserv = CONFIGNOMBRESERVER;
                                                    $reccarpmine = CONFIGDIRECTORIO;
                                                    $recarchivojar = CONFIGARCHIVOJAR;
                                                    $receulaminecraft = CONFIGEULAMINECRAFT;
                                                    $recmaxupload = CONFIGMAXUPLOAD;

                                                    $elnombredirectorio = $reccarpmine;
                                                    $rutaarchivo = getcwd();
                                                    $rutaarchivo = trim($rutaarchivo);
                                                    $rutaarchivo .= "/" . $elnombredirectorio;

                                                    //COMPRUEVA SI LA CARPETA DEL SERVIDOR MINECRAFT EXISTE
                                                    clearstatcache();
                                                    if (!file_exists($rutaarchivo)) {
                                                        echo "<div class='alert alert-danger' role='alert'>Error: La carpeta del servidor minecraft no existe.</div>";
                                                        exit;
                                                    }

                                                    //COMPRUEBA SI LA CARPETA DEL SERVIDOR MINECRAFT SE PUEDE LEER
                                                    clearstatcache();
                                                    if (!is_readable($rutaarchivo)) {
                                                        echo "<div class='alert alert-danger' role='alert'>Error: La carpeta del servidor minecraft no tiene permisos de lectura.</div>";
                                                        exit;
                                                    }

                                                    ?>
                                                    <form id="formconf" action="function/guardasysconf.php" method="post">
                                                        <div class="form-group">
                                                            <label for="listadojars">Seleccione Servidor Minecraft:</label>
                                                            <select class="form-control mb-2" id="listadojars" name="listadojars">

                                                                <?php

                                                                if ($handle = opendir($rutaarchivo)) {
                                                                    while (false !== ($file = readdir($handle))) {
                                                                        $fileNameCmps = explode(".", $file);
                                                                        $fileExtension = strtolower(end($fileNameCmps));

                                                                        if ($file == $recarchivojar) {
                                                                            $contadorsiexiste = 1;
                                                                        }

                                                                        if ($fileExtension == "jar") {
                                                                            $contadorarchivos++;
                                                                        }
                                                                    }
                                                                    closedir($handle);
                                                                }

                                                                if ($contadorarchivos == 0) {
                                                                    echo '<option selected disabled hidden>No hay subido ningún servidor .jar</option>';
                                                                } else {

                                                                    if ($recarchivojar == "" || $contadorsiexiste == 0) {
                                                                        echo '<option selected disabled hidden>No hay ningún servidor seleccionado</option>';
                                                                    }


                                                                    if ($handle = opendir($rutaarchivo)) {
                                                                        while (false !== ($file = readdir($handle))) {
                                                                            $fileNameCmps = explode(".", $file);
                                                                            $fileExtension = strtolower(end($fileNameCmps));

                                                                            if ($fileExtension == "jar") {

                                                                                if ($file == $recarchivojar) {
                                                                                    echo '<option selected value="' . $file . '">' . $file . '</option>';
                                                                                } else {
                                                                                    echo '<option value="' . $file . '">' . $file . '</option>';
                                                                                }
                                                                            }
                                                                        }
                                                                        closedir($handle);
                                                                    }
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-row">

                                                            <div class="form-group col-md-6">
                                                                <label for="elport">Puerto</label>
                                                                <input type="number" value="<?php echo $recpuerto; ?>" class="form-control" id="elport" name="elport" required="required" min="1025" max="65535">
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label for="elram" class="">Memoria Ram Limite</label>
                                                                <select id="elram" name="elram" class="form-control" required="required">
                                                                    <?php

                                                                    $salida = shell_exec('free -h | grep Mem');
                                                                    $totalram = substr($salida, 14, 4);
                                                                    $totalram = preg_replace('/\s+/', '', $totalram);
                                                                    $totalram = trim($totalram);

                                                                    for ($i = 1;; $i++) {
                                                                        if ($i > $totalram) {
                                                                            break;
                                                                        }

                                                                        if ($recram == $i) {
                                                                            echo '<option selected value="' . $i . '">' . $i . ' GB</option>';
                                                                        } else {
                                                                            echo '<option value="' . $i . '">' . $i . ' GB</option>';
                                                                        }
                                                                    }

                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-row">

                                                            <div class="form-group col-md-6">
                                                                <label for="eltipserv">Tipo Servidor</label>
                                                                <select id="eltipserv" name="eltipserv" class="form-control" required="required">
                                                                    <?php
                                                                    $opcionesserver = array('vanilla', 'spigot', 'paper', 'otros');

                                                                    for ($i = 0; $i < count($opcionesserver); $i++) {

                                                                        if ($rectiposerv == $opcionesserver[$i]) {
                                                                            echo '<option selected value="' . $opcionesserver[$i] . '">' . $opcionesserver[$i] . '</option>';
                                                                        } else {
                                                                            echo '<option value="' . $opcionesserver[$i] . '">' . $opcionesserver[$i] . '</option>';
                                                                        }
                                                                    }

                                                                    ?>

                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label for="elmaxupload">Subida Fichero Máximo (MB)</label>
                                                                <select id="elmaxupload" name="elmaxupload" class="form-control" required="required">
                                                                    <?php

                                                                    $opcionesserver = array('128', '256', '386', '512', '640', '768', '896', '1024');

                                                                    for ($i = 0; $i < count($opcionesserver); $i++) {

                                                                        if ($recmaxupload == $opcionesserver[$i]) {
                                                                            echo '<option selected value="' . $opcionesserver[$i] . '">' . $opcionesserver[$i] . " MB" . '</option>';
                                                                        } else {
                                                                            echo '<option value="' . $opcionesserver[$i] . '">' . $opcionesserver[$i] . " MB" . '</option>';
                                                                        }
                                                                    }

                                                                    ?>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="elnomserv">Nombre Servidor</label>
                                                            <input type="text" class="form-control" id="elnomserv" name="elnomserv" required="required" value="<?php echo $recnombreserv; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="eldirect">Nombre carpeta del servidor Minecraft</label>
                                                            <input readonly type="text" data-toggle="tooltip" data-placement="top" title="No se puede modificar la carpeta" class="form-control" id="eldirect" name="eldirect" required="required" value="<?php echo $reccarpmine; ?>">
                                                        </div>
                                                        <input id="minecrafteula" name="minecrafteula" type="hidden" value="<?php echo $receulaminecraft; ?>">

                                                        <div class="form-group">
                                                            <span id="result"></span>
                                                        </div>

                                                        <button class="btn btn-primary btn-block" id="guardaserver" name="guardarserver">Guardar Cambios</button>
                                                        <input type="hidden" name="action" value="submit">

                                                    </form>


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
                </div>
                <!-- End of Content Wrapper -->
            </div>
            <!-- End of Page Wrapper -->
        </div>
        <script src="js/sysconf.js"></script>
    <?php
        //FINAL VALIDAR SESSION
    } else {
        header("location:index.php");
    }
    ?>

</body>

</html>