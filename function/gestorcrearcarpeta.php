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

function converdatoscarpmine($losbytes, $opcion, $decimal)
{
    $eltipo = "GB";
    $result = $losbytes / 1048576;

    if ($opcion == 0) {
        $result = strval(round($result, $decimal));
        return $result;
    } elseif ($opcion == 1) {
        $result = strval(round($result, $decimal)) . " " . $eltipo;
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

    if ($_SESSION['CONFIGUSER']['rango'] == 1 || $_SESSION['CONFIGUSER']['rango'] == 2 || array_key_exists('pgestorarchivoscrearcarpeta', $_SESSION['CONFIGUSER']) && $_SESSION['CONFIGUSER']['pgestorarchivoscrearcarpeta'] == 1) {

        if (isset($_POST['action']) && !empty($_POST['action']) || isset($_POST['renombre']) && !empty($_POST['renombre'])) {

            $archivo = "";
            $elnombre = "";
            $retorno = "";
            $elerror = 0;
            $test = 0;

            $elnombrescreen = CONFIGDIRECTORIO;
            $limitmine = CONFIGFOLDERMINECRAFTSIZE;
            $rutacarpetamine = "";
            $getgigasmine = "";

            $elnombre = test_input($_POST['action']);

            //COMPROBAR SI ESTA VACIO RENOMBRE
            if ($elerror == 0) {
                if ($elnombre == "") {
                    $retorno = "norenom";
                    $elerror = 1;
                }
            }

            //BUSCAR CARACTERES PROHIBIDOS
            if ($elerror == 0) {


                $verificar = array('..', '...', '/.', '~', '../', './', ';', ':', '>', '<', '/', '\\', '&&', '#', "|", '$', '%', '!', '`', '&', '*', '{', '}', '?', '=', '@', "'", '"', "'\'");

                for ($i = 0; $i < count($verificar); $i++) {

                    $test = substr_count($elnombre, $verificar[$i]);

                    if ($test >= 1) {
                        $retorno = "novalido";
                        $elerror = 1;
                    }
                }
            }

            //AÑADIR RUTA ACTUAL AL ARCHIVO
            if ($elerror == 0) {
                $archivo = $_SESSION['RUTACTUAL'];
                $elimpio = $_SESSION['RUTACTUAL'];
                $elnombre = $elimpio . "/" . $elnombre;
            }

            //COMPROVAR QUE EL INICIO DE RUTA SEA IGUAL A LA SESSION
            if ($elerror == 0) {
                if ($_SESSION['RUTALIMITE'] != substr($elnombre, 0, strlen($_SESSION['RUTALIMITE']))) {
                    $retorno = "rutacambiada";
                    $elerror = 1;
                }
            }

            //COMPOBAR SI HAY ".." "..."
            if ($elerror == 0) {

                $verificar = array('..', '...', '~', '../', './', '&&');

                for ($i = 0; $i < count($verificar); $i++) {

                    $test = substr_count($elnombre, $verificar[$i]);

                    if ($test >= 1) {
                        $retorno = "novalido";
                        $elerror = 1;
                    }
                }
            }

            //Comprovar si se puede escrivir
            if ($elerror == 0) {
                clearstatcache();
                if (!is_writable($archivo)) {
                    $retorno = "nowrite";
                    $elerror = 1;
                }
            }

            //Comprovar si existe el que se va a crear
            if ($elerror == 0) {
                clearstatcache();
                if (file_exists($elnombre)) {
                    $retorno = "carpyaexiste";
                    $elerror = 1;
                }
            }

            //LIMITE ALMACENAMIENTO
            if ($elerror == 0) {

                //OBTENER CARPETA SERVIDOR MINECRAFT
                $rutacarpetamine = dirname(getcwd()) . PHP_EOL;
                $rutacarpetamine = trim($rutacarpetamine);
                $rutacarpetamine .= "/" . $elnombrescreen;

                //OBTENER GIGAS CARPETA BACKUPS
                $getgigasmine = shell_exec("du -s " . $rutacarpetamine . " | awk '{ print $1 }' ");
                $getgigasmine = trim($getgigasmine);
                $getgigasmine = converdatoscarpmine($getgigasmine, 0, 2);

                //MIRAR SI ES ILIMITADO
                if ($limitmine >= 1) {
                    if ($getgigasmine > $limitmine) {
                        $retorno = "OUTGIGAS";
                        $elerror = 1;
                    }
                }
            }

            //Crear Carpeta
            if ($elerror == 0) {
                mkdir($elnombre, 0700);
                $permcomando = "chmod 775 '" . $elnombre . "'";
                exec($permcomando);
                $retorno = "OK";
            }

            echo $retorno;
        }
    }
}
