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
header("Content-Security-Policy: default-src 'none'; style-src 'self'; img-src 'self'; script-src 'self'; form-action 'self'; base-uri 'none'; connect-src 'self'; frame-ancestors 'none'");
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=63072000; includeSubDomains; preload');
header("X-XSS-Protection: 1; mode=block");

$RUTAPRINCIPAL = $_SERVER['PHP_SELF'];
$RUTAPRINCIPAL = substr($RUTAPRINCIPAL, 0, -14);
$RUTACONFIG = $RUTAPRINCIPAL . "/config/confopciones.php";

require_once($RUTACONFIG);

$retorno = "";
$logfechayhora = "[" . date("d/m/Y") . "] [" . date("H:i:s") . "]";

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
        $retorno = "Error la carpeta config no tiene permisos de lectura.";
        $elerror = 1;
    }
}

//COMPROVAR SI CONFIG TIENE PERMISOS DE ESCRITURA
if ($elerror == 0) {
    if (!is_writable($rutaarchivo)) {
        $retorno = "Error la carpeta config no tiene permisos de escritura.";
        $elerror = 1;
    }
}

if ($elerror == 0) {
    clearstatcache();
    if (file_exists($elarchivo)) {

        //COMPROVAR SI SE PUEDE LEER EL JSON
        if ($elerror == 0) {
            if (!is_readable($elarchivo)) {
                $retorno = "Error el archivo de tareas no tiene permisos de lectura.";
                $elerror = 1;
            }
        }

        //COMPROVAR SI SE PUEDE ESCRIVIR EL JSON
        if ($elerror == 0) {
            if (!is_writable($elarchivo)) {
                $retorno = "Error el archivo de tareas no tiene permisos de escritura.";
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
                                                                $retorno = "Tarea Apagar Servidor, ejecutado correctamente.";
                                                            } else {
                                                                $retorno = "Tarea Apagar Servidor, no se puede realizar al estar apagado.";
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

                                                                function guardareinicio($rutaelsh, $elcom, $rutaarchivlog)
                                                                {
                                                                    $rutaelsh .= "/start.sh";

                                                                    clearstatcache();
                                                                    if (file_exists($rutaelsh)) {
                                                                        clearstatcache();
                                                                        if (is_writable($rutaelsh)) {
                                                                            $file = fopen($rutaelsh, "w");
                                                                            fwrite($file, "#!/bin/sh" . PHP_EOL);
                                                                            fwrite($file, "rm " . $rutaarchivlog . PHP_EOL);
                                                                            fwrite($file, $elcom . PHP_EOL);
                                                                            fclose($file);
                                                                        }
                                                                    } else {
                                                                        $file = fopen($rutaelsh, "w");
                                                                        fwrite($file, "#!/bin/sh" . PHP_EOL);
                                                                        fwrite($file, $elcom . PHP_EOL);
                                                                        fclose($file);
                                                                    }
                                                                }

                                                                $retorno = "";
                                                                $elerror = 0;

                                                                $reccarpmine = CONFIGDIRECTORIO;
                                                                $recarchivojar = CONFIGARCHIVOJAR;
                                                                $recram = CONFIGRAM;
                                                                $rectiposerv = CONFIGTIPOSERVER;
                                                                $receulaminecraft = CONFIGEULAMINECRAFT;
                                                                $recpuerto = CONFIGPUERTO;

                                                                $recgarbagecolector = CONFIGOPTIONGARBAGE;

                                                                $recjavaselect = CONFIGJAVASELECT;
                                                                $recjavaname = CONFIGJAVANAME;
                                                                $recjavamanual = CONFIGJAVAMANUAL;

                                                                $javaruta = "";

                                                                $rutacarpetamine = "";

                                                                //VERIFICAR CARPETA MINECRAFT
                                                                $rutacarpetamine = $RUTAPRINCIPAL;
                                                                $rutacarpetamine = trim($rutacarpetamine);
                                                                $rutacarpetamine .= "/" . $reccarpmine;

                                                                $rutaminecraffijo = $rutacarpetamine;

                                                                //VARIABLE RUTA CARPETA CONFIG
                                                                $rutacarpetaconfig = $RUTAPRINCIPAL;
                                                                $rutacarpetaconfig = trim($rutacarpetaconfig);
                                                                $rutacarpetaconfig .= "/config";

                                                                //VARIABLE RUTA SERVERPROPERTIES.TXT
                                                                $rutaconfigproperties = $rutacarpetaconfig . "/serverproperties.txt";

                                                                //VERIFICAR CARPETA MINECRAFT
                                                                if ($elerror == 0) {
                                                                    clearstatcache();
                                                                    if (!file_exists($rutacarpetamine)) {
                                                                        $elerror = 1;
                                                                        $retorno = "Error Tarea Iniciar Servidor, no existe la carpeta Minecraft.";
                                                                    }
                                                                }

                                                                //VERIFICAR SI HAY PERMISOS DE LECTURA EN EL SERVIDOR MINECRAFT
                                                                if ($elerror == 0) {
                                                                    clearstatcache();
                                                                    if (!is_readable($rutacarpetamine)) {
                                                                        $elerror = 1;
                                                                        $retorno = "Error Tarea Iniciar Servidor, no hay permisos de lectura en la carpeta Minecraft.";
                                                                    }
                                                                }

                                                                //VERIFICAR SI HAY ESCRITURA EN EL SERVIDOR MINECRAFT
                                                                if ($elerror == 0) {
                                                                    clearstatcache();
                                                                    if (!is_writable($rutacarpetamine)) {
                                                                        $elerror = 1;
                                                                        $retorno = "Error Tarea Iniciar Servidor, no hay permisos de escritura en la carpeta Minecraft.";
                                                                    }
                                                                }

                                                                //VERIFICAR SI HAY PERMISOS DE EJECUCION EN EL SERVIDOR MINECRAFT
                                                                if ($elerror == 0) {
                                                                    clearstatcache();
                                                                    if (!is_executable($rutacarpetamine)) {
                                                                        $elerror = 1;
                                                                        $retorno = "Error Tarea Iniciar Servidor, no hay permisos de ejecución en la carpeta Minecraft.";
                                                                    }
                                                                }

                                                                //VERIFICAR SI HAY ESCRITURA EN CARPETA CONFIG
                                                                if ($elerror == 0) {
                                                                    clearstatcache();
                                                                    if (!is_writable($rutacarpetaconfig)) {
                                                                        $elerror = 1;
                                                                        $retorno = "Error Tarea Iniciar Servidor, no hay permisos de escritura en la carpeta Config.";
                                                                    }
                                                                }

                                                                //VERIFICAR SI EXISTE ARCHIVO /CONFIG/SERVERPROPERTIES
                                                                if ($elerror == 0) {
                                                                    if (!file_exists($rutaconfigproperties)) {
                                                                        $elerror = 1;
                                                                        $retorno = "Error Tarea Iniciar Servidor, no existe el archivo /config/serverproperties.txt";
                                                                    }
                                                                }

                                                                //VERIFICAR SI HAY ESCRITURA EN ARCHIVO /CONFIG/SERVERPROPERTIES
                                                                if ($elerror == 0) {
                                                                    clearstatcache();
                                                                    if (!is_writable($rutaconfigproperties)) {
                                                                        $elerror = 1;
                                                                        $retorno = "Error Tarea Iniciar Servidor, no hay permisos de escritura en /config/serverproperties.txt";
                                                                    }
                                                                }

                                                                if ($elerror == 0) {
                                                                    if ($rectiposerv == "forge") {
                                                                        $libforge = $rutacarpetamine . "/libraries";
                                                                        clearstatcache();
                                                                        if (!file_exists($libforge)) {
                                                                            $retorno = "Error Tarea Iniciar Servidor, faltan las librerias necesarias para iniciar el servidor de Forge.";
                                                                            $elerror = 1;
                                                                        }
                                                                    }
                                                                }

                                                                //VERIFICAR EULA EN CONFIG
                                                                if ($elerror == 0) {
                                                                    if ($receulaminecraft != "1") {
                                                                        $elerror = 1;
                                                                        $retorno = "Error Tarea Iniciar Servidor, no has aceptado el eula de Minecraft.";
                                                                    }
                                                                }

                                                                //CREAR EULA FORZADO
                                                                if ($elerror == 0) {
                                                                    if ($receulaminecraft == "1") {
                                                                        $rutaescrivir = $rutacarpetamine;
                                                                        $rutaescrivir .= "/eula.txt";

                                                                        clearstatcache();
                                                                        if (file_exists($rutaescrivir)) {
                                                                            clearstatcache();
                                                                            if (is_writable($rutaconfigproperties)) {
                                                                                $file = fopen($rutaescrivir, "w");
                                                                                fwrite($file, "eula=true" . PHP_EOL);
                                                                                fclose($file);
                                                                            } else {
                                                                                $retorno = "Error Tarea Iniciar Servidor, no hay permisos de escritura en eula.txt";
                                                                                $elerror = 1;
                                                                            }
                                                                        } else {
                                                                            $file = fopen($rutaescrivir, "w");
                                                                            fwrite($file, "eula=true" . PHP_EOL);
                                                                            fclose($file);
                                                                        }
                                                                    }
                                                                }

                                                                //PERMISO EULA.TXT
                                                                $elcommando = "cd " . $rutaminecraffijo . " && chmod 664 eula.txt";
                                                                exec($elcommando);

                                                                //VERIFICAR SI HAY NOMBRE.JAR
                                                                if ($elerror == 0) {
                                                                    if ($recarchivojar == "") {
                                                                        $elerror = 1;
                                                                        $retorno = "Error Tarea Iniciar Servidor, no hay seleccionado un servidor .jar";
                                                                    }
                                                                }

                                                                //VERIFICAR SI EXISTE REALMENTE
                                                                if ($elerror == 0) {
                                                                    $rutajar = $rutacarpetamine . "/" . $reccarpmine . "/" . $recarchivojar;

                                                                    clearstatcache();
                                                                    if (!file_exists($rutacarpetamine)) {
                                                                        $elerror = 1;
                                                                        $retorno = "Error Tarea Iniciar Servidor, el .jar seleccionado no existe.";
                                                                    }
                                                                }

                                                                //COMPROVAR PUERTO EN USO
                                                                if ($elerror == 0) {
                                                                    $comandopuerto = "netstat -tulpn 2>/dev/null | grep :" . $recpuerto;
                                                                    $obtener = exec($comandopuerto);
                                                                    if ($obtener != "") {
                                                                        $retorno = "Error Tarea Iniciar Servidor, puerto ya en uso.";
                                                                        $elerror = 1;
                                                                    }
                                                                }

                                                                //COMPROVAR MEMORIA RAM
                                                                if ($elerror == 0) {
                                                                    $totalramsys = shell_exec("free -g | grep Mem | awk '{ print $2 }'");
                                                                    $totalramsys = trim($totalramsys);
                                                                    $totalramsys = intval($totalramsys);

                                                                    $getramavaliable = shell_exec("free -g | grep Mem | awk '{ print $7 }'");
                                                                    $getramavaliable = trim($getramavaliable);
                                                                    $getramavaliable = intval($getramavaliable);

                                                                    //COMPRUEBA SI AL MENOS SE TIENE 1GB
                                                                    if ($totalramsys == 0) {
                                                                        $elerror = 1;
                                                                        $retorno = "Error Tarea Iniciar Servidor, Memoria Ram menor a 1 GB.";
                                                                    } elseif ($totalramsys >= 1) {

                                                                        //COMPRUEBA QUE LA RAM SELECCIONADA NO SEA MAYOR A LA DEL SISTEMA
                                                                        if ($recram > $totalramsys) {
                                                                            $elerror = 1;
                                                                            $retorno = "Error Tarea Iniciar Servidor, la Ram seleccionada es superior a la del sistema.";
                                                                        }

                                                                        //COMPROBAR SI HAY MEMORIA SUFICIENTE PARA INICIAR CON RAM DISPONIBLE
                                                                        if ($elerror == 0) {
                                                                            if ($recram > $getramavaliable) {
                                                                                $elerror = 1;
                                                                                $retorno = "Error Tarea Iniciar Servidor, Memoria del sistema insuficiente para iniciar el servidor.";
                                                                            }
                                                                        }
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

                                                                    $gestor = @fopen($rutacarpetamine, "r");
                                                                    $file = fopen($rutatemp, "w");

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
                                                                        $retorno = "Error Tarea Iniciar Servidor, ocurrió un error al guardar server.properties.";
                                                                    }

                                                                    fclose($gestor);
                                                                    fclose($file);
                                                                    unlink($rutacarpetamine);
                                                                    rename($rutatemp, $rutacarpetamine);
                                                                    copy($rutacarpetamine, $rutafinal);
                                                                }

                                                                //INSERTAR SERVER-ICON EN CASO QUE NO EXISTA
                                                                if ($elerror == 0) {
                                                                    $rutacarpetamine = $RUTAPRINCIPAL;
                                                                    $rutacarpetamine = trim($rutacarpetamine);

                                                                    $rutaiconoimg = $rutacarpetamine . "/img/server-icon.png";
                                                                    $rutaiconofinal = $rutacarpetamine . "/" . $reccarpmine . "/server-icon.png";
                                                                    $rutacarpetamine .= "/" . $reccarpmine;

                                                                    //COMPROVAR SI EXISTE EN CARPETA IMG Y COPIARLA EN CASO QUE EL SERVIDOR NO LA TENGA
                                                                    clearstatcache();
                                                                    if (file_exists($rutaiconoimg)) {
                                                                        clearstatcache();
                                                                        if (!file_exists($rutaiconofinal)) {
                                                                            copy($rutaiconoimg, $rutaiconofinal);
                                                                        }
                                                                    }
                                                                }

                                                                //PERMISO SERVER-ICON.PNG
                                                                $elcommando = "cd " . $rutaminecraffijo . " && chmod 664 server-icon.png";
                                                                exec($elcommando);

                                                                //INICIAR VARIABLE JAVARUTA Y COMPROBAR SI EXISTE
                                                                if ($elerror == 0) {
                                                                    if ($recjavaselect == "0") {
                                                                        $javaruta = "java";
                                                                        //COMPROBAR SI JAVA DEFAULT EXISTE
                                                                        $comreq = shell_exec('command -v java >/dev/null && echo "yes" || echo "no"');
                                                                        $comreq = trim($comreq);
                                                                        if ($comreq == "no") {
                                                                            $retorno = "Error Tarea Iniciar Servidor, no se encontro Java.";
                                                                            $elerror = 1;
                                                                        }
                                                                    } elseif ($recjavaselect == "1") {
                                                                        $javaruta = $recjavaname;
                                                                        clearstatcache();
                                                                        if (!file_exists($javaruta)) {
                                                                            $retorno = "Error Tarea Iniciar Servidor, no se encontró Java en la ruta especificada.";
                                                                            $elerror = 1;
                                                                        }
                                                                    } elseif ($recjavaselect == "2") {
                                                                        $javaruta = $recjavamanual . "/bin/java";
                                                                        clearstatcache();
                                                                        if (!file_exists($javaruta)) {
                                                                            $retorno = "Error Tarea Iniciar Servidor, no se encontró Java en la ruta especificada.";
                                                                            $elerror = 1;
                                                                        }
                                                                    } else {
                                                                        $retorno = "Error Tarea Iniciar Servidor, no se ha seleccionado ningún tipo de Java.";
                                                                        $elerror = 1;
                                                                    }
                                                                }

                                                                //CREAR CARPETA LOGS EN CASO QUE NO EXISTA
                                                                if ($elerror == 0) {
                                                                    $rutacarplogs = $rutaminecraffijo . "/logs";
                                                                    clearstatcache();
                                                                    if (!file_exists($rutacarplogs)) {
                                                                        mkdir($rutacarplogs, 0700);
                                                                        $elcommando = "chmod 775 " . $rutacarplogs;
                                                                        exec($elcommando);
                                                                    }
                                                                }

                                                                //COMPROBAR SI EXISTE SCREEN.CONF
                                                                if ($elerror == 0) {
                                                                    $rutascreenconf = $RUTAPRINCIPAL;
                                                                    $rutascreenconf = trim($rutascreenconf);
                                                                    $rutascreenconf .= "/config/screen.conf";

                                                                    clearstatcache();
                                                                    if (!file_exists($rutascreenconf)) {
                                                                        $retorno = "Error Tarea Iniciar Servidor, el archivo de configuración de Screen no existe.";
                                                                        $elerror = 1;
                                                                    }
                                                                }

                                                                //INICIAR SERVIDOR
                                                                if ($elerror == 0) {

                                                                    $comandoserver = "";
                                                                    $cominiciostart = "";
                                                                    $larutash = "";
                                                                    $inigc = "";

                                                                    $rutacarpetamine = $RUTAPRINCIPAL;
                                                                    $rutacarpetamine = trim($rutacarpetamine);
                                                                    $larutash = $rutacarpetamine . "/" . $reccarpmine;
                                                                    $larutascrrenlog = $rutacarpetamine . "/" . $reccarpmine . "/logs/screen.log";
                                                                    $rutacarpetamine .= "/" . $reccarpmine . "/" . $recarchivojar;

                                                                    //BORRAR LOG SCREEN
                                                                    clearstatcache();
                                                                    if (file_exists($larutascrrenlog)) {
                                                                        unlink($larutascrrenlog);
                                                                    }

                                                                    if ($recgarbagecolector == "1") {
                                                                        $inigc = "-XX:+UseConcMarkSweepGC";
                                                                    } elseif ($recgarbagecolector == "2") {
                                                                        $inigc = "-XX:+UseG1GC";
                                                                    }

                                                                    if ($rectiposerv == "vanilla") {
                                                                        $comandoserver .= "cd " . $RUTAPRINCIPAL . " && cd " . $reccarpmine . " && umask 002 && screen -c '" . $rutascreenconf . "' -dmS " . $reccarpmine . " -L -Logfile 'logs/screen.log' " . $javaruta . " -Xms1G -Xmx" . $recram . "G " . $inigc . " -Dfile.encoding=UTF8" . " -jar '" . $rutacarpetamine . "' nogui";
                                                                    } elseif ($rectiposerv == "spigot") {
                                                                        $comandoserver .= "cd " . $RUTAPRINCIPAL . " && cd " . $reccarpmine . " && umask 002 && screen -c '" . $rutascreenconf . "' -dmS " . $reccarpmine . " -L -Logfile 'logs/screen.log' " . $javaruta . " -Xms1G -Xmx" . $recram . "G " . $inigc . " -Djline.terminal=jline.UnsupportedTerminal -Dfile.encoding=UTF8 -jar '" . $rutacarpetamine . "' nogui -nojline --log-strip-color";
                                                                        $cominiciostart = "screen -c '" . $rutascreenconf . "' -dmS " . $reccarpmine . " -L -Logfile 'logs/screen.log' " . $javaruta . " -Xms1G -Xmx" . $recram . "G " . $inigc . " -Djline.terminal=jline.UnsupportedTerminal -Dfile.encoding=UTF8 -jar '" . $rutacarpetamine . "' nogui -nojline --log-strip-color";
                                                                        guardareinicio($larutash, $cominiciostart, $larutascrrenlog);
                                                                    } elseif ($rectiposerv == "paper") {
                                                                        $comandoserver .= "cd " . $RUTAPRINCIPAL . " && cd " . $reccarpmine . " && umask 002 && screen -c '" . $rutascreenconf . "' -dmS " . $reccarpmine . " -L -Logfile 'logs/screen.log' " . $javaruta . " -Xms1G -Xmx" . $recram . "G " . $inigc . " -Dfile.encoding=UTF8" . " -jar '" . $rutacarpetamine . "' nogui";
                                                                        $cominiciostart = "screen -c '" . $rutascreenconf . "' -dmS " . $reccarpmine . " -L -Logfile 'logs/screen.log' " . $javaruta . " -Xms1G -Xmx" . $recram . "G " . $inigc . " -Dfile.encoding=UTF8" . " -jar '" . $rutacarpetamine . "' nogui";
                                                                        guardareinicio($larutash, $cominiciostart, $larutascrrenlog);
                                                                    } elseif ($rectiposerv == "forge") {
                                                                        $comandoserver .= "cd " . $RUTAPRINCIPAL . " && cd " . $reccarpmine . " && umask 002 && screen -c '" . $rutascreenconf . "' -dmS " . $reccarpmine . " -L -Logfile 'logs/screen.log' " . $javaruta . " -Xms1G -Xmx" . $recram . "G " . $inigc . " -Dfile.encoding=UTF8" . " -jar '" . $rutacarpetamine . "' nogui";
                                                                    } elseif ($rectiposerv == "magma") {
                                                                        $comandoserver .= "cd " . $RUTAPRINCIPAL . " && cd " . $reccarpmine . " && umask 002 && screen -c '" . $rutascreenconf . "' -dmS " . $reccarpmine . " -L -Logfile 'logs/screen.log' " . $javaruta . " -Xms1G -Xmx" . $recram . "G " . $inigc . " -Dfile.encoding=UTF8" . " -jar '" . $rutacarpetamine . "' nogui";
                                                                    } elseif ($rectiposerv == "otros") {
                                                                        $comandoserver .= "cd " . $RUTAPRINCIPAL . " && cd " . $reccarpmine . " && umask 002 && screen -c '" . $rutascreenconf . "' -dmS " . $reccarpmine . " -L -Logfile 'logs/screen.log' " . $javaruta . " -Xms1G -Xmx" . $recram . "G " . $inigc . " -Dfile.encoding=UTF8" . " -jar '" . $rutacarpetamine . "' nogui";
                                                                    }
                                                                    $elpid = shell_exec($comandoserver);
                                                                    $retorno = "Tarea Iniciar Servidor, ejecutado correctamente.";
                                                                }
                                                            } else {
                                                                $retorno = "Tarea Iniciar Servidor, no se puede realizar al estar ya en ejecución.";
                                                            }

                                                            break;
                                                        case "acc3":
                                                            //BACKUP SERVIDOR

                                                            function converdatoscarpbackup($losbytes, $opcion, $decimal)
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

                                                            $reccarpmine = CONFIGDIRECTORIO;
                                                            $elerror = 0;

                                                            $archivo = "AUTO";

                                                            $dirconfig = "";
                                                            $dirconfig = $RUTAPRINCIPAL;
                                                            $dirconfig = trim($dirconfig);
                                                            $dirconfig .= "/backups";

                                                            //LIMITE ALMACENAMIENTO
                                                            if ($elerror == 0) {
                                                                //OBTENER GIGAS CARPETA BACKUPS
                                                                $getgigasbackup = shell_exec("du -s " . $dirconfig . " | awk '{ print $1 }' ");
                                                                $getgigasbackup = trim($getgigasbackup);
                                                                $getgigasbackup = converdatoscarpbackup($getgigasbackup, 0, 2);

                                                                //OBTENER GIGAS LIMITE BACKUPS
                                                                $limitbackupgb = CONFIGFOLDERBACKUPSIZE;

                                                                //MIRAR SI ES ILIMITADO
                                                                if ($limitbackupgb >= 1) {
                                                                    if ($getgigasbackup > $limitbackupgb) {
                                                                        $retorno = "Error Tarea Backup, se ha superado el límite GB para backups.";
                                                                        $elerror = 1;
                                                                    }
                                                                }
                                                            }

                                                            if ($elerror == 0) {
                                                                if (file_exists($dirconfig)) {
                                                                    //COMPROVAR SI SE PUEDE ESCRIVIR
                                                                    if (is_writable($dirconfig)) {
                                                                        $rutaarchivo = $RUTAPRINCIPAL;
                                                                        $rutaarchivo = trim($rutaarchivo);
                                                                        $rutaminelimpia = $rutaarchivo . "/" . $reccarpmine;
                                                                        if (is_readable($rutaminelimpia)) {
                                                                            $rutaarchivo .= "/" . $reccarpmine . "/ .";
                                                                            $dirconfig = $dirconfig . "/" . $archivo . "-";
                                                                            $t = date("Y-m-d-G:i:s");
                                                                            $elcomando = "tar -czvf " . $dirconfig . $t . ".tar.gz -C " . $rutaarchivo;
                                                                            if (is_executable($rutaminelimpia)) {
                                                                                exec($elcomando, $out, $oky);

                                                                                if (!$oky) {
                                                                                    $retorno = "Tarea Crear Backup, ejecutado correctamente.";
                                                                                } else {
                                                                                    $retorno = "Error Tarea Crear Backup, no se creo correctamente.";
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
                                                            }

                                                            break;
                                                        case "acc4":
                                                            //ENVIAR COMANDO

                                                            $paraejecutar = addslashes($arrayobtenido[$i]['comando']);

                                                            //OBTENER PID SABER SI ESTA EN EJECUCION
                                                            $elcomando = "";
                                                            $elnombrescreen = CONFIGDIRECTORIO;
                                                            $elcomando = "screen -ls | awk '/\." . $elnombrescreen . "\t/ {print strtonum($1)'}";
                                                            $elpid = shell_exec($elcomando);

                                                            //SI ESTA EN EJECUCION ENVIAR COMANDO
                                                            if (!$elpid == "") {
                                                                $laejecucion = 'screen -S ' . $elnombrescreen . ' -X stuff "' . trim($paraejecutar) . '^M"';
                                                                shell_exec($laejecucion);
                                                                $retorno = "Tarea Enviar Comando, ejecutado correctamente.";
                                                            } else {
                                                                $retorno = "Tarea Enviar Comando, no se puede realizar al estar apagado el servidor.";
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
if ($retorno != "") {
    echo $logfechayhora . ": " . $retorno . PHP_EOL;
} else {
    echo $retorno;
}
