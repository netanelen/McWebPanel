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

  if ($_SESSION['CONFIGUSER']['rango'] == 1 || $_SESSION['CONFIGUSER']['rango'] == 2) {

    if (isset($_POST['action']) && !empty($_POST['action'])) {
      $retorno = "";
      $elerror = 0;
      $laaction = test_input($_POST['action']);

      $carpraiz = dirname(getcwd()) . PHP_EOL;
      $carpraiz = trim($carpraiz);

      $carpcompilar = $carpraiz . "/compilar";
      $elssh = $carpcompilar . "/compilar.sh";
      $elbuildtools = $carpcompilar . "/BuildTools.jar";
      $archivolog = $carpcompilar . "/BuildTools.log.txt";

      //VERIFICAR LECTURA CARPETA RAIZ
      if ($elerror == 0) {
        clearstatcache();
        if (!is_readable($carpraiz)) {
          $retorno = "noreadraiz";
          $elerror = 1;
        }
      }

      //VERIFICAR ESCRITURA CARPETA RAIZ
      if ($elerror == 0) {
        clearstatcache();
        if (!is_writable($carpraiz)) {
          $retorno = "nowriteraiz";
          $elerror = 1;
        }
      }

      if ($elerror == 0) {
        if ($laaction == "compilar") {

          //SABER SI ESTA EN EJECUCION
          $elcomando = "";
          $nombresession = str_replace("/", "", $carpcompilar);
          $elcomando = "screen -ls | awk '/\." . $nombresession . "\t/ {print strtonum($1)'}";
          $elpid = shell_exec($elcomando);

          if ($elpid == "") {
            $elerror = 0;
          } else {
            $elerror = 1;
            $retorno = "yaenmarcha";
          }

          if ($elerror == 0) {

            $recjavaselect = CONFIGJAVASELECT;
            $recjavaname = CONFIGJAVANAME;
            $recjavamanual = CONFIGJAVAMANUAL;

            $javaruta = "";

            //OBTENER VERSION AJAX
            $version = test_input($_POST['laversion']);

            //OBTENER CARPETA SERVIDOR MINECRAFT
            $elnombredirectorio = $carpraiz . "/" . CONFIGDIRECTORIO . "/";

            //OBTENER FECHA
            $t = date("Y-m-d-G-i-s");

            //BORRAR CARPETA COMPILAR (SI EXISTIERA)
            clearstatcache();
            if (file_exists($carpcompilar)) {
              if (is_writable($carpcompilar)) {
                $comando = "cd " . $carpraiz . " && rm -R compilar";
                exec($comando);
              } else {
                $retorno = "nowritecompilar";
                $elerror = 1;
              }
            }
          }

          if ($elerror == 0) {

            //CREAR CARPETA
            mkdir($carpcompilar, 0700);

            //FORZAR .htaccess
            $rutahta = $carpcompilar . "/.htaccess";
            $file = fopen($rutahta, "w");
            fwrite($file, "deny from all" . PHP_EOL);
            fclose($file);

            //CREACION DEL SSH
            $file = fopen($elssh, "w");
            fwrite($file, "#!/bin/bash" . PHP_EOL);
            fwrite($file, "wget https://hub.spigotmc.org/jenkins/job/BuildTools/lastSuccessfulBuild/artifact/target/BuildTools.jar" . PHP_EOL);
            fclose($file);

            $comando = "cd " . $carpcompilar . " && chmod +x compilar.sh && sh compilar.sh";
            exec($comando);

            //COMPRUEBA LA DESCARGA DE BUILDTOOLS
            clearstatcache();
            if (!file_exists($elbuildtools)) {
              $retorno = "nobuildtools";
              $elerror = 1;
            }
          }

          //INICIAR VARIABLE JAVARUTA Y COMPROBAR SI EXISTE
          if ($elerror == 0) {
            if ($recjavaselect == "0") {
              $javaruta = "java";
            } elseif ($recjavaselect == "1") {
              $javaruta = $recjavaname;
              clearstatcache();
              if (!file_exists($javaruta)) {
                $retorno = "nojavaenruta";
                $elerror = 1;
              }
            } elseif ($recjavaselect == "2") {
              $javaruta = $recjavamanual . "/bin/java";
              clearstatcache();
              if (!file_exists($javaruta)) {
                $retorno = "nojavaenruta";
                $elerror = 1;
              }
            }
          }

          if ($elerror == 0) {
            $file = fopen($elssh, "w");
            fwrite($file, "#!/bin/bash" . PHP_EOL);
            fwrite($file, "chmod +x BuildTools.jar" . PHP_EOL);
            fwrite($file, "export HOME=" . $carpcompilar . PHP_EOL);
            fwrite($file, "export XDG_CONFIG_HOME=" . $carpcompilar . "/.config" . PHP_EOL);
            fwrite($file, "export M2_HOME=" . $carpcompilar . "/.m2" . PHP_EOL);
            fwrite($file, "git config --global --unset core.autocrlf" . PHP_EOL);
            fwrite($file, $javaruta . " -Xmx1024M -jar BuildTools.jar --rev " . $version . PHP_EOL);
            fwrite($file, "mv spigot-" . $version . ".jar spigot-" . $version . "-" . $t . ".jar" . PHP_EOL);
            fwrite($file, "mv spigot-" . $version . "-" . $t . ".jar " . $elnombredirectorio . "spigot-" . $version . "-" . $t . ".jar" . PHP_EOL);
            fclose($file);

            //DAR PERMISOS AL SH
            $comando = "cd " . $carpcompilar . " && chmod +x compilar.sh";
            exec($comando);

            //GENERAR UNA SESSION PARA EL SCREEN, QUITANDO LAS / DE LA RUTA AL NO ESTAR SOPORTADO
            $nombresession = str_replace("/", "", $carpcompilar);

            //INICIAR SCREEN
            $comando = "cd " . $carpcompilar . " && umask 002 && screen -Logfile sacado.txt -dmS '" . $nombresession . "' sh compilar.sh";
            shell_exec($comando);

            $retorno = "OK";
          }
        } elseif ($laaction == "consola") {

          //COMPROVAR SI EXISTE LA RUTA
          clearstatcache();
          if (file_exists($archivolog)) {
            //COMPROVAR SI SE PUEDE LEER
            clearstatcache();
            if (is_readable($archivolog)) {
              //LEER ARCHIVO
              $retorno = file_get_contents($archivolog);
            } else {
              $retorno = "No se puede leer el archivo";
            }
          } else {
            $retorno = "";
          }
        } elseif ($laaction == "estado") {
          //SABER SI ESTA EN EJECUCION
          $elcomando = "";
          $nombresession = str_replace("/", "", $carpcompilar);
          $elcomando = "screen -ls | awk '/\." . $nombresession . "\t/ {print strtonum($1)'}";
          $elpid = shell_exec($elcomando);

          if ($elpid == "") {
            $retorno = "OFF";
          } else {
            $retorno = "ON";
          }
        }
      }

      echo $retorno;
    }
  }
}
