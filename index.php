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

require_once("template/session.php");
require_once("template/errorreport.php");
require_once("template/header.php");

if (!isset($_SESSION['VALIDADO']) || !isset($_SESSION['KEYSECRETA'])) {
  $_SESSION['VALIDADO'] = "NO";
  $_SESSION['KEYSECRETA'] = "0";
}

if ($_SESSION['VALIDADO'] == $_SESSION['KEYSECRETA']) {
  header("location:status.php");
}
?>

<!-- Estilo CSS -->
<link href="css/signin.css" rel="stylesheet">
<link href="css/login.css" rel="stylesheet">

</head>

<body class="text-center">

  <form class="form-signin" action="function/login.php" method="POST" id="login-form">

    <?php
    //CARGA VARIABLES
    $sumaconfig = 0;
    $sumainstall = 0;
    $rutaarchivo = "";
    $rutainstall = "";

    //COMPROVAR SI EXISTE LA CONFIG
    $rutaarchivo = getcwd();
    $rutaarchivo = trim($rutaarchivo);
    $rutaarchivo .= "/config/confuser.json";

    if (file_exists($rutaarchivo)) {
      $sumaconfig++;
    }

    $rutaarchivo = getcwd();
    $rutaarchivo = trim($rutaarchivo);
    $rutaarchivo .= "/config/confopciones.php";

    if (file_exists($rutaarchivo)) {
      $sumaconfig++;
    }

    //COMPROVAR SI EXISTE INSTALL Y REDIRECCIONAR
    $rutainstall = getcwd();
    $rutainstall = trim($rutainstall);
    $rutainstall .= "/install";

    if (file_exists($rutainstall)) {
      $sumainstall++;
    }

    //COMPROVAR RESULTADOS
    if ($sumaconfig == 2 && $sumainstall == 1) {
      echo '<div class="alert alert-danger" role="alert">Error: Borra la carpeta install.</div>';
      exit;
    } elseif ($sumaconfig == 0 && $sumainstall == 0) {
      echo '<div class="alert alert-danger" role="alert">Error: La configuración no existe, vuelve a instalar la carpeta install y realiza una instalación correcta.</div>';
      exit;
    } elseif ($sumaconfig == 1 && $sumainstall == 0) {
      echo '<div class="alert alert-danger" role="alert">Error: Faltan archivos de configuración, vuelve a instalar la carpeta install y realiza una instalación correcta.</div>';
      exit;
    } elseif ($sumaconfig == 1 && $sumainstall == 1) {
      echo '<div class="alert alert-danger" role="alert">Error: Faltan archivos de configuración, vuelve a realizar la instalación.<br><br><a href="/install/index.php">Pulsa para instalar</a></div>';
      exit;
    } elseif ($sumaconfig == 0 && $sumainstall == 1) {
      $laruta = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      header("location:" . $laruta . '/install/index.php');
      exit;
    } elseif ($sumaconfig == 2 && $sumainstall == 0) {
      //instalacion correcta
      require_once("config/confopciones.php");
    }
    $recnombreserv = CONFIGNOMBRESERVER;
    ?>

    <img class="mb-4" src="img/icons/apple-icon-72x72.png" alt="LOGO" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal"><?php echo $recnombreserv; ?></h1>

    <p class="lead" id="textologincount"></p>
    <p class="lead" id="textologinerror"></p>

    <label for="inputUser" class="sr-only">Nombre de usuario</label>
    <input type="text" id="inputUser" name="eluser" class="form-control" placeholder="Nombre de usuario" required autofocus>

    <label for="inputPassword" class="sr-only">Contraseña</label>
    <input type="password" id="inputPassword" name="elpass" class="form-control" placeholder="Contraseña" required>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Recuérdame
      </label>
    </div>

    <button class="btn btn-lg btn-primary btn-block" id="botoninisesion" type="submit" value="Login">Iniciar sesión</button>

  </form>

  <script src="js/login.js"></script>

</body>

</html>