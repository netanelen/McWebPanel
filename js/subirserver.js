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

$(document).ready(function() {

    document.getElementById("botonsubir").disabled = true;
    document.getElementById("gifloading").style.visibility = "hidden";

    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        var res = fileName.substring(fileName.length - 4, fileName.length);
        if (res == ".jar") {
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            document.getElementById("botonsubir").disabled = false;
        } else {
            alert("Solo se permiten subir archivos .jar");
            document.getElementById("botonsubir").disabled = true;
            document.getElementById("fileName").value = "";
        }
    });

    $("#form").on('submit', (function(e) {
        document.getElementById("gifloading").style.visibility = "visible";
        e.preventDefault();
        $.ajax({
            url: "function/procesarjar.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }

                document.getElementById("gifloading").style.visibility = "hidden";

                if (data == "nojar") {
                    alert("No es un archivo .jar");
                } else if (data == "notipovalido") {
                    alert("El archivo no es del tipo valido");
                } else if (data == "nowriteraiz") {
                    alert("El archivo raiz no tiene permisos de escritura");
                } else if (data == "nocarpserver") {
                    alert("La carpeta servidor minecraft no existe");
                } else if (data == "nowriteservmine") {
                    alert("La carpeta servidor minecraft no tiene permisos de escritura");
                } else if (data == "jarexiste") {
                    alert("Ya existe un archivo .jar con ese nombre");
                } else if (data == "errorsubir") {
                    alert("Error al subir el archivo");
                } else if (data == "errprocess") {
                    alert("Error al procesar el archivo");
                } else if (data == "OK") {
                    alert("Subido con éxito");
                    location.reload();
                }

            },
            error: function(e) {
                alert("error");
            }
        });
    }));

    var mySessionTimer = setInterval(sessionTimer, 1000);

    function sessionTimer() {

        var tqxhr = $.ajax({
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

});