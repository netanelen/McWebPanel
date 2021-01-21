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

function converdatoscarpmine($losbytes, $opcion)
{
    $eltipo = "GB";
    $result = $losbytes / 1048576;

    if ($opcion == 0) {
        $result = str_replace(".", ",", strval(round($result, 0)));
        return $result;
    } elseif ($opcion == 1) {
        $result = str_replace(".", ",", strval(round($result, 0))) . " " . $eltipo;
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

    if (isset($_POST['action']) && !empty($_POST['action'])) {

        $retorno = "";
        $elerror = 0;
        $archivosize = 0;
        $elnombredirectorio = CONFIGDIRECTORIO;
        $limitmine = CONFIGFOLDERMINECRAFTSIZE;
        $rutacarpetamine = "";
        $getgigasmine = "";

        //OBTENER UPLOAD MAX PHP
        $maxdeupload = ini_get("upload_max_filesize");
        $maxdeupload = substr($maxdeupload, 0, -1);
        $maxdeupload = trim($maxdeupload);

        $archivosize = test_input($_POST['action']);

        //CONVERTIR DATOS
        $archivosizemb = converdatoscarpmine($archivosize, 0);

        //COMPROBAR SI LO QUE SE SUBE ES MAYOR AL UPLOAD PERMITIDO
        if ($elerror == 0) {
            if ($archivosizemb > $maxdeupload) {
                $elerror = 1;
                $retorno = "OUTUPLOAD";
            }
        }

        //LIMITE ALMACENAMIENTO
        if ($elerror == 0) {

            //OBTENER CARPETA SERVIDOR MINECRAFT
            $rutacarpetamine = dirname(getcwd()) . PHP_EOL;
            $rutacarpetamine = trim($rutacarpetamine);
            $rutacarpetamine .= "/" . $elnombredirectorio;

            //OBTENER GIGAS CARPETA BACKUPS
            $getgigasmine = shell_exec("du -s " . $rutacarpetamine . " | awk '{ print $1 }' ");
            $getgigasmine = trim($getgigasmine);
            $getgigasmine = converdatoscarpmine($getgigasmine, 0);

            //MIRAR SI ES ILIMITADO
            if ($limitmine >= 1) {
                if ($getgigasmine > $limitmine) {
                    $retorno = "OUTGIGAS";
                    $elerror = 1;
                }
            }
        }

        //SI NO HAY ERRORES DEVOLVER OKGIGAS
        if ($elerror == 0) {
            $retorno = "OKGIGAS";
        }

        echo $retorno;
    }
}
