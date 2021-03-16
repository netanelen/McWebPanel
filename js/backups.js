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

    if (document.getElementById('inputbackup') !== null) {
        document.getElementById("inputbackup").disabled = true;
    }

    if (document.getElementById('gifloading') !== null) {
        document.getElementById("gifloading").style.visibility = "hidden";
    }

    if (document.getElementById('inputbackup') !== null) {
        $("#inputbackup").keypress(function (e) {
            if (e.keyCode == 32) {
                return false;
            } else {
                if (e.keyCode >= 48 && e.keyCode <= 57 || e.keyCode >= 65 && e.keyCode <= 90 || e.keyCode >= 97 && e.keyCode <= 122 || e.keyCode == 45 || e.keyCode == 95 || e.keyCode == 13) {
                    return true;
                } else {
                    return false;
                }
            }
        });
    }

    if (document.getElementsByClassName('descargar') !== null) {
        var descargarbuttons = document.getElementsByClassName('descargar');
        for (var i = 0; i < descargarbuttons.length; i++) {
            descargarbuttons[i].addEventListener("click", function () {
                window.open('function/backupdownfile.php?action=' + this.value, '_blank', 'noopener noreferrer', "toolbar=no,scrollbars=yes,resizable=yes,top=400,left=500,width=400,height=100");
            });
        }
    }

    if (document.getElementsByClassName('restaurar') !== null) {
        var restaurarbuttons = document.getElementsByClassName('restaurar');
        for (var i = 0; i < restaurarbuttons.length; i++) {
            restaurarbuttons[i].addEventListener("click", function () {
                var eleccion = confirm("¡ATENCIÓN!\n\nAl Restaurar se borrarán todos los archivos del servidor minecraft.\n\n¿Seguro que quieres continuar?");
                if (eleccion == true) {

                    $.ajax({
                        type: "POST",
                        url: "function/backuprestorefile.php",
                        data: {
                            action: this.value
                        },
                        success: function (data) {

                            if (data == "nowriteraiz") {
                                document.getElementById("textoretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta raíz no tiene permisos de escritura.</div>";
                            } else if (data == "nominexiste") {
                                document.getElementById("textoretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta del servidor minecraft no existe.</div>";
                            } else if (data == "minenowrite") {
                                document.getElementById("textoretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta del servidor minecraft no tiene permisos de escritura.</div>";
                            } else if (data == "tarnoexiste") {
                                document.getElementById("textoretorno").innerHTML = "<div class='alert alert-success' role='alert'>Error: El backup seleccionado no existe.</div>";
                            } else if (data == "tarnolectura") {
                                document.getElementById("textoretorno").innerHTML = "<div class='alert alert-success' role='alert'>Error: El backup seleccionado no se puede leer.</div>";
                            } else if (data == "norestore") {
                                document.getElementById("textoretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: No se ha podido restaurar el servidor.</div>";
                            } else if (data == "notempexiste") {
                                document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta temp no existe.</div>";
                            } else if (data == "notempwritable") {
                                document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta temp no tiene permisos de escritura.</div>";
                            } else if (data == "restoreenejecucion") {
                                document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: Ya hay un restore en ejecución.</div>";
                            } else if (data == "servidorejecucion") {
                                document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: El servidor está encendido.</div>";
                            } else if (data == "backenejecucion") {
                                document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: Ya hay un restore en ejecución.</div>";
                            }
                        }
                    });
                }
            });
        }
    }

    if (document.getElementsByClassName('borrar') !== null) {
        var borrarbuttons = document.getElementsByClassName('borrar');
        for (var i = 0; i < borrarbuttons.length; i++) {
            borrarbuttons[i].addEventListener("click", function () {
                var eleccion = confirm("¡ATENCIÓN!\n\n¿Estás seguro de eliminar el backup: " + this.value + " ?");
                if (eleccion == true) {

                    $.ajax({
                        type: "POST",
                        url: "function/backupborrarfile.php",
                        data: {
                            action: this.value
                        },
                        success: function (data) {

                            if (data == "1") {
                                location.reload();
                            } else if (data == "nowritable") {
                                document.getElementById("textoretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: No hay permisos de escritura.</div>";
                            } else if (data == "noexiste") {
                                document.getElementById("textoretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: El archivo no existe.</div>";
                            } else if (data == "restoreenejecucion") {
                                document.getElementById("textoretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: Hay un restore en ejecución.</div>";
                            }
                        }
                    });
                }
            });
        }
    }

    if (document.getElementById('crearbackup') !== null) {
        $("#crearbackup").click(function () {
            document.getElementById("textobackupretorno").innerHTML = "<div class='lead'></div>";
            var eleccion = confirm("¡CONFIRMAR ACCION!\n\nSi el servidor está ejecutado el backup podría fallar.\n\n¿Seguro que quieres continuar?");
            if (eleccion == true) {
                var eltexto = document.getElementById("inputbackup").value;
                $.ajax({
                    type: "POST",
                    url: "function/backupcreate.php",
                    data: {
                        action: eltexto
                    },
                    success: function (data) {

                        if (data == "nobackup") {
                            document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error al crear el backup.</div>";
                        } else if (data == "nowritable") {
                            document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta backups no tiene permisos de escritura.</div>";
                        } else if (data == "noexiste") {
                            document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta backups no existe.</div>";
                        } else if (data == "nolectura") {
                            document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta del servidor minecraft no se puede leer.</div>";
                        } else if (data == "novalidoname") {
                            document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: Nombre no válido.</div>";
                        } else if (data == "noejecutable") {
                            document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta del servidor minecraft no tiene permisos de ejecución.</div>";
                        } else if (data == "limitgbexceeded") {
                            document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: Has superado el límite de GB para Backups.</div>";
                        } else if (data == "backenejecucion") {
                            document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: Ya hay un backup en ejecución.</div>";
                        } else if (data == "notempexiste") {
                            document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta temp no existe.</div>";
                        } else if (data == "notempwritable") {
                            document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta temp no tiene permisos de escritura.</div>";
                        }
                    }
                });
            }
        });
    }

    if (document.getElementById('cancelarbakup') !== null) {
        $("#cancelarbakup").click(function () {
            $.ajax({
                type: "POST",
                url: "function/backupcancel.php",
                data: {
                    action: 'eltexto'
                },
                success: function (data) {

                    if (data == "ok") {
                        location.reload();
                    } else if(data == "backupnoenjecucion"){
                        document.getElementById("textobackupretorno").innerHTML = "<div class='alert alert-danger' role='alert'>Error: No hay ningún backup en ejecución.</div>";
                    }
                }
            });

        });
    }



    function sessionTimer() {

        $.ajax({
            url: 'function/backupstate.php',
            data: {
                action: 'estadobackup'
            },
            type: 'POST',
            success: function (data) {

                if (data == "ON") {

                    if (document.getElementById('inputbackup') !== null) {
                        document.getElementById("inputbackup").disabled = true;
                    }

                    if (document.getElementById('gifloading') !== null) {
                        document.getElementById("gifloading").style.visibility = "visible";
                    }
                } else if (data == "OFF") {

                    if (document.getElementById('inputbackup') !== null) {
                        document.getElementById("inputbackup").disabled = false;
                    }

                    if (document.getElementById('gifloading') !== null) {
                        document.getElementById("gifloading").style.visibility = "hidden";
                    }
                } else if (data == "REFRESH") {
                    location.reload();
                }
            }
        });

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