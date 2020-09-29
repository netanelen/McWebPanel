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

$RUTAPRINCIPAL = $_SERVER['PHP_SELF'];
$RUTAPRINCIPAL = substr($RUTAPRINCIPAL, 0, -14);
$RUTACONFIG = $RUTAPRINCIPAL . "/config/confopciones.php";

require_once($RUTACONFIG);

$elerror = 0;
$time = date("G:i");
$mesactual = date('n');
$semanactual = date('N');
$horactual = date('G');
$minutoactual = date('i');

//OBTENER RUTA CONFIG
$rutaarchivo = $RUTAPRINCIPAL;
$rutaarchivo = trim($rutaarchivo);
$rutaarchivo .= "/config";

$elarchivo = $rutaarchivo;
$elarchivo .= "/array.json";

//COMPROVAR SI EXISTE CARPETA CONFIG
if ($elerror == 0) {
    if (!file_exists($rutaarchivo)) {
        $elerror = 1;
    }
}

//COMPROVAR SI CONFIG TIENE PERMISOS DE LECTURA
if ($elerror == 0) {
    if (!is_readable($rutaarchivo)) {
        $elerror = 1;
    }
}

//COMPROVAR SI CONFIG TIENE PERMISOS DE ESCRITURA
if ($elerror == 0) {
    if (!is_writable($rutaarchivo)) {
        $elerror = 1;
    }
}

if ($elerror == 0) {
    clearstatcache();
    if (file_exists($elarchivo)) {

        //COMPROVAR SI SE PUEDE LEER EL JSON
        if ($elerror == 0) {
            if (!is_readable($elarchivo)) {
                $elerror = 1;
            }
        }

        //COMPROVAR SI SE PUEDE ESCRIVIR EL JSON
        if ($elerror == 0) {
            if (!is_writable($elarchivo)) {
                $elerror = 1;
            }
        }

        if ($elerror == 0) {
            //LEER FICHERO OBTENER ARRAY
            $getarray = file_get_contents($elarchivo);
            $arrayobtenido = unserialize($getarray);

            $elindice = count($arrayobtenido);

            for ($i = 0; $i < $elindice; $i++) {
                if ($arrayobtenido[$i]['estado'] == "activado") {
                    for ($a = 0; $a < 12; $a++) {
                        if ($arrayobtenido[$i][$a]['mes'] == $mesactual) {
                            for ($b = 0; $b < 7; $b++) {
                                if ($arrayobtenido[$i][$b]['semana'] == $semanactual) {
                                    for ($c = 0; $c < 24; $c++) {
                                        if ($arrayobtenido[$i][$c]['hora'] == $horactual) {
                                            for ($d = 0; $d < 60; $d++) {
                                                if ($arrayobtenido[$i][$d]['minuto'] == $minutoactual) {
                                                    //TAREA VALIDA PROCEDER A LA EJECUCION
                                                    $tarea = $arrayobtenido[$i]['accion'];
                                                    //echo "DENTRO";

                                                    switch ($tarea) {
                                                        case "acc1":
                                                            //APAGAR SERVIDOR

                                                            //OBTENER PID SABER SI ESTA EN EJECUCION
                                                            $elcomando = "";
                                                            $elnombrescreen = CONFIGDIRECTORIO;
                                                            $elcomando = "screen -ls | awk '/\." . $elnombrescreen . "\t/ {print strtonum($1)'}";
                                                            $elpid = shell_exec($elcomando);

                                                            //SI ESTA EN EJECUCION ENVIAR COMANDO APAGAR
                                                            if (!$elpid == "") {
                                                                $paraejecutar = "stop";
                                                                $laejecucion = 'screen -S ' . $elnombrescreen . ' -X stuff "' . $paraejecutar . '\\015"';
                                                                shell_exec($laejecucion);
                                                            }

                                                            break;
                                                        case "acc2":
                                                            //INICIAR SERVIDOR

                                                            //OBTENER PID SABER SI ESTA EN EJECUCION
                                                            $elcomando = "";
                                                            $elnombrescreen = CONFIGDIRECTORIO;
                                                            $elcomando = "screen -ls | awk '/\." . $elnombrescreen . "\t/ {print strtonum($1)'}";
                                                            $elpid = shell_exec($elcomando);

                                                            if ($elpid == "") {

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
                                                                $rutacarpetamine = $RUTAPRINCIPAL;
                                                                $rutacarpetamine = trim($rutacarpetamine);
                                                                $rutacarpetamine .= "/" . $reccarpmine;

                                                                if (!file_exists($rutacarpetamine)) {
                                                                    $retorno = "no existe carpeta";
                                                                    $elerror = 1;
                                                                }

                                                                //VERIFICAR EULA
                                                                if ($elerror == 0) {
                                                                    if ($receulaminecraft == "") {
                                                                        $retorno = "no hay eula";
                                                                        $elerror = 1;
                                                                    }
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
                                                                        $retorno = "sin nombre jar";
                                                                        $elerror = 1;
                                                                    }
                                                                }

                                                                //VERIFICAR SI HAY PERMISOS DE LECTURA EN EL SERVIDOR MINECRAFT
                                                                if ($elerror == 0) {
                                                                    if (!is_readable($rutacarpetamine)) {
                                                                        $retorno = "no ruta lectura mine";
                                                                        $elerror = 1;
                                                                    }
                                                                }

                                                                //VERIFICAR SI HAY PERMISOS DE EJECUCION EN EL SERVIDOR MINECRAFT
                                                                if ($elerror == 0) {
                                                                    if (!is_executable($rutacarpetamine)) {
                                                                        $retorno = "no ruta ejecucion mine";
                                                                        $elerror = 1;
                                                                    }
                                                                }

                                                                //VERIFICAR SI EXISTE REALMENTE
                                                                if ($elerror == 0) {
                                                                    $rutacarpetamine = $RUTAPRINCIPAL;
                                                                    $rutacarpetamine = trim($rutacarpetamine);
                                                                    $rutacarpetamine .= "/" . $reccarpmine . "/" . $recarchivojar;

                                                                    if (!file_exists($rutacarpetamine)) {
                                                                        $retorno = "no existe realmente el jar";
                                                                        $elerror = 1;
                                                                    }
                                                                }

                                                                //VERIFICAR SI HAY ESCRITURA
                                                                if ($elerror == 0) {
                                                                    $rutacarpetamine = $RUTAPRINCIPAL;
                                                                    $rutacarpetamine = trim($rutacarpetamine);
                                                                    $rutacarpetamine .= "/" . $reccarpmine;

                                                                    if (!is_writable($rutacarpetamine)) {
                                                                        $retorno = "no hay escritura mine";
                                                                        $elerror = 1;
                                                                    }
                                                                }

                                                                //COMPROVAR PUERTO EN USO
                                                                if ($elerror == 0) {
                                                                    $comandopuerto = "netstat -tulpn 2>/dev/null | grep :" . $recpuerto;
                                                                    $obtener = exec($comandopuerto);
                                                                    if ($obtener != "") {
                                                                        $retorno = "no puerto";
                                                                        $elerror = 1;
                                                                    }
                                                                }

                                                                //COMPROVAR SERVER.PROPERTIES
                                                                if ($elerror == 0) {
                                                                    $rutacarpetamine = $RUTAPRINCIPAL;
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
                                                                            }

                                                                            fclose($gestor);
                                                                            fclose($file);
                                                                            unlink($rutacarpetamine);
                                                                            rename($rutatemp, $rutacarpetamine);
                                                                            copy($rutacarpetamine, $rutafinal);
                                                                        }
                                                                    } else {
                                                                        $retorno = "no existe carpeta mine tutu";
                                                                        $elerror = 1;
                                                                    }
                                                                }

                                                                //INICIAR SERVIDOR
                                                                if ($elerror == 0) {

                                                                    $comandoserver = "";

                                                                    $rutacarpetamine = $RUTAPRINCIPAL;
                                                                    $rutacarpetamine = trim($rutacarpetamine);
                                                                    $rutacarpetamine .= "/" . $reccarpmine . "/" . $recarchivojar;

                                                                    if ($rectiposerv == "vanilla") {
                                                                        $comandoserver .= "cd " . $RUTAPRINCIPAL . " && cd " . $reccarpmine . " && umask 002 && screen -dmS " . $reccarpmine . " java -Xms1G -Xmx" . $recram . "G -jar '" . $rutacarpetamine . "' nogui";
                                                                    } elseif ($rectiposerv == "spigot") {
                                                                        $comandoserver .= "cd " . $RUTAPRINCIPAL . " && cd " . $reccarpmine . " && umask 002 && screen -dmS " . $reccarpmine . " java -Xms1G -Xmx" . $recram . "G -XX:+UseConcMarkSweepGC -Djline.terminal=jline.UnsupportedTerminal -Dfile.encoding=UTF8 -jar '" . $rutacarpetamine . "' nogui -nojline --log-strip-color";
                                                                    } elseif ($rectiposerv == "paper") {
                                                                        $comandoserver .= "cd " . $RUTAPRINCIPAL . " && cd " . $reccarpmine . " && umask 002 && screen -dmS " . $reccarpmine . " java -Xms1G -Xmx" . $recram . "G -jar '" . $rutacarpetamine . "' nogui";
                                                                    } elseif ($rectiposerv == "otros") {
                                                                        $comandoserver .= "cd " . $RUTAPRINCIPAL . " && cd " . $reccarpmine . " && umask 002 && screen -dmS " . $reccarpmine . " java -Xms1G -Xmx" . $recram . "G -jar '" . $rutacarpetamine . "' nogui";
                                                                    }
                                                                    $elpid = shell_exec($comandoserver);
                                                                }
                                                            }

                                                            break;
                                                        case "acc3":
                                                            //BACKUP SERVIDOR

                                                            $reccarpmine = CONFIGDIRECTORIO;

                                                            $archivo = "AUTOMATICO";

                                                            $dirconfig = "";
                                                            $dirconfig = $RUTAPRINCIPAL;
                                                            $dirconfig = trim($dirconfig);
                                                            $dirconfig .= "/backups";

                                                            if (file_exists($dirconfig)) {
                                                                //COMPROVAR SI SE PUEDE ESCRIVIR
                                                                if (is_writable($dirconfig)) {
                                                                    $rutaarchivo = $RUTAPRINCIPAL;
                                                                    $rutaarchivo = trim($rutaarchivo);
                                                                    $rutaminelimpia = $rutaarchivo . "/" . $reccarpmine;
                                                                    if (is_readable($rutaminelimpia)) {
                                                                        $rutaarchivo .= "/" . $reccarpmine . "/ .";
                                                                        $dirconfig = $dirconfig . "/" . $archivo . "-";
                                                                        $t = time();
                                                                        $elcomando = "tar -czvf " . $dirconfig . $t . ".tar.gz -C " . $rutaarchivo;
                                                                        if (is_executable($rutaminelimpia)) {
                                                                            exec($elcomando, $out, $oky);

                                                                            if (!$oky) {
                                                                            } else {

                                                                                //AUNQUE NO SE CREA, A VECES SI CREA UN FICHERO VACIO
                                                                                $borrarerror = $dirconfig . $t . ".tar.gz";
                                                                                if (file_exists($borrarerror)) {
                                                                                    unlink($borrarerror);
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            break;
                                                        case "acc4":
                                                            //ENVIAR COMANDO

                                                            $paraejecutar = $arrayobtenido[$i]['comando'];

                                                            //OBTENER PID SABER SI ESTA EN EJECUCION
                                                            $elcomando = "";
                                                            $elnombrescreen = CONFIGDIRECTORIO;
                                                            $elcomando = "screen -ls | awk '/\." . $elnombrescreen . "\t/ {print strtonum($1)'}";
                                                            $elpid = shell_exec($elcomando);

                                                            //SI ESTA EN EJECUCION ENVIAR COMANDO
                                                            if (!$elpid == "") {
                                                                $laejecucion = 'screen -S ' . $elnombrescreen . ' -X stuff "' . $paraejecutar . '\\015"';
                                                                shell_exec($laejecucion);
                                                            }

                                                            break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
