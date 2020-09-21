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

    var observe;
    if (window.attachEvent) {
        observe = function(element, event, handler) {
            element.attachEvent('on' + event, handler);
        };
    } else {
        observe = function(element, event, handler) {
            element.addEventListener(event, handler, false);
        };
    }


    var text = document.getElementById('eleditor');

    function resize() {
        text.style.height = 'auto';
        text.style.height = text.scrollHeight + 'px';
    }
    /* 0-timeout to get the already changed text */
    function delayedResize() {
        window.setTimeout(resize, 0);
    }

    resize();


    document.getElementById("guardarfile").disabled = true;

    $("#eleditor").keypress(function() {
        document.getElementById("guardarfile").disabled = false;
    });

    $("#eleditor").change(function() {
        document.getElementById("guardarfile").disabled = false;
    });

    $("#guardarfile").click(function() {
        var jqxhr = $.ajax({
            url: 'function/editarsavefile.php',
            data: {
                action: this.value,
                eltexto: document.getElementById("eleditor").value
            },
            type: 'POST',
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
                if (data == "OK") {
                    location.href = "gestorarchivos.php";
                } else if (data == "noexiste") {
                    alert("El archivo no existe");
                } else if (data == "nowrite") {
                    alert("El archivo no tiene permisos de escritura");
                }
            },
            error: function(errorThrown) {
                alert(errorThrown);
            }
        });
    });

    $("#cancelar").click(function() {
        location.href = "gestorarchivos.php";
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