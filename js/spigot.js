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

$(function() {

    if (document.getElementById('compilar') !== null) {
        document.getElementById("compilar").disabled = true;
    }

    if (document.getElementById('gifloading') !== null) {
        document.getElementById("gifloading").style.visibility = "hidden";
    }

    if (document.getElementById('compilar') !== null) {
        $("#compilar").click(function() {
            verspigot = document.getElementById('serselectver').value
            $.ajax({
                url: 'function/compilarspigot.php',
                data: {
                    action: 'compilar',
                    laversion: verspigot
                },
                type: 'POST',
                success: function(data) {
                    if (data == "noreadraiz") {
                        alert("Error: No tienes permisos de lectura en la carpeta raíz, revisa los permisos de linux");
                    } else if (data == "nowriteraiz") {
                        alert("Error: No tienes permisos de escritura en la carpeta raíz, revisa los permisos de linux");
                    } else if (data == "yaenmarcha") {
                        alert("Ya existe un proceso compilar en ejecución");
                    } else if (data == "nowritecompilar") {
                        alert("No se puede borrar la carpeta compilar, no hay permisos de escritura");
                    } else if (data == "nobuildtools") {
                        alert("Error: No se ha podido descargar la herramienta Buildtools");
                    }
                }
            });
        });
    }

    function myTimer() {

        $.ajax({
            url: 'function/compilarspigot.php',
            data: {
                action: 'consola'
            },
            type: 'POST',
            success: function(data) {
                var textoantiguo = document.getElementById("laconsola").value;

                document.getElementById("laconsola").value = data;

                if (data !== textoantiguo) {
                    document.getElementById("laconsola").scrollTop = document.getElementById("laconsola").scrollHeight;
                }

            }
        });

        $.ajax({
            url: 'function/compilarspigot.php',
            data: {
                action: 'estado'
            },
            type: 'POST',
            success: function(data) {
                if (data == "ON") {

                    if (document.getElementById('compilar') !== null) {
                        document.getElementById("compilar").disabled = true;
                    }

                    if (document.getElementById('gifloading') !== null) {
                        document.getElementById("gifloading").style.visibility = "visible";
                    }
                } else if (data == "OFF") {

                    if (document.getElementById('compilar') !== null) {
                        document.getElementById("compilar").disabled = false;
                    }

                    if (document.getElementById('gifloading') !== null) {
                        document.getElementById("gifloading").style.visibility = "hidden";
                    }
                }
            }
        });


    }

    setInterval(myTimer, 1000);

    function sessionTimer() {

        $.ajax({
            url: 'function/salirsession.php',
            data: {
                action: 'status'
            },
            type: 'POST',
            success: function(data) {
                if (data == "SALIR") {
                    location.href = "index.php";
                }


            }
        });
    }

    setInterval(sessionTimer, 1000);

});