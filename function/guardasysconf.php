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

$retorno = "";

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

if ($_SESSION['VALIDADO'] == $_SESSION['KEYSECRETA']) {

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['action']) && $_POST['action'] === 'submit') {

      $elerror = 0;

      $elnombreservidor = test_input($_POST["elnomserv"]);
      $eldirectorio = CONFIGDIRECTORIO;
      $elpuerto = test_input($_POST["elport"]);
      $laram = test_input($_POST["elram"]);
      $eltiposerver = test_input($_POST["eltipserv"]);
      $eluploadmax = test_input($_POST["elmaxupload"]);
      $elpostmax = "";

      if (isset($_POST["listadojars"])) {
        $ellistadojars = test_input($_POST["listadojars"]);
      } else {
        $ellistadojars = "";
      }

      $eleulaminecraft = test_input($_POST["minecrafteula"]);

      //OBTENER RUTA DONDE TIENE QUE ESTAR LA CARPETA CONFIG
      $dirconfig = "";
      $dirconfig = dirname(getcwd()) . PHP_EOL;
      $dirconfig = trim($dirconfig);
      $dirconfig .= "/config";

      //OBTENER RUTA RAIZ
      $rutaraiz = dirname(getcwd()) . PHP_EOL;
      $rutaraiz = trim($rutaraiz);

      //COMPROVAR SI EXISTE CARPETA CONF
      if ($elerror == 0) {
        clearstatcache();
        if (!file_exists($dirconfig)) {
          $retorno = "nocarpetaconf";
          $elerror = 1;
        }
      }

      //COMPROVAR SI SE PUEDE ESCRIVIR CARPETA CONF
      if ($elerror == 0) {
        clearstatcache();
        if (!is_writable($dirconfig)) {
          $retorno = "nowriteconf";
          $elerror = 1;
        }
      }

      //COMPROVAR SI SE PUEDE ESCRIVIR ARCHIVO .htaccess de la raiz
      if ($elerror == 0) {
        $rutaescrivir = $rutaraiz;
        $rutaescrivir .= "/.htaccess";

        clearstatcache();
        if (!is_writable($rutaescrivir)) {
          $retorno = "nowritehtaccess";
          $elerror = 1;
        }
      }

      if ($elerror == 0) {
        //CREAR RUTA FICHERO .htaccess en config
        $rutaescrivir = $dirconfig;
        $rutaescrivir .= "/.htaccess";

        //GUARDAR FICHERO .htaccess en config
        $file = fopen($rutaescrivir, "w");
        fwrite($file, "deny from all" . PHP_EOL);
        fclose($file);

        //CREAR RUTA FICHERO CONFOPCIONES.PHP
        $rutaescrivir = $dirconfig;
        $rutaescrivir .= "/confopciones.php";

        //GUARDAR FICHERO CONFOPCIONES.PHP
        $file = fopen($rutaescrivir, "w");
        fwrite($file, "<?php " . PHP_EOL);
        fwrite($file, 'define("CONFIGNOMBRESERVER", "' . $elnombreservidor . '");' . PHP_EOL);
        fwrite($file, 'define("CONFIGDIRECTORIO", "' . $eldirectorio . '");' . PHP_EOL);
        fwrite($file, 'define("CONFIGPUERTO", "' . $elpuerto . '");' . PHP_EOL);
        fwrite($file, 'define("CONFIGRAM", "' . $laram . '");' . PHP_EOL);
        fwrite($file, 'define("CONFIGTIPOSERVER", "' . $eltiposerver . '");' . PHP_EOL);
        fwrite($file, 'define("CONFIGARCHIVOJAR", "' . $ellistadojars . '");' . PHP_EOL);
        fwrite($file, 'define("CONFIGEULAMINECRAFT", "' . $eleulaminecraft . '");' . PHP_EOL);
        fwrite($file, 'define("CONFIGMAXUPLOAD", "' . $eluploadmax . '");' . PHP_EOL);
        fwrite($file, "?>" . PHP_EOL);
        fclose($file);

        $rutaescrivir = $rutaraiz;
        $rutaescrivir .= "/.htaccess";

        $elpostmax = $eluploadmax + 1;

        $linea1 = "php_value upload_max_filesize " . $eluploadmax . "M";
        $linea2 = "php_value post_max_size " . $elpostmax . "M";

        //GUARDAR FICHERO .HTACCESS EN RAIZ
        $file = fopen($rutaescrivir, "w");
        fwrite($file, $linea1 . PHP_EOL);
        fwrite($file, $linea2 . PHP_EOL);
        fwrite($file, "php_value max_execution_time 600" . PHP_EOL);
        fwrite($file, "php_value max_input_time 600" . PHP_EOL);
        fclose($file);

        $retorno = "saveconf";
      }
      echo $retorno;
    }
  }
}
