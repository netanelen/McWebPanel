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

    document.getElementById("binstalar").disabled = false;

    $("#elpass").change(function(e) {
        var getpass = document.getElementById("elpass").value;
        if (getpass == "") {
            document.getElementById("textoretorno").innerHTML = "";
        } else {
            var tqxhr = $.ajax({
                url: 'function/compass.php',
                data: {
                    action: getpass
                },
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.error == 1) {
                        document.getElementById("textoretorno").innerHTML = data.texto;
                        document.getElementById("binstalar").disabled = true;
                    } else {
                        document.getElementById("textoretorno").innerHTML = "";
                        document.getElementById("binstalar").disabled = false;
                    }
                }
            });
        }
    });

    $("#elport").change(function() {
        var elnumero = document.getElementById("elport").value;

        if (elnumero < 1025 || elnumero > 65535) {
            document.getElementById("elport").value = "25565";
        }

    });

    $("#elport").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

    $("#login-install2").submit(function() {
        var elerror = 0;
        var eltexto = "<div class='alert alert-danger' role='alert'>";

        if (document.getElementById("eluser").value == "") {
            eltexto = eltexto + "No has introducido ningún nombre de usuario";
            eltexto = eltexto + "<br>";
            elerror = 1;
        }

        if (document.getElementById("elnomserv").value == "") {
            eltexto = eltexto + "No has introducido ningún nombre al servidor";
            eltexto = eltexto + "<br>";
            elerror = 1;
        }

        if (document.getElementById("elport").value == "") {
            eltexto = eltexto + "No has introducido ningún puerto";
            eltexto = eltexto + "<br>";
            elerror = 1;
        }

        if (document.getElementById("elpass").value != document.getElementById("elrepass").value) {
            eltexto = eltexto + "Las contraseñas no coinciden";
            eltexto = eltexto + "<br>";
            elerror = 1;
        }

        eltexto = eltexto + "</div>";

        if (elerror == 0) {
            return true;
        } else {
            document.getElementById("errorsubmit").innerHTML = eltexto;
            return false;
        }
    });

});