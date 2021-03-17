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

$(function () {

    if (document.getElementsByClassName('actdes') !== null) {
        var actdesbuttons = document.getElementsByClassName('actdes');
        for (var i = 0; i < actdesbuttons.length; i++) {
            actdesbuttons[i].addEventListener("click", function () {
                var indexarray = String(this.value);
                if (indexarray == 0) {
                    indexarray = 'CERO';
                }
                $.ajax({
                    url: 'function/tareaactdes.php',
                    data: {
                        action: indexarray
                    },
                    type: 'POST',
                    success: function (data) {
                        var getdebug = 0;
                        if (getdebug == 1) {
                            alert(data);
                        }
                        if (data == "errarchnoconfig") {
                            document.getElementById("textotarearetorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta config no existe.</div>";
                        } else if (data == "errconfignoread") {
                            document.getElementById("textotarearetorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta config no tiene permisos de lectura .</div>";
                        } else if (data == "errconfignowrite") {
                            document.getElementById("textotarearetorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta config no tiene permisos de escritura.</div>";
                        } else if (data == "errjsonnoread") {
                            document.getElementById("textotarearetorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: El archivo json no tiene permisos de lectura.</div>";
                        } else if (data == "errjsonnowrite") {
                            document.getElementById("textotarearetorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: Hay que introducir un comando.</div>";
                        } else if (data == 'OK') {
                            location.reload();
                        }

                    }
                });
            });
        }
    }

    if (document.getElementsByClassName('borrar') !== null) {
        var borrarbuttons = document.getElementsByClassName('borrar');
        for (var i = 0; i < borrarbuttons.length; i++) {
            borrarbuttons[i].addEventListener("click", function () {
                var indexarray = String(this.value);
                if (indexarray == 0) {
                    indexarray = 'CERO';
                }
                $.ajax({
                    url: 'function/tareaborrar.php',
                    data: {
                        action: indexarray
                    },
                    type: 'POST',
                    success: function (data) {
                        var getdebug = 0;
                        if (getdebug == 1) {
                            alert(data);
                        }
                        if (data == "errarchnoconfig") {
                            document.getElementById("textotarearetorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta config no existe.</div>";
                        } else if (data == "errconfignoread") {
                            document.getElementById("textotarearetorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta config no tiene permisos de lectura .</div>";
                        } else if (data == "errconfignowrite") {
                            document.getElementById("textotarearetorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta config no tiene permisos de escritura.</div>";
                        } else if (data == "errjsonnoread") {
                            document.getElementById("textotarearetorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: El archivo json no tiene permisos de lectura.</div>";
                        } else if (data == "errjsonnowrite") {
                            document.getElementById("textotarearetorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: Hay que introducir un comando.</div>";
                        } else if (data == 'OK') {
                            location.reload();
                        }

                    }
                });
            });
        }
    }

    if (document.getElementById('anadirtarea') !== null) {
        $("#anadirtarea").click(function () {
            location.href = "nuevatarea.php";
        });
    }

    if (document.getElementById('borrarlog') !== null) {
        $("#borrarlog").click(function () {
            $.ajax({
                url: 'function/tarealog.php',
                data: {
                    action: 'borralog'
                },
                type: 'POST',
                success: function (data) {
                    if (data == "ok") {
                        alert("Log borrado correctamente");
                    } else if (data == "nowritelog") {
                        alert("El archivo cronlog.log no tiene permisos de escritura");
                    }
                }
            });
        });
    }

    function eltimerlog() {

        if (document.getElementById('logcron') !== null) {
            $.ajax({
                url: 'function/tarealog.php',
                data: {
                    action: 'getlog'
                },
                type: 'POST',
                success: function (data) {
                    document.getElementById("logcron").value = data;
                }
            });
        }
    }

    setInterval(eltimerlog, 1000);

    function sessionTimer() {

        $.ajax({
            url: 'function/salirsession.php',
            data: {
                action: 'status'
            },
            type: 'POST',
            success: function (data) {
                if (data == "SALIR") {
                    location.href = "index.php";
                }


            }
        });
    }

    setInterval(sessionTimer, 1000);

});