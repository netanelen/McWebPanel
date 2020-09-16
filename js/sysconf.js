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

    $("#guardaserver").click(function() {
        var eldata = $("#formconf :input").serializeArray();

        $.post($("#formconf").attr("action"), eldata, function(data) {
            var getdebug = 0;
            if (getdebug == 1) {
                alert(data);
            }

            if (data == "nowriteconf") {
                document.getElementById("result").innerHTML = "<div class='alert alert-danger' role='alert'>Error: El archivo de configuración no tiene permisos de escritura.</div>";
            } else if (data == "nocarpetaconf") {
                document.getElementById("result").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta conf no existe.</div>";
            } else if (data == "nowritehtaccess") {
                document.getElementById("result").innerHTML = "<div class='alert alert-danger' role='alert'>Error: El archivo .htaccess en la raiz, no tiene permisos de escritura.</div>";
            } else if (data == "saveconf") {
                document.getElementById("result").innerHTML = "<div class='alert alert-success' role='alert'>Configuración Guardada.</div>";
            }
        })

    });

    $("#formconf").submit(function() {
        return false;

    });

    document.getElementById("guardaserver").disabled = true;

    $("#elnomserv").change(function() {
        document.getElementById("guardaserver").disabled = false;
        document.getElementById("result").innerHTML = "";

        if (this.value == "") {
            document.getElementById("guardaserver").disabled = true;
        }

    });

    $("#eltipserv").change(function() {
        document.getElementById("guardaserver").disabled = false;
        document.getElementById("result").innerHTML = "";
    });

    $("#elmaxupload").change(function() {
        document.getElementById("guardaserver").disabled = false;
        document.getElementById("result").innerHTML = "";
    });

    $("#elram").change(function() {
        document.getElementById("guardaserver").disabled = false;
        document.getElementById("result").innerHTML = "";
    });

    $("#listadojars").change(function() {
        document.getElementById("guardaserver").disabled = false;
        document.getElementById("result").innerHTML = "";
    });

    $("#elport").change(function() {
        var elnumero = document.getElementById("elport").value;
        document.getElementById("result").innerHTML = "";

        if (elnumero < 1025 || elnumero > 65535) {
            document.getElementById("elport").value = "";
        } else {
            document.getElementById("guardaserver").disabled = false;
        }

    });

    $("#elport").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

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