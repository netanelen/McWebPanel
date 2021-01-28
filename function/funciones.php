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

function getdistroinfo()
{
	$vars = array();
	$files = glob('/etc/*-release');

	foreach ($files as $file) {
		$lines = array_filter(array_map(function ($line) {

			$parts = explode('=', $line);

			if (count($parts) !== 2) return false;

			$parts[1] = str_replace(array('"', "'"), '', $parts[1]);
			return $parts;
		}, file($file)));

		foreach ($lines as $line)
			$vars[$line[0]] = $line[1];
	}
	return $vars;
}

function secondsToTime($inputSeconds)
{

	$secondsInAMinute = 60;
	$secondsInAnHour  = 60 * $secondsInAMinute;
	$secondsInADay    = 24 * $secondsInAnHour;

	//EXTRAER DIAS
	$days = floor($inputSeconds / $secondsInADay);

	//EXTRAER HORAS
	$hourSeconds = $inputSeconds % $secondsInADay;
	$hours = floor($hourSeconds / $secondsInAnHour);

	//EXTRAER MINUTOS
	$minuteSeconds = $hourSeconds % $secondsInAnHour;
	$minutes = floor($minuteSeconds / $secondsInAMinute);

	//EXTRAER SEGUNDOS
	$remainingSeconds = $minuteSeconds % $secondsInAMinute;
	$seconds = ceil($remainingSeconds);

	// return the final array
	$obj = array(
		'd' => (int) $days,
		'h' => (int) $hours,
		'm' => (int) $minutes,
		's' => (int) $seconds,
	);
	return $obj;
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
		$elpid = "";
		$lacpu = "";
		$laram = "";
		$valor3 = "";
		$laramconfig = "";
		$tipserver = "";
		$lahora = date("H:i:s");
		$eluptime = "";

		//OBTENER PID SABER SI ESTA EN EJECUCION
		$elcomando = "";
		$elnombrescreen = CONFIGDIRECTORIO;
		$elcomando = "screen -ls | awk '/\." . $elnombrescreen . "\t/ {print strtonum($1)'}";
		$elpid = shell_exec($elcomando);

		if ($elpid == "") {
			$valor3 = "Apagado";
		} else {
			$valor3 = "Encendido";

			//OBTENER DISTRO
			$iddistro = getdistroinfo();
			$iddistro = trim($iddistro["ID"]);
			$iddistro = strtolower($iddistro);

			//OBTENER CPU
			$lacpu = shell_exec('uptime');
			$lacpu = substr($lacpu, -6);
			$lacpu = strval($lacpu);
			$lacpu = trim($lacpu);

			//OBTENER QUIEN EJECUTA
			$tipserver = trim(exec('whoami'));

			//OBTENER PID
			$elpid = "ps au | grep '" . $tipserver . "' | grep '" . $elnombrescreen . "' | awk '{print $2}'";
			$elpid = shell_exec($elpid);
			$elpid = trim($elpid);

			//OBTENER RAM
			$laram = "ps au | grep '" . $tipserver . "' | grep '" . $elnombrescreen . "' | awk '{print $6}'";
			$laram = shell_exec($laram);
			$laram = trim($laram);

			//CONVERTIR RAM EN GB
			if (is_numeric($laram)) {
				$laram = devolverdatos($laram, 1);
			} else {
				$laram = "";
			}

			//OBTENER UPTIME
			$uptime = "ps -p " . $elpid . " -o etimes=";
			$uptime = shell_exec($uptime);
			$uptime = trim($uptime);
			$uptimearray = secondsToTime($uptime);
			$eluptime = $uptimearray['d'] . " Dias  " . $uptimearray['h'] . " Horas  " . $uptimearray['m'] . " Minutos  " . $uptimearray['s'] . " Segundos";

			//OBTENER MEMORIA TOTAL CONFIGURADA
			$laramconfig = CONFIGRAM;
		}

		$elarray = array("cpu" => $lacpu, "memoria" => $laram, "ramconfig" => $laramconfig, "encendido" => $valor3, "hora" => $lahora, "uptime" => $eluptime);
		echo json_encode($elarray);
	}
}
