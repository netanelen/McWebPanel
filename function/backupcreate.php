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

require_once("../template/session.php");
require_once("../template/errorreport.php");
require_once("../config/confopciones.php");

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function converdatoscarpbackup($losbytes, $opcion)
{
    $eltipo = "GB";
    $result = $losbytes / 1048576;

    if ($opcion == 0) {
        $result = str_replace(".", ",", strval(round($result, 2)));
        return $result;
    } elseif ($opcion == 1) {
        $result = str_replace(".", ",", strval(round($result, 2))) . " " . $eltipo;
        return $result;
    }
}

//COMPROVAR SI SESSION EXISTE SINO CREARLA CON NO
if (!isset($_SESSION['VALIDADO']) || !isset($_SESSION['KEYSECRETA'])) {
    $_SESSION['VALIDADO'] = "NO";
    $_SESSION['KEYSECRETA'] = "0";
}

//VALIDAMOS SESSION
if ($_SESSION['VALIDADO'] == $_SESSION['KEYSECRETA']) {

    if ($_SESSION['CONFIGUSER']['rango'] == 1 || $_SESSION['CONFIGUSER']['rango'] == 2 || array_key_exists('pbackupscrear', $_SESSION['CONFIGUSER']) && $_SESSION['CONFIGUSER']['pbackupscrear'] == 1) {

        if (isset($_POST['action']) && !empty($_POST['action'])) {

            $retorno = "";
            $reccarpmine = CONFIGDIRECTORIO;
            $elerror = 0;
            $test = 0;

            $archivo = test_input($_POST['action']);

            //OBTENER RUTA RAIZ
            $dirraiz = dirname(getcwd()) . PHP_EOL;
            $dirraiz = trim($dirraiz);

            //OBTENER RUTA CARPETA BACKUP
            $dirbackups = "";
            $dirbackups = dirname(getcwd()) . PHP_EOL;
            $dirbackups = trim($dirbackups);
            $dirbackups .= "/backups";

            //OBTENER RUTA CARPETA MINECRAFT
            $dirminecraft = "";
            $dirminecraft = dirname(getcwd()) . PHP_EOL;
            $dirminecraft = trim($dirminecraft);
            $dirminecraft .= "/" . $reccarpmine;

            //OBTENER RUTA TEMP
            $dirtemp = "";
            $dirtemp = dirname(getcwd()) . PHP_EOL;
            $dirtemp = trim($dirtemp);
            $dirtemp .= "/temp";

            //OBTENER RUTA SH TEMP
            $dirsh = "";
            $dirsh = $dirtemp;
            $dirsh .= "/backup.sh";

            //OBTENER IDENFIFICADOR SCREEN
            $nombrescreen = $dirraiz . "/losbackups";
            $nombrescreen = str_replace("/", "", $nombrescreen);

            //VER SI HAY UN PROCESO YA EN RESTORE
            if ($elerror == 0) {
                $procesorestore = $dirraiz . "/restaurar";
                $procesorestore = str_replace("/", "", $procesorestore);

                $elcomando = "screen -ls | awk '/\." . $procesorestore . "\t/ {print strtonum($1)'}";
                $elpid = shell_exec($elcomando);

                if ($elpid != "") {
                    $retorno = "restoreenejecucion";
                    $elerror = 1;
                }
            }

            //VER SI HAY UN PROCESO YA EN BACKUP
            if ($elerror == 0) {
                $elcomando = "screen -ls | awk '/\." . $nombrescreen . "\t/ {print strtonum($1)'}";
                $elpid = shell_exec($elcomando);

                if ($elpid != "") {
                    $retorno = "backenejecucion";
                    $elerror = 1;
                }
            }

            if ($elerror == 0) {
                if ($archivo == "") {
                    $retorno = "noname";
                    $elerror = 1;
                }
            }

            //Evitar poder ir a una ruta hacia atras
            if ($elerror == 0) {
                if (strpos($archivo, '..') !== false || strpos($archivo, '*.*') !== false || strpos($archivo, '*/*.*') !== false) {
                    exit;
                }
            }

            if ($elerror == 0) {

                $verificar = array('..', '...', '/.', '~', '../', './', ';', ':', '>', '<', '/', '\\', '&&');

                for ($i = 0; $i < count($verificar); $i++) {

                    $test = substr_count($archivo, $verificar[$i]);

                    if ($test >= 1) {
                        $retorno = "novalidoname";
                        $elerror = 1;
                    }
                }
            }

            //LIMITE ALMACENAMIENTO
            if ($elerror == 0) {
                //OBTENER GIGAS CARPETA BACKUPS
                $getgigasbackup = shell_exec("du -s " . $dirbackups . " | awk '{ print $1 }' ");
                $getgigasbackup = trim($getgigasbackup);
                $getgigasbackup = converdatoscarpbackup($getgigasbackup, 0);

                //OBTENER GIGAS LIMITE BACKUPS
                $limitbackupgb = CONFIGFOLDERBACKUPSIZE;

                //MIRAR SI ES ILIMITADO
                if ($limitbackupgb >= 1) {
                    if ($getgigasbackup > $limitbackupgb) {
                        $retorno = "limitgbexceeded";
                        $elerror = 1;
                    }
                }
            }

            //MIRAR SI CARPETA BACKUPS EXISTE
            if ($elerror == 0) {
                clearstatcache();
                if (!file_exists($dirbackups)) {
                    $retorno = "noexiste";
                    $elerror = 1;
                }
            }

            //MIRAR SI CARPETA BACKUPS SE PUEDE ESCRIVIR
            if ($elerror == 0) {
                clearstatcache();
                if (!is_writable($dirbackups)) {
                    $retorno = "nowritable";
                    $elerror = 1;
                }
            }

            //MIRAR SI LA CARPETA TEMP EXISTE
            if ($elerror == 0) {
                clearstatcache();
                if (!file_exists($dirtemp)) {
                    $retorno = "notempexiste";
                    $elerror = 1;
                }
            }

            //MIRAR SI CARPETA TEMP SE PUEDE ESCRIVIR
            if ($elerror == 0) {
                clearstatcache();
                if (!is_writable($dirtemp)) {
                    $retorno = "notempwritable";
                    $elerror = 1;
                }
            }

            //MIRAR SI CARPETA MINECRAFT SE PUEDE LEER
            if ($elerror == 0) {
                clearstatcache();
                if (!is_readable($dirminecraft)) {
                    $retorno = "nolectura";
                    $elerror = 1;
                }
            }

            //MIRAR SI CARPETA MINECRAF SE PUEDE EJECUTAR
            if ($elerror == 0) {
                clearstatcache();
                if (!is_executable($dirminecraft)) {
                    $retorno = "noejecutable";
                    $elerror = 1;
                }
            }

            if ($elerror == 0) {

                $borrastart = $dirminecraft . "/start.sh";
                clearstatcache();
                if (file_exists($borrastart . "/start.sh")) {
                    unlink($borrastart);
                }

                $t = date("Y-m-d-G:i:s");
                $rutacrearbackup = $dirtemp . "/" . $archivo . "-" . $t;
                $rutaacomprimir = $dirminecraft . "/ .";
                $elcomando = "tar -czvf '" . $rutacrearbackup . ".tar.gz' -C " . $rutaacomprimir;
                $moverabackups = "mv '" . $archivo . "-" . $t . ".tar.gz' " . $dirbackups . "/'" . $archivo . "-" . $t . ".tar.gz'";
                $delsh = "rm backup.sh";

                $file = fopen($dirsh, "w");
                fwrite($file, "#!/bin/bash" . PHP_EOL);
                fwrite($file, $elcomando . PHP_EOL);
                fwrite($file, $moverabackups . PHP_EOL);
                fwrite($file, $delsh . PHP_EOL);
                fclose($file);

                //DAR PERMISOS AL SH
                $comando = "cd " . $dirtemp . " && chmod +x backup.sh";
                exec($comando, $out, $oky);

                //INICIAR SCREEN
                $comando = "cd " . $dirtemp . " && umask 002 && screen -dmS " . $nombrescreen . " sh backup.sh";
                exec($comando, $out, $oky);

                if (!$oky) {
                    $_SESSION['BACKUPSTATUS'] = 1;
                } else {
                    $retorno = "nobackup";
                }
            }
            echo $retorno;
        }
    }
}
