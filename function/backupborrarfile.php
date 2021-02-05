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

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//COMPROVAR SI SESSION EXISTE SINO CREARLA CON NO
if (!isset($_SESSION['VALIDADO']) || !isset($_SESSION['KEYSECRETA'])) {
    $_SESSION['VALIDADO'] = "NO";
    $_SESSION['KEYSECRETA'] = "0";
}

//VALIDAMOS SESSION
if ($_SESSION['VALIDADO'] == $_SESSION['KEYSECRETA']) {

    if ($_SESSION['CONFIGUSER']['rango'] == 1 || $_SESSION['CONFIGUSER']['rango'] == 2 || array_key_exists('pbackupsborrar', $_SESSION['CONFIGUSER']) && $_SESSION['CONFIGUSER']['pbackupsborrar'] == 1) {

        if (isset($_POST['action']) && !empty($_POST['action'])) {

            $retorno = "";
            $verificarex = "";
            $elerror = 0;

            $archivo = test_input($_POST['action']);

            //OBTENER RUTA RAIZ
            $dirraiz = dirname(getcwd()) . PHP_EOL;
            $dirraiz = trim($dirraiz);

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

            //Evitar poder ir a una ruta hacia atras
            if ($elerror == 0) {
                if (strpos($archivo, '..') !== false || strpos($archivo, '*.*') !== false || strpos($archivo, '*/*.*') !== false) {
                    exit;
                }
            }

            //VERIFICAR EXTENSION
            if ($elerror == 0) {
                $verificarex = substr($archivo, -7);
                if ($verificarex != ".tar.gz") {
                    exit;
                }
            }

            if ($elerror == 0) {
                //OBTENER RUTA CARPETA BACKUP
                $dirconfig = "";
                $dirconfig = dirname(getcwd()) . PHP_EOL;
                $dirconfig = trim($dirconfig);
                $dirconfig .= "/backups";
                $dirconfig = $dirconfig . "/" . $archivo;

                if (file_exists($dirconfig)) {
                    //COMPROVAR SI SE PUEDE ESCRIVIR
                    if (is_writable($dirconfig)) {
                        $retorno = unlink($dirconfig);
                    } else {
                        $retorno = "nowritable";
                    }
                } else {
                    $retorno = "noexiste";
                }
            }
        }
        echo $retorno;
    }
}
