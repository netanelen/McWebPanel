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

$elerror = 0;
$yainstall = 0;

$iniverificarpraiz = getcwd();
$iniverificarpraiz = trim($iniverificarpraiz);

$iniverifirutatemplate = getcwd();
$iniverifirutatemplate = trim($iniverifirutatemplate);
$iniverifirutatemplate .= "/template";

$iniverifirutaconfig = getcwd();
$iniverifirutaconfig = trim($iniverifirutaconfig);
$iniverifirutaconfig .= "/config";

$iniverificonfuserjson = getcwd();
$iniverificonfuserjson = trim($iniverificonfuserjson);
$iniverificonfuserjson .= "/config/confuser.json";

$iniverificonfopcionesphp = getcwd();
$iniverificonfopcionesphp = trim($iniverificonfopcionesphp);
$iniverificonfopcionesphp .= "/config/confopciones.php";

$iniverificonfserverpropertiestxt = getcwd();
$iniverificonfserverpropertiestxt = trim($iniverificonfserverpropertiestxt);
$iniverificonfserverpropertiestxt .= "/config/serverproperties.txt";

//VERIFICAR CARPETA RAIZ
clearstatcache();
if (!is_readable($iniverificarpraiz)) {
  echo 'Error: No tienes permisos de lectura en la carpeta raiz, revisa los permisos de linux.<br>';
  $elerror = 1;
}

if (!is_writable($iniverificarpraiz)) {
  echo 'Error: No tienes permisos de escritura en la carpeta raiz, revisa los permisos de linux.<br>';
  $elerror = 1;
}

if (!is_executable($iniverifirutatemplate)) {
  echo 'Error: No tienes permisos de ejecucion en la carpeta raiz, revisa los permisos de linux.<br>';
  $elerror = 1;
}

//VERIFICAR TEMPLATE
clearstatcache();
if (!is_readable($iniverifirutatemplate)) {
  echo 'Error: No tienes permisos de lectura en la carpeta template, revisa los permisos de linux.<br>';
  $elerror = 1;
}

clearstatcache();
if (!is_writable($iniverifirutatemplate)) {
  echo 'Error: No tienes permisos de escritura en la carpeta template, revisa los permisos de linux.<br>';
  $elerror = 1;
}

clearstatcache();
if (!is_executable($iniverifirutatemplate)) {
  echo 'Error: No tienes permisos de ejecucion en la carpeta template, revisa los permisos de linux.<br>';
  $elerror = 1;
}

//VERIFICAR CONFIG
clearstatcache();
if (file_exists($iniverifirutaconfig)) {
  clearstatcache();
  if (!is_readable($iniverifirutaconfig)) {
    echo 'Error: No tienes permisos de lectura en la carpeta config, revisa los permisos de linux.<br>';
    $elerror = 1;
    $yainstall = 1;
  }
} else {
  $yainstall = 1;
}

clearstatcache();
if (file_exists($iniverifirutaconfig)) {
  clearstatcache();
  if (!is_writable($iniverifirutaconfig)) {
    echo 'Error: No tienes permisos de escritura en la carpeta config, revisa los permisos de linux.<br>';
    $elerror = 1;
    $yainstall = 1;
  }
} else {
  $yainstall = 1;
}

clearstatcache();
if (file_exists($iniverifirutaconfig)) {
  clearstatcache();
  if (!is_executable($iniverifirutaconfig)) {
    echo 'Error: No tienes permisos de ejecucion en la carpeta config, revisa los permisos de linux.<br>';
    $elerror = 1;
    $yainstall = 1;
  }
} else {
  $yainstall = 1;
}

//VERIFICAR /config/confuser.json";
clearstatcache();
if (file_exists($iniverificonfuserjson)) {
  clearstatcache();
  if (!is_readable($iniverificonfuserjson)) {
    echo 'Error: No tiene permisos de lectura en el archivo /config/confuser.json, revisa los permisos de linux.<br>';
    $elerror = 1;
    $yainstall = 1;
  }
} else {
  $yainstall = 1;
}

clearstatcache();
if (file_exists($iniverificonfuserjson)) {
  clearstatcache();
  if (!is_writable($iniverificonfuserjson)) {
    echo 'Error: No tiene permisos de escritura en el archivo /config/confuser.json, revisa los permisos de linux.<br>';
    $elerror = 1;
    $yainstall = 1;
  }
} else {
  $yainstall = 1;
}

//VERIFICAR /config/confopciones.php";
clearstatcache();
if (file_exists($iniverificonfopcionesphp)) {
  clearstatcache();
  if (!is_readable($iniverificonfopcionesphp)) {
    echo 'Error: No tienes permisos de lectura en el archivo /config/confopciones.php, revisa los permisos de linux.<br>';
    $elerror = 1;
    $yainstall = 1;
  }
} else {
  $yainstall = 1;
}

clearstatcache();
if (file_exists($iniverificonfopcionesphp)) {
  clearstatcache();
  if (!is_writable($iniverificonfopcionesphp)) {
    echo 'Error: No tienes permisos de escritura en el archivo /config/confopciones.php, revisa los permisos de linux.<br>';
    $elerror = 1;
    $yainstall = 1;
  }
} else {
  $yainstall = 1;
}


if ($yainstall == 0 && $elerror == 0) {

  //VERIFICAR /config/serverproperties.txt";
  clearstatcache();
  if (!file_exists($iniverificonfserverpropertiestxt)) {
    echo 'Error: El archivo serverproperties.txt no existe , vuelve a realizar el install.<br>';
    $elerror = 1;
  } else {

    clearstatcache();
    if (!is_readable($iniverificonfserverpropertiestxt)) {
      echo 'Error: No tienes permisos de lectura en el archivo /config/serverproperties.txt, revisa los permisos de linux.<br>';
      $elerror = 1;
    }

    clearstatcache();
    if (!is_writable($iniverificonfserverpropertiestxt)) {
      echo 'Error: No tienes permisos de escritura en el archivo /config/serverproperties.txt, revisa los permisos de linux.<br>';
      $elerror = 1;
    }
  }
}

if ($elerror == 1) {
  exit;
}

?>
