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

//COMPROVAR SI SESSION EXISTE SINO CREARLA CON NO
if (!isset($_SESSION['VALIDADO']) || !isset($_SESSION['KEYSECRETA'])) {
    $_SESSION['VALIDADO'] = "NO";
    $_SESSION['KEYSECRETA'] = "0";
}

//VALIDAMOS SESSION
if ($_SESSION['VALIDADO'] == $_SESSION['KEYSECRETA']) {

    if (isset($_POST['action']) && !empty($_POST['action']) || isset($_POST['renombre']) && !empty($_POST['renombre'])) {

        $archivo = "";
        $renombre = "";
        $retorno = "";
        $elerror = 0;
        $nuevofile = "";
        $getinfofile = "";

        $archivo = test_input($_POST['action']);
        $renombre = test_input($_POST['renombre']);

        $getinfofile = pathinfo($archivo);
        $nuevofile = $getinfofile['dirname'];
        $nuevofile .= "/" . $renombre;

        //COMPROVAR SI ESTA VACIO
        if ($renombre == "") {
            $retorno = "vacio";
            $elerror = 1;
        }

        //COMPROVAR SI EL NUEVO A CREAR EXISTE
        if (file_exists($nuevofile)) {
            $retorno = "yaexiste";
            $elerror = 1;
        }

        //COMPROVAR SI SE PUEDE ESCRIVIR
        if ($elerror == 0) {
            if (!is_writable($archivo)) {
                $retorno = "nowrite";
                $elerror = 1;
            }
        }

        //RENOMBRAR
        if ($elerror == 0) {
            $retorno = rename($archivo, $nuevofile);
        }

        echo $retorno;
    }
}
