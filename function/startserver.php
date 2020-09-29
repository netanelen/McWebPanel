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

    if (isset($_POST['action']) && !empty($_POST['action'])) {

        $retorno = "";
        $elerror = 0;

        $reccarpmine = CONFIGDIRECTORIO;
        $recarchivojar = CONFIGARCHIVOJAR;
        $recram = CONFIGRAM;
        $rectiposerv = CONFIGTIPOSERVER;
        $receulaminecraft = CONFIGEULAMINECRAFT;
        $recpuerto = CONFIGPUERTO;

        $rutacarpetamine = "";

        //VERIFICAR CARPETA MINECRAFT
        $rutacarpetamine = dirname(getcwd()) . PHP_EOL;
        $rutacarpetamine = trim($rutacarpetamine);
        $rutacarpetamine .= "/" . $reccarpmine;

        if (!file_exists($rutacarpetamine)) {
            $elerror = 1;
            $retorno = "noexistecarpetaminecraft";
        }

        //VERIFICAR EULA
        if ($elerror == 0) {
            if ($receulaminecraft == "") {
                $elerror = 1;
                $retorno = "noeula";
            } elseif ($receulaminecraft == "1") {
                $rutaescrivir = $rutacarpetamine;
                $rutaescrivir .= "/eula.txt";

                $file = fopen($rutaescrivir, "w");
                fwrite($file, "eula=true" . PHP_EOL);
                fclose($file);
            }
        }

        //VERIFICAR SI HAY NOMBRE.JAR
        if ($elerror == 0) {
            if ($recarchivojar == "") {
                $elerror = 1;
                $retorno = "noconfjar";
            }
        }

        //VERIFICAR SI HAY PERMISOS DE LECTURA EN EL SERVIDOR MINECRAFT
        if ($elerror == 0) {
            if (!is_readable($rutacarpetamine)) {
                $elerror = 1;
                $retorno = "nolecturamine";
            }
        }

        //VERIFICAR SI HAY PERMISOS DE EJECUCION EN EL SERVIDOR MINECRAFT
        if ($elerror == 0) {
            if (!is_executable($rutacarpetamine)) {
                $elerror = 1;
                $retorno = "noejecutable";
            }
        }

        //VERIFICAR SI EXISTE REALMENTE
        if ($elerror == 0) {
            $rutacarpetamine = dirname(getcwd()) . PHP_EOL;
            $rutacarpetamine = trim($rutacarpetamine);
            $rutacarpetamine .= "/" . $reccarpmine . "/" . $recarchivojar;

            if (!file_exists($rutacarpetamine)) {
                $elerror = 1;
                $retorno = "noexistejar";
            }
        }

        //VERIFICAR SI HAY ESCRITURA
        if ($elerror == 0) {
            $rutacarpetamine = dirname(getcwd()) . PHP_EOL;
            $rutacarpetamine = trim($rutacarpetamine);
            $rutacarpetamine .= "/" . $reccarpmine;

            if (!is_writable($rutacarpetamine)) {
                $elerror = 1;
                $retorno = "noescritura";
            }
        }

        //COMPROVAR PUERTO EN USO
        if ($elerror == 0) {
            $comandopuerto = "netstat -tulpn 2>/dev/null | grep :" . $recpuerto;
            $obtener = exec($comandopuerto);
            if ($obtener != "") {
                $elerror = 1;
                $retorno = "puertoenuso";
            }
        }

        //COMPROVAR SERVER.PROPERTIES
        if ($elerror == 0) {
            $rutacarpetamine = dirname(getcwd()) . PHP_EOL;
            $rutacarpetamine = trim($rutacarpetamine);
            $rutatemp = $rutacarpetamine;
            $rutafinal = $rutacarpetamine;
            $rutacarpetamine .= "/config/serverproperties.txt";
            $rutatemp .= "/config/serverproperties.tmp";
            $rutafinal .= "/" . $reccarpmine . "/server.properties";

            if (file_exists($rutacarpetamine)) {
                $gestor = @fopen($rutacarpetamine, "r");
                $file = fopen($rutatemp, "w");
                if ($gestor) {
                    while (($búfer = fgets($gestor, 4096)) !== false) {
                        $str = $búfer;
                        $array = explode("=", $str);
                        if ($array[0] == "server-port") {
                            fwrite($file, 'server-port=' . $recpuerto . PHP_EOL);
                        } else {
                            fwrite($file, $búfer);
                        }
                    }

                    if (!feof($gestor)) {
                        $elerror = 1;
                        $retorno = "fallofgets";
                    }

                    fclose($gestor);
                    fclose($file);
                    unlink($rutacarpetamine);
                    rename($rutatemp, $rutacarpetamine);
                    copy($rutacarpetamine, $rutafinal);
                }
            } else {
                $elerror = 1;
                $retorno = "noserverpropertiestxt";
            }
        }

        //INSERTAR SERVER-ICON EN CASO QUE NO EXISTA
        if ($elerror == 0) {
            $rutacarpetamine = dirname(getcwd()) . PHP_EOL;
            $rutacarpetamine = trim($rutacarpetamine);

            $rutaiconoimg = $rutacarpetamine . "/img/server-icon.png";
            $rutaiconofinal = $rutacarpetamine . "/" . $reccarpmine . "/server-icon.png";
            $rutacarpetamine .= "/" . $reccarpmine;

            //COMPROVAR SI EXISTE EN CARPETA IMG Y COPIARLA EN CASO QUE EL SERVIDOR NO LA TENGA
            if (file_exists($rutaiconoimg)) {
                if (!file_exists($rutaiconofinal)) {
                    copy($rutaiconoimg, $rutaiconofinal);
                }
            }
        }

        //INICIAR SERVIDOR
        if ($elerror == 0) {
            $comandoserver = "";

            $rutacarpetamine = dirname(getcwd()) . PHP_EOL;
            $rutacarpetamine = trim($rutacarpetamine);
            $rutacarpetamine .= "/" . $reccarpmine . "/" . $recarchivojar;

            if ($rectiposerv == "vanilla") {
                //java -jar minecraft_server.jar nogui
                $comandoserver .= "cd .. && cd " . $reccarpmine . " && umask 002 && screen -dmS " . $reccarpmine . " java -Xms1G -Xmx" . $recram . "G -jar '" . $rutacarpetamine . "' nogui";
            } elseif ($rectiposerv == "spigot") {
                //shell_exec('cd minecraft1 && screen -dmS minecraft1 java -Xms1G -Xmx8G -XX:+UseConcMarkSweepGC -Djline.terminal=jline.UnsupportedTerminal -Dfile.encoding=UTF8 -jar /var/www/mineadmin/minecraft1/server.jar nogui -nojline --log-strip-color');
                $comandoserver .= "cd .. && cd " . $reccarpmine . " && umask 002 && screen -dmS " . $reccarpmine . " java -Xms1G -Xmx" . $recram . "G -XX:+UseConcMarkSweepGC -Djline.terminal=jline.UnsupportedTerminal -Dfile.encoding=UTF8 -jar '" . $rutacarpetamine . "' nogui -nojline --log-strip-color";
            } elseif ($rectiposerv == "paper") {
                $comandoserver .= "cd .. && cd " . $reccarpmine . " && umask 002 && screen -dmS " . $reccarpmine . " java -Xms1G -Xmx" . $recram . "G -jar '" . $rutacarpetamine . "' nogui";
            } elseif ($rectiposerv == "otros") {
                $comandoserver .= "cd .. && cd " . $reccarpmine . " && umask 002 && screen -dmS " . $reccarpmine . " java -Xms1G -Xmx" . $recram . "G -jar '" . $rutacarpetamine . "' nogui";
            }
            //echo $comandoserver;
            $elpid = shell_exec($comandoserver);
            $retorno = "ok";
        }
        echo $retorno;
    }
}
