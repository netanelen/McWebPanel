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

    $("#guardaserver").click(function () {
        document.getElementById("result").innerHTML = '<img src="img/guardando.gif" alt="Guardando">'

        var eldata = $("#formconf :input").serializeArray();

        document.getElementById('finpage').scrollIntoView();

        $.post($("#formconf").attr("action"), eldata, function (data) {

            if (data == "nowriteconf") {
                document.getElementById("result").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta config no tiene permisos de escritura.</div>";
            } else if (data == "nocarpetaconf") {
                document.getElementById("result").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La carpeta conf no existe.</div>";
            } else if (data == "nowritehtaccess") {
                document.getElementById("result").innerHTML = "<div class='alert alert-danger' role='alert'>Error: El archivo .htaccess en la raíz, no tiene permisos de escritura.</div>";
            } else if (data == "nojavaenruta") {
                document.getElementById("result").innerHTML = "<div class='alert alert-danger' role='alert'>Error: El archivo java no se encuentra en la ruta.</div>";
            } else if (data == "nojavaencontrado") {
                document.getElementById("result").innerHTML = "<div class='alert alert-danger' role='alert'>Error: El archivo java no encontrado en el sistema.</div>";
            } else if (data == "datolimitebacksuperior") {
                document.getElementById("result").innerHTML = "<div class='alert alert-danger' role='alert'>Error: Has asignado más gigas en backups de lo permitido.</div>";
            } else if (data == "datolimiteminesuperior") {
                document.getElementById("result").innerHTML = "<div class='alert alert-danger' role='alert'>Error: Has asignado más gigas en minecraft de lo permitido.</div>";
            } else if (data == "valornonumerico") {
                document.getElementById("result").innerHTML = "<div class='alert alert-danger' role='alert'>Error: Has asignado un valor incorrecto no numérico.</div>";
            } else if (data == "novalido") {
                document.getElementById("result").innerHTML = "<div class='alert alert-danger' role='alert'>Error: La ruta introducida no es válida.</div>";
            } else if (data == "inpanel") {
                document.getElementById("result").innerHTML = "<div class='alert alert-danger' role='alert'>Error: No se puede asignar una ruta dentro del panel.</div>";
            } else if (data == "saveconf") {
                document.getElementById("result").innerHTML = "<div class='alert alert-success' role='alert'>Configuración Guardada.</div>";
                document.getElementById("guardaserver").disabled = true;
            }else{
                document.getElementById("result").innerHTML = "";
            }
        });

    });

    $("#formconf").submit(function () {
        return false;

    });

    document.getElementById("guardaserver").disabled = true;

    if (document.getElementById('elnomserv') !== null) {
        $("#elnomserv").keyup(function () {
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";

            if (this.value == "") {
                document.getElementById("guardaserver").disabled = true;
            }

        });

        document.getElementById("elnomserv").addEventListener('paste', function () {
            document.getElementById("guardaserver").disabled = false;
        });
    }

    if (document.getElementById('eltipserv') !== null) {
        $("#eltipserv").change(function () {
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }

    if (document.getElementById('elmaxupload') !== null) {
        $("#elmaxupload").change(function () {
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }

    if (document.getElementById('elram') !== null) {
        $("#elram").change(function () {
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }

    if (document.getElementById('listadojars') !== null) {
        $("#listadojars").change(function () {
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }

    if (document.getElementById('basura0') !== null) {
        $("#basura0").change(function () {
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }

    if (document.getElementById('basura1') !== null) {
        $("#basura1").change(function () {
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }

    if (document.getElementById('basura2') !== null) {
        $("#basura2").change(function () {
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }

    if (document.getElementById('opforceupgrade') !== null) {
        $("#opforceupgrade").change(function () {
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }

    if (document.getElementById('operasecache') !== null) {
        $("#operasecache").change(function () {
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }

    if (document.getElementById('configjavaselect0') !== null) {
        $("#configjavaselect0").change(function () {
            if (document.getElementById('javamanual') !== null) {
                document.getElementById('javamanual').value = "";
            }
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }

    if (document.getElementById('configjavaselect1') !== null) {
        $("#configjavaselect1").change(function () {
            if (document.getElementById('javamanual') !== null) {
                document.getElementById('javamanual').value = "";
            }
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }

    if (document.getElementById('configjavaselect2') !== null) {
        $("#configjavaselect2").change(function () {
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }

    if (document.getElementById('selectedjavaver') !== null) {
        $("#selectedjavaver").change(function () {
            if (document.getElementById('configjavaselect1') !== null) {
                document.getElementById('configjavaselect1').checked = true;
            }
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }

    if (document.getElementById('javamanual') !== null) {
        $("#javamanual").keypress(function () {
            if (document.getElementById('configjavaselect2') !== null) {
                document.getElementById('configjavaselect2').checked = true;
            }
            document.getElementById("guardaserver").disabled = false;
            document.getElementById("result").innerHTML = "";
        });
    }



    document.getElementById("javamanual").addEventListener('paste', function (event) {
        var enviovalor = event.clipboardData.getData('text');

        var eltext = "";
        var textini = "";
        var textfinal = "";
        var enviar = "";

        var text = document.getElementById("javamanual");

        var startPosition = text.selectionStart;
        var endPosition = text.selectionEnd;
        var longitud = text.leng;

        eltext = document.getElementById("javamanual").value;
        textini = eltext.substring(0, startPosition);
        textfinal = eltext.substring(endPosition, longitud);

        enviar = textini + event.clipboardData.getData('text') + textfinal;
        enviovalor = enviar;

        if (document.getElementById('configjavaselect2') !== null) {
            document.getElementById('configjavaselect2').checked = true;
        }

        document.getElementById("guardaserver").disabled = false;
        document.getElementById("result").innerHTML = "";

    });

    if (document.getElementById('elport') !== null) {
        $("#elport").change(function () {
            var elnumero = document.getElementById("elport").value;
            document.getElementById("result").innerHTML = "";

            if (elnumero < 1025 || elnumero > 65535) {
                document.getElementById("elport").value = "";
            } else {
                document.getElementById("guardaserver").disabled = false;
            }
        });
    }

    if (document.getElementById('elport') !== null) {
        $("#elport").keypress(function (e) {
            if (e.keyCode < 48 || e.keyCode > 57) {
                return false;
            } else {
                return true;
            }
        });
    }

    if (document.getElementById('linconsola') !== null) {
        $("#linconsola").change(function () {
            var elnumero = document.getElementById("linconsola").value;
            document.getElementById("result").innerHTML = "";

            if (elnumero < 0 || elnumero > 1000) {
                document.getElementById("linconsola").value = "100";
            } else {
                document.getElementById("guardaserver").disabled = false;
            }
        });
    }

    if (document.getElementById('linconsola') !== null) {
        $("#linconsola").keypress(function (e) {
            if (e.keyCode < 48 || e.keyCode > 57) {
                return false;
            } else {
                return true;
            }
        });
    }

    if (document.getElementById('limitbackupgb') !== null) {
        $("#limitbackupgb").change(function () {
            var elnumero = document.getElementById("limitbackupgb").value;
            document.getElementById("result").innerHTML = "";

            if (elnumero < 0 || elnumero > 100) {
                document.getElementById("limitbackupgb").value = "";
            } else {
                document.getElementById("guardaserver").disabled = false;
            }
        });
    }

    if (document.getElementById('limitbackupgb') !== null) {
        $("#limitbackupgb").keypress(function (e) {
            if (e.keyCode < 48 || e.keyCode > 57) {
                return false;
            } else {
                return true;
            }
        });
    }

    if (document.getElementById('limitminecraftgb') !== null) {
        $("#limitminecraftgb").change(function () {
            var elnumero = document.getElementById("limitminecraftgb").value;
            document.getElementById("result").innerHTML = "";

            if (elnumero < 0 || elnumero > 100) {
                document.getElementById("limitminecraftgb").value = "";
            } else {
                document.getElementById("guardaserver").disabled = false;
            }
        });
    }

    if (document.getElementById('limitminecraftgb') !== null) {
        $("#limitminecraftgb").keypress(function (e) {
            if (e.keyCode < 48 || e.keyCode > 57) {
                return false;
            } else {
                return true;
            }
        });
    }

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