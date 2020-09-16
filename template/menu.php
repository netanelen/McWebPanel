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
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="status.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class=""><img class="" src="img/icons/favicon-32x32.png" alt="mineminiicon" width="40" height="40"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            <?php
            $NAMESERVERMENU = CONFIGNOMBRESERVER;
            echo $NAMESERVERMENU;
            ?>
        </div>
    </a>

    <!-- Linea -->
    <hr class="sidebar-divider my-0">

    <!-- Linea -->
    <hr class="sidebar-divider">

    <!-- Encabezado -->
    <div class="sidebar-heading">Servidor</div>

    <!-- Nav Item - Status -->
    <li class="nav-item menu-hover">
        <a class="nav-link" href="status.php">
            <img class="d-block float-left mr-2" src="img/menu/status.png" alt="status">
            <h6 class="text-light">Status</h6>
        </a>
    </li>

    <!-- Nav Item - Consola -->
    <li class="nav-item menu-hover">
        <a class="nav-link" href="consola.php">
            <img class="d-block float-left mr-2" src="img/menu/consola.png" alt="consola">
            <h6 class="text-light">Consola</h6>
        </a>
    </li>

    <!-- Linea -->
    <hr class="sidebar-divider">

    <!-- Encabezado -->
    <div class="sidebar-heading">Configuración</div>

    <!-- Nav Item - Minecraft -->
    <li class="nav-item menu-hover">
        <a class="nav-link" href="minecraft.php">
            <img class="d-block float-left mr-2" src="img/menu/config.png" alt="confmine">
            <h6 class="text-light">Config Minecraft</h6>
        </a>
    </li>

    <!-- Nav Item - Tareas -->
    <li class="nav-item menu-hover">
        <a class="nav-link" href="tareas.php">
            <img class="d-block float-left mr-2" src="img/menu/tarea.png" alt="tarea">
            <h6 class="text-light">Prog Tareas</h6>
        </a>
    </li>

    <!-- Linea -->
    <hr class="sidebar-divider">

    <!-- Encabezado -->
    <div class="sidebar-heading">Sistema</div>

    <!-- Nav Item - System Config -->
    <li class="nav-item menu-hover">
        <a class="nav-link" href="sysconf.php">
            <img class="d-block float-left mr-2" src="img/menu/sysconf.png" alt="sysconf">
            <h6 class="text-light">System Config</h6>
        </a>
    </li>

    <!-- Nav Item - Subir Server -->
    <li class="nav-item menu-hover">
        <a class="nav-link" href="subirserver.php">
            <img class="d-block float-left mr-2" src="img/menu/subida.png" alt="subida">
            <h6 class="text-light">Subir Servidor</h6>
        </a>
    </li>

    <!-- Nav Item - Backups -->
    <li class="nav-item menu-hover">
        <a class="nav-link" href="backups.php">
            <img class="d-block float-left mr-2" src="img/menu/backup.png" alt="backup">
            <h6 class="text-light">Backups</h6>
        </a>
    </li>

    <!-- Nav Item - Gestor Archivos -->
    <li class="nav-item menu-hover">
        <a class="nav-link" href="gestorarchivos.php">
            <img class="d-block float-left mr-2" src="img/menu/carpeta.png" alt="gestarch">
            <h6 class="text-light">Gestor Archivos</h6>
        </a>
    </li>

    <!-- Linea -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Cerrar Session -->
    <li class="nav-item menu-hover">
        <a class="nav-link" href="salir.php">
            <img class="d-block float-left mr-2" src="img/menu/salir.png" alt="salir">
            <h6 class="text-light">Salir</h6>
        </a>
    </li>

    <!-- Linea Final -->
    <hr class="sidebar-divider d-none d-md-block">

</ul>