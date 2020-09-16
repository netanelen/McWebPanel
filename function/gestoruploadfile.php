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

    if (isset($_SESSION['RUTACTUAL'])) {

        if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {

            $retorno = "";
            $elerror = 0;
            $target_dir = "";
            $target_file = "";
            $tmp = "";
            $archivo = "";

            //GUARDAMOS LA RUTA DONDE SE SUBIRAN LOS ARCHIVOS
            $target_dir = $_SESSION['RUTACTUAL'];

            //GUARDAMOS EL ARCHIVO TEMPORAL A SUBIR
            $tmp = $_FILES['uploadedFile']['tmp_name'];

            //COMPROVAR SI SE PUEDE ESCRIVIR LA RUTA
            if (!is_writable($target_dir)) {
                $retorno = "nowrite";
                $elerror = 1;
            }

            //COMPROVAR SI EXISTE UN ARCHIVO IGUAL
            if ($elerror == 0) {
                $archivo = $target_dir;
                $archivo .= "/" . $_FILES['uploadedFile']['name'];

                if (file_exists($archivo)) {
                    $retorno = "yaexiste";
                    $elerror = 1;
                }
            }

            //SUBIR ARCHIVO
            if ($elerror == 0) {

                $target_file = $target_dir . "/" . basename($_FILES["uploadedFile"]["name"]);

                if (move_uploaded_file($tmp, $target_file)) {
                    $retorno = "subidook";
                } else {
                    $retorno = "errorupload";
                }
            }
        } else {

            $retorno = "errprocess";
        }

        echo $retorno;
    }
}
