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
if (PHP_VERSION_ID < 70300) {
  //VERSION ANTIGUA A 7.3
  if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
    //SI ES HTTPS
    session_set_cookie_params(3600, '/', $_SERVER['HTTP_HOST'], true, true);
  } else {
    //SI ES HTTP
    session_set_cookie_params(3600, '/', $_SERVER['HTTP_HOST'], false, false);
  }
} else {
  //version mas moderna soporte samesite
  if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
    //SI ES HTTPS
    session_set_cookie_params(3600, '/', $_SERVER['HTTP_HOST'], true, true);
    ini_set('session.cookie_samesite', "Strict");
  } else {
    //SI ES HTTP
    session_set_cookie_params(3600, '/', $_SERVER['HTTP_HOST'], false, true);
    ini_set('session.cookie_samesite', "Strict");
  }
}
session_start();
?>