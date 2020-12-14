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

function devolverdatos($loskilobytes, $opcion)
{
	$eltipo = "";

	if ($loskilobytes >= 0) {
		$eltipo = "KB";
		$result = $loskilobytes;
	}

	if ($loskilobytes >= 1024) {
		$eltipo = "MB";
		$result = $loskilobytes / 1024;
	}

	if ($loskilobytes >= 1048576) {
		$eltipo = "GB";
		$result = $loskilobytes / 1048576;
	}

	if ($loskilobytes >= 1073741824) {
		$eltipo = "TB";
		$result = $loskilobytes / 1073741824;
	}

	if ($opcion == 0) {
		$result = str_replace(".", ",", strval(round($result, 2)));
		return $result;
	} elseif ($opcion == 1) {
		$result = str_replace(".", ",", strval(round($result, 2))) . " " . $eltipo;
		return $result;
	}
}

//COMPROVAR SI SESSION EXISTE SINO CREARLA CON NO
if (!isset($_SESSION['VALIDADO']) || !isset($_SESSION['KEYSECRETA'])) {
	$_SESSION['VALIDADO'] = "NO";
	$_SESSION['KEYSECRETA'] = "0";
}

//VALIDAMOS SESSION
if ($_SESSION['VALIDADO'] == $_SESSION['KEYSECRETA']) {

	if (isset($_POST['action']) && !empty($_POST['action'])) {

		//DECLARAR VARIABLES
		$lacpu = "";
		$laram = "";
		$valor3 = "";
		$laramconfig = "";
		$tipserver = "";
		$lahora = date("H:i:s");

		//OBTENER PID SABER SI ESTA EN EJECUCION
		$elcomando = "";
		$elnombrescreen = CONFIGDIRECTORIO;
		$elcomando = "screen -ls | awk '/\." . $elnombrescreen . "\t/ {print strtonum($1)'}";
		$elpid = shell_exec($elcomando);

		if ($elpid == "") {
			$valor3 = "Apagado";
		} else {
			$valor3 = "Encendido";

			//OBTENER CPU
			$lacpu = shell_exec('uptime');
			$lacpu = substr($lacpu, -6);
			$lacpu = strval($lacpu);
			$lacpu = trim($lacpu);

			//OBTENER MEMORIA USADA
			$tipserver = trim(exec('whoami'));

			if ($tipserver == "www-data") {
				$elcomando = "ps aux --sort -rss | grep www-data | grep Ssl+ | grep '" . $elnombrescreen . "' | awk '{print $6}'";
				$elpid = shell_exec($elcomando);
				$laram = $elpid;
				$laram = trim(substr($elpid, 0, (strlen($elpid) - 4)));
			} elseif ($tipserver == "apache") {
				$elcomando = "ps aux --sort -rss | grep apache | grep Ssl+ | grep '" . $elnombrescreen . "' | awk '{print $6}'";
				$elpid = shell_exec($elcomando);
				$laram = $elpid;
				$laram = trim(substr($elpid, 0, (strlen($elpid) - 5)));
			}

			if (is_numeric($laram)) {
				$laram = devolverdatos($laram, 1);
			} else {
				$laram = "";
			}

			//OBTENER MEMORIA TOTAL CONFIGURADA
			$laramconfig = CONFIGRAM;
		}

		$elarray = array("cpu" => $lacpu, "memoria" => $laram, "ramconfig" => $laramconfig, "encendido" => $valor3, "hora" => $lahora);
		echo json_encode($elarray);
	}
}
