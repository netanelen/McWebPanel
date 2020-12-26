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

    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    $("#form-player-idle-timeout").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

    $("#form-max-build-height").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

    $("#form-entity-broadcast-range-percentage").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

    $("#form-spawn-protection").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

    $("#form-max-world-size").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

    $("#form-max-players").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

    $("#form-query-port").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

    $("#form-rconport").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

    $("#form-max-tick-time").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            if (e.keyCode == 45) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    });

    $("#form-op-permission-level").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

    $("#form-function-permission-level").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

    $("#form-rate-limit").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

    $("#form-network-compression-threshold").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            if (e.keyCode == 45) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    });

    $("#form-view-distance").keypress(function(e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            return false;
        } else {
            return true;
        }
    });

    $("#form-level-name").keypress(function(e) {
        if (e.keyCode >= 48 && e.keyCode <= 57 || e.keyCode >= 65 && e.keyCode <= 90 || e.keyCode >= 97 && e.keyCode <= 122 || e.keyCode == 45 || e.keyCode == 95 || e.keyCode == 13) {
            return true;
        } else {
            return false;
        }
    });

    if (document.getElementById("label-gamemode") !== null) {
        if (document.getElementById("form-gamemode") !== null) {
            document.getElementById("label-gamemode").innerHTML = "gamemode=" + document.getElementById("form-gamemode").value;
        }
    }

    if (document.getElementById("label-force-gamemode") !== null) {
        if (document.getElementById("form-force-gamemode") !== null) {
            document.getElementById("label-force-gamemode").innerHTML = "force-gamemode=" + document.getElementById("form-force-gamemode").value;
        }
    }

    if (document.getElementById("label-difficulty") !== null) {
        if (document.getElementById("form-difficulty") !== null) {
            document.getElementById("label-difficulty").innerHTML = "difficulty=" + document.getElementById("form-difficulty").value;
        }
    }

    if (document.getElementById("label-hardcore") !== null) {
        if (document.getElementById("form-hardcore") !== null) {
            document.getElementById("label-hardcore").innerHTML = "hardcore=" + document.getElementById("form-hardcore").value;
        }
    }

    if (document.getElementById("label-pvp") !== null) {
        if (document.getElementById("form-pvp") !== null) {
            document.getElementById("label-pvp").innerHTML = "pvp=" + document.getElementById("form-pvp").value;
        }
    }

    if (document.getElementById("label-spawn-npcs") !== null) {
        if (document.getElementById("form-spawn-npcs") !== null) {
            document.getElementById("label-spawn-npcs").innerHTML = "spawn-npcs=" + document.getElementById("form-spawn-npcs").value;
        }
    }

    if (document.getElementById("label-spawn-animals") !== null) {
        if (document.getElementById("form-spawn-animals") !== null) {
            document.getElementById("label-spawn-animals").innerHTML = "spawn-animals=" + document.getElementById("form-spawn-animals").value;
        }
    }

    if (document.getElementById("label-spawn-monsters") !== null) {
        if (document.getElementById("form-spawn-monsters") !== null) {
            document.getElementById("label-spawn-monsters").innerHTML = "spawn-monsters=" + document.getElementById("form-spawn-monsters").value;
        }
    }

    if (document.getElementById("label-allow-flight") !== null) {
        if (document.getElementById("form-allow-flight") !== null) {
            document.getElementById("label-allow-flight").innerHTML = "allow-flight=" + document.getElementById("form-allow-flight").value;
        }
    }

    if (document.getElementById("label-player-idle-timeout") !== null) {
        if (document.getElementById("form-player-idle-timeout") !== null) {
            document.getElementById("label-player-idle-timeout").innerHTML = "player-idle-timeout=" + document.getElementById("form-player-idle-timeout").value;
        }
    }

    if (document.getElementById("label-resource-pack") !== null) {
        if (document.getElementById("form-resource-pack") !== null) {
            document.getElementById("label-resource-pack").innerHTML = "resource-pack=" + document.getElementById("form-resource-pack").value;
        }
    }

    if (document.getElementById("label-resource-pack-sha1") !== null) {
        if (document.getElementById("form-resource-pack-sha1") !== null) {
            document.getElementById("label-resource-pack-sha1").innerHTML = "resource-pack-sha1=" + document.getElementById("form-resource-pack-sha1").value;
        }
    }

    if (document.getElementById("label-level-name") !== null) {
        if (document.getElementById("form-level-name") !== null) {
            document.getElementById("label-level-name").innerHTML = "level-name=" + document.getElementById("form-level-name").value;
        }
    }

    if (document.getElementById("label-level-seed") !== null) {
        if (document.getElementById("form-level-seed") !== null) {
            document.getElementById("label-level-seed").innerHTML = "level-seed=" + document.getElementById("form-level-seed").value;
        }
    }

    if (document.getElementById("label-level-type") !== null) {
        if (document.getElementById("form-level-type") !== null) {
            document.getElementById("label-level-type").innerHTML = "level-type=" + document.getElementById("form-level-type").value;
        }
    }

    if (document.getElementById("label-generator-settings") !== null) {
        if (document.getElementById("form-generator-settings") !== null) {
            document.getElementById("label-generator-settings").innerHTML = "generator-settings=" + document.getElementById("form-generator-settings").value;
        }
    }

    if (document.getElementById("label-max-build-height") !== null) {
        if (document.getElementById("form-max-build-height") !== null) {
            document.getElementById("label-max-build-height").innerHTML = "max-build-height=" + document.getElementById("form-max-build-height").value;
        }
    }

    if (document.getElementById("label-generate-structures") !== null) {
        if (document.getElementById("form-generate-structures") !== null) {
            document.getElementById("label-generate-structures").innerHTML = "generate-structures=" + document.getElementById("form-generate-structures").value;
        }
    }

    if (document.getElementById("label-allow-nether") !== null) {
        if (document.getElementById("form-allow-nether") !== null) {
            document.getElementById("label-allow-nether").innerHTML = "allow-nether=" + document.getElementById("form-allow-nether").value;
        }
    }

    if (document.getElementById("label-entity-broadcast-range-percentage") !== null) {
        if (document.getElementById("form-entity-broadcast-range-percentage") !== null) {
            document.getElementById("label-entity-broadcast-range-percentage").innerHTML = "entity-broadcast-range-percentage=" + document.getElementById("form-entity-broadcast-range-percentage").value;
        }
    }

    if (document.getElementById("label-spawn-protection") !== null) {
        if (document.getElementById("form-spawn-protection") !== null) {
            document.getElementById("label-spawn-protection").innerHTML = "spawn-protection=" + document.getElementById("form-spawn-protection").value;
        }
    }

    if (document.getElementById("label-max-world-size") !== null) {
        if (document.getElementById("form-max-world-size") !== null) {
            document.getElementById("label-max-world-size").innerHTML = "max-world-size=" + document.getElementById("form-max-world-size").value;
        }
    }

    if (document.getElementById("label-online-mode") !== null) {
        if (document.getElementById("form-online-mode") !== null) {
            document.getElementById("label-online-mode").innerHTML = "online-mode=" + document.getElementById("form-online-mode").value;
        }
    }

    if (document.getElementById("label-max-players") !== null) {
        if (document.getElementById("form-max-players") !== null) {
            document.getElementById("label-max-players").innerHTML = "max-players=" + document.getElementById("form-max-players").value;
        }
    }

    if (document.getElementById("label-enable-command-block") !== null) {
        if (document.getElementById("form-enable-command-block") !== null) {
            document.getElementById("label-enable-command-block").innerHTML = "enable-command-block=" + document.getElementById("form-enable-command-block").value;
        }
    }

    if (document.getElementById("label-enable-query") !== null) {
        if (document.getElementById("form-enable-query") !== null) {
            document.getElementById("label-enable-query").innerHTML = "enable-query=" + document.getElementById("form-enable-query").value;
        }
    }

    if (document.getElementById("label-query-port") !== null) {
        if (document.getElementById("form-query-port") !== null) {
            document.getElementById("label-query-port").innerHTML = "query.port=" + document.getElementById("form-query-port").value;
        }
    }

    if (document.getElementById("label-enable-rcon") !== null) {
        if (document.getElementById("form-enable-rcon") !== null) {
            document.getElementById("label-enable-rcon").innerHTML = "enable-rcon=" + document.getElementById("form-enable-rcon").value;
        }
    }

    if (document.getElementById("label-rconport") !== null) {
        if (document.getElementById("form-rconport") !== null) {
            document.getElementById("label-rconport").innerHTML = "rcon.port=" + document.getElementById("form-rconport").value;
        }
    }

    if (document.getElementById("label-rcon-password") !== null) {
        if (document.getElementById("form-rcon-password") !== null) {
            document.getElementById("label-rcon-password").innerHTML = "rcon.password=" + document.getElementById("form-rcon-password").value;
        }
    }

    if (document.getElementById("label-white-list") !== null) {
        if (document.getElementById("form-white-list") !== null) {
            document.getElementById("label-white-list").innerHTML = "white-list=" + document.getElementById("form-white-list").value;
        }
    }

    if (document.getElementById("label-enforce-whitelist") !== null) {
        if (document.getElementById("form-enforce-whitelist") !== null) {
            document.getElementById("label-enforce-whitelist").innerHTML = "enforce-whitelist=" + document.getElementById("form-enforce-whitelist").value;
        }
    }

    if (document.getElementById("label-server-ip") !== null) {
        if (document.getElementById("form-server-ip") !== null) {
            document.getElementById("label-server-ip").innerHTML = "server-ip=" + document.getElementById("form-server-ip").value;
        }
    }

    if (document.getElementById("label-enable-status") !== null) {
        if (document.getElementById("form-enable-status") !== null) {
            document.getElementById("label-enable-status").innerHTML = "enable-status=" + document.getElementById("form-enable-status").value;
        }
    }

    if (document.getElementById("label-broadcast-console-to-ops") !== null) {
        if (document.getElementById("form-broadcast-console-to-ops") !== null) {
            document.getElementById("label-broadcast-console-to-ops").innerHTML = "broadcast-console-to-ops=" + document.getElementById("form-broadcast-console-to-ops").value;
        }
    }

    if (document.getElementById("label-broadcast-rcon-to-ops") !== null) {
        if (document.getElementById("form-broadcast-rcon-to-ops") !== null) {
            document.getElementById("label-broadcast-rcon-to-ops").innerHTML = "broadcast-rcon-to-ops=" + document.getElementById("form-broadcast-rcon-to-ops").value;
        }
    }

    if (document.getElementById("label-use-native-transport") !== null) {
        if (document.getElementById("form-use-native-transport") !== null) {
            document.getElementById("label-use-native-transport").innerHTML = "use-native-transport=" + document.getElementById("form-use-native-transport").value;
        }
    }

    if (document.getElementById("label-prevent-proxy-connections") !== null) {
        if (document.getElementById("form-prevent-proxy-connections") !== null) {
            document.getElementById("label-prevent-proxy-connections").innerHTML = "prevent-proxy-connections=" + document.getElementById("form-prevent-proxy-connections").value;
        }
    }

    if (document.getElementById("label-enable-jmx-monitoring") !== null) {
        if (document.getElementById("form-enable-jmx-monitoring") !== null) {
            document.getElementById("label-enable-jmx-monitoring").innerHTML = "enable-jmx-monitoring=" + document.getElementById("form-enable-jmx-monitoring").value;
        }
    }

    if (document.getElementById("label-snooper-enabled") !== null) {
        if (document.getElementById("form-snooper-enabled") !== null) {
            document.getElementById("label-snooper-enabled").innerHTML = "snooper-enabled=" + document.getElementById("form-snooper-enabled").value;
        }
    }

    if (document.getElementById("label-sync-chunk-writes") !== null) {
        if (document.getElementById("form-sync-chunk-writes") !== null) {
            document.getElementById("label-sync-chunk-writes").innerHTML = "sync-chunk-writes=" + document.getElementById("form-sync-chunk-writes").value;
        }
    }

    if (document.getElementById("label-max-tick-time") !== null) {
        if (document.getElementById("form-max-tick-time") !== null) {
            document.getElementById("label-max-tick-time").innerHTML = "max-tick-time=" + document.getElementById("form-max-tick-time").value;
        }
    }

    if (document.getElementById("label-op-permission-level") !== null) {
        if (document.getElementById("form-op-permission-level") !== null) {
            document.getElementById("label-op-permission-level").innerHTML = "op-permission-level=" + document.getElementById("form-op-permission-level").value;
        }
    }

    if (document.getElementById("label-function-permission-level") !== null) {
        if (document.getElementById("form-function-permission-level") !== null) {
            document.getElementById("label-function-permission-level").innerHTML = "function-permission-level=" + document.getElementById("form-function-permission-level").value;
        }
    }

    if (document.getElementById("label-rate-limit") !== null) {
        if (document.getElementById("form-rate-limit") !== null) {
            document.getElementById("label-rate-limit").innerHTML = "rate-limit=" + document.getElementById("form-rate-limit").value;
        }
    }

    if (document.getElementById("label-network-compression-threshold") !== null) {
        if (document.getElementById("form-network-compression-threshold") !== null) {
            document.getElementById("label-network-compression-threshold").innerHTML = "network-compression-threshold=" + document.getElementById("form-network-compression-threshold").value;
        }
    }

    if (document.getElementById("label-view-distance") !== null) {
        if (document.getElementById("form-view-distance") !== null) {
            document.getElementById("label-view-distance").innerHTML = "view-distance=" + document.getElementById("form-view-distance").value;
        }
    }

    if (document.getElementById("label-motd") !== null) {
        if (document.getElementById("form-motd") !== null) {
            document.getElementById("label-motd").innerHTML = "motd=" + htmlEntities(document.getElementById("form-motd").value);
        }
    }

    if (document.getElementById("form-motd") !== null) {
        if (document.getElementById("visormotd") !== null) {
            updatemotd(document.getElementById("form-motd").value);
        }
    }

    $("#form-gamemode").change(function() {
        var envioaction = "gamemode";
        var enviovalor = document.getElementById("form-gamemode").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-gamemode") !== null) {
            document.getElementById("label-gamemode").innerHTML = "gamemode=" + document.getElementById("form-gamemode").value;
        }

    });

    $("#form-force-gamemode").change(function() {
        var envioaction = "force-gamemode";
        var enviovalor = document.getElementById("form-force-gamemode").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-force-gamemode") !== null) {
            document.getElementById("label-force-gamemode").innerHTML = "force-gamemode=" + document.getElementById("form-force-gamemode").value;
        }

    });

    $("#form-difficulty").change(function() {
        var envioaction = "difficulty";
        var enviovalor = document.getElementById("form-difficulty").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-difficulty") !== null) {
            document.getElementById("label-difficulty").innerHTML = "difficulty=" + document.getElementById("form-difficulty").value;
        }

    });

    $("#form-hardcore").change(function() {
        var envioaction = "hardcore";
        var enviovalor = document.getElementById("form-hardcore").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-hardcore") !== null) {
            document.getElementById("label-hardcore").innerHTML = "hardcore=" + document.getElementById("form-hardcore").value;
        }

    });

    $("#form-pvp").change(function() {
        var envioaction = "pvp";
        var enviovalor = document.getElementById("form-pvp").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-pvp") !== null) {
            document.getElementById("label-pvp").innerHTML = "pvp=" + document.getElementById("form-pvp").value;
        }

    });

    $("#form-spawn-npcs").change(function() {
        var envioaction = "spawn-npcs";
        var enviovalor = document.getElementById("form-spawn-npcs").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-spawn-npcs") !== null) {
            document.getElementById("label-spawn-npcs").innerHTML = "spawn-npcs=" + document.getElementById("form-spawn-npcs").value;
        }

    });

    $("#form-spawn-animals").change(function() {
        var envioaction = "spawn-animals";
        var enviovalor = document.getElementById("form-spawn-animals").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-spawn-animals") !== null) {
            document.getElementById("label-spawn-animals").innerHTML = "spawn-animals=" + document.getElementById("form-spawn-animals").value;
        }

    });

    $("#form-spawn-monsters").change(function() {
        var envioaction = "spawn-monsters";
        var enviovalor = document.getElementById("form-spawn-monsters").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-spawn-monsters") !== null) {
            document.getElementById("label-spawn-monsters").innerHTML = "spawn-monsters=" + document.getElementById("form-spawn-monsters").value;
        }

    });

    $("#form-allow-flight").change(function() {
        var envioaction = "allow-flight";
        var enviovalor = document.getElementById("form-allow-flight").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-allow-flight") !== null) {
            document.getElementById("label-allow-flight").innerHTML = "allow-flight=" + document.getElementById("form-allow-flight").value;
        }

    });

    $("#form-player-idle-timeout").change(function() {
        var errores = 0;
        var envioaction = "player-idle-timeout";
        var enviovalor = document.getElementById("form-player-idle-timeout").value;
        if (enviovalor > 2147483647) {
            errores = 1;
        }

        if (errores == 0) {
            $.ajax({
                type: "POST",
                url: "function/guardarproperties.php",
                data: {
                    action: envioaction,
                    valor: enviovalor
                },
                success: function(data) {
                    var getdebug = 0;
                    if (getdebug == 1) {
                        alert(data);
                    }
                }
            });

            if (document.getElementById("label-player-idle-timeout") !== null) {
                document.getElementById("label-player-idle-timeout").innerHTML = "player-idle-timeout=" + document.getElementById("form-player-idle-timeout").value;
            }
        }
    });

    $("#form-resource-pack").keyup(function() {
        var envioaction = "resource-pack";
        var enviovalor = document.getElementById("form-resource-pack").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-resource-pack") !== null) {
            document.getElementById("label-resource-pack").innerHTML = "resource-pack=" + document.getElementById("form-resource-pack").value;
        }

    });

    $("#form-resource-pack-sha1").keyup(function() {
        var envioaction = "resource-pack-sha1";
        var enviovalor = document.getElementById("form-resource-pack-sha1").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-resource-pack-sha1") !== null) {
            document.getElementById("label-resource-pack-sha1").innerHTML = "resource-pack-sha1=" + document.getElementById("form-resource-pack-sha1").value;
        }

    });

    $("#form-level-name").keyup(function() {
        var envioaction = "level-name";
        var enviovalor = document.getElementById("form-level-name").value;
        enviovalor = enviovalor.toLowerCase();
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-level-name") !== null) {
            document.getElementById("label-level-name").innerHTML = "level-name=" + enviovalor;
        }

    });

    $("#form-level-seed").keyup(function() {
        var envioaction = "level-seed";
        var enviovalor = document.getElementById("form-level-seed").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-level-seed") !== null) {
            document.getElementById("label-level-seed").innerHTML = "level-seed=" + document.getElementById("form-level-seed").value;
        }

    });

    $("#form-level-type").change(function() {
        var envioaction = "level-type";
        var enviovalor = document.getElementById("form-level-type").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-level-type") !== null) {
            document.getElementById("label-level-type").innerHTML = "level-type=" + document.getElementById("form-level-type").value;
        }

    });

    $("#form-generator-settings").keyup(function() {
        var envioaction = "generator-settings";
        var enviovalor = document.getElementById("form-generator-settings").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-generator-settings") !== null) {
            document.getElementById("label-generator-settings").innerHTML = "generator-settings=" + document.getElementById("form-generator-settings").value;
        }

    });

    $("#form-max-build-height").change(function() {
        var errores = 0;
        var envioaction = "max-build-height";
        var enviovalor = document.getElementById("form-max-build-height").value;
        if (enviovalor > 256 || enviovalor < 8) {
            errores = 1;
        }

        if (errores == 0) {
            $.ajax({
                type: "POST",
                url: "function/guardarproperties.php",
                data: {
                    action: envioaction,
                    valor: enviovalor
                },
                success: function(data) {
                    var getdebug = 0;
                    if (getdebug == 1) {
                        alert(data);
                    }
                }
            });

            if (document.getElementById("label-max-build-height") !== null) {
                document.getElementById("label-max-build-height").innerHTML = "max-build-height=" + document.getElementById("form-max-build-height").value;
            }
        }
    });

    $("#form-generate-structures").change(function() {
        var envioaction = "generate-structures";
        var enviovalor = document.getElementById("form-generate-structures").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-generate-structures") !== null) {
            document.getElementById("label-generate-structures").innerHTML = "generate-structures=" + document.getElementById("form-generate-structures").value;
        }

    });

    $("#form-allow-nether").change(function() {
        var envioaction = "allow-nether";
        var enviovalor = document.getElementById("form-allow-nether").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-allow-nether") !== null) {
            document.getElementById("label-allow-nether").innerHTML = "allow-nether=" + document.getElementById("form-allow-nether").value;
        }

    });

    $("#form-entity-broadcast-range-percentage").change(function() {
        var errores = 0;
        var envioaction = "entity-broadcast-range-percentage";
        var enviovalor = document.getElementById("form-entity-broadcast-range-percentage").value;

        if (enviovalor > 500 || enviovalor < 0) {
            errores = 1;
        }

        if (errores == 0) {

            $.ajax({
                type: "POST",
                url: "function/guardarproperties.php",
                data: {
                    action: envioaction,
                    valor: enviovalor
                },
                success: function(data) {
                    var getdebug = 0;
                    if (getdebug == 1) {
                        alert(data);
                    }
                }
            });

            if (document.getElementById("label-entity-broadcast-range-percentage") !== null) {
                document.getElementById("label-entity-broadcast-range-percentage").innerHTML = "entity-broadcast-range-percentage=" + document.getElementById("form-entity-broadcast-range-percentage").value;
            }
        }
    });

    $("#form-spawn-protection").change(function() {
        var errores = 0;
        var envioaction = "spawn-protection";
        var enviovalor = document.getElementById("form-spawn-protection").value;

        if (enviovalor > 16 || enviovalor < 0) {
            errores = 1;
        }

        if (errores == 0) {

            $.ajax({
                type: "POST",
                url: "function/guardarproperties.php",
                data: {
                    action: envioaction,
                    valor: enviovalor
                },
                success: function(data) {
                    var getdebug = 0;
                    if (getdebug == 1) {
                        alert(data);
                    }
                }
            });

            if (document.getElementById("label-spawn-protection") !== null) {
                document.getElementById("label-spawn-protection").innerHTML = "spawn-protection=" + document.getElementById("form-spawn-protection").value;
            }
        }
    });

    $("#form-max-world-size").change(function() {
        var errores = 0;
        var envioaction = "max-world-size";
        var enviovalor = document.getElementById("form-max-world-size").value;

        if (enviovalor > 29999984 || enviovalor < 1) {
            errores = 1;
        }

        if (errores == 0) {

            $.ajax({
                type: "POST",
                url: "function/guardarproperties.php",
                data: {
                    action: envioaction,
                    valor: enviovalor
                },
                success: function(data) {
                    var getdebug = 0;
                    if (getdebug == 1) {
                        alert(data);
                    }
                }
            });

            if (document.getElementById("label-max-world-size") !== null) {
                document.getElementById("label-max-world-size").innerHTML = "max-world-size=" + document.getElementById("form-max-world-size").value;
            }
        }
    });

    $("#form-online-mode").change(function() {
        var envioaction = "online-mode";
        var enviovalor = document.getElementById("form-online-mode").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-online-mode") !== null) {
            document.getElementById("label-online-mode").innerHTML = "online-mode=" + document.getElementById("form-online-mode").value;
        }

    });

    $("#form-max-players").change(function() {
        var errores = 0;
        var envioaction = "max-players";
        var enviovalor = document.getElementById("form-max-players").value;

        if (enviovalor > 2147483647 || enviovalor < 1) {
            errores = 1;
        }

        if (errores == 0) {

            $.ajax({
                type: "POST",
                url: "function/guardarproperties.php",
                data: {
                    action: envioaction,
                    valor: enviovalor
                },
                success: function(data) {
                    var getdebug = 0;
                    if (getdebug == 1) {
                        alert(data);
                    }
                }
            });

            if (document.getElementById("label-max-players") !== null) {
                document.getElementById("label-max-players").innerHTML = "max-players=" + document.getElementById("form-max-players").value;
            }
        }
    });

    $("#form-enable-command-block").change(function() {
        var envioaction = "enable-command-block";
        var enviovalor = document.getElementById("form-enable-command-block").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-enable-command-block") !== null) {
            document.getElementById("label-enable-command-block").innerHTML = "enable-command-block=" + document.getElementById("form-enable-command-block").value;
        }

    });

    $("#form-enable-query").change(function() {
        var envioaction = "enable-query";
        var enviovalor = document.getElementById("form-enable-query").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-enable-query") !== null) {
            document.getElementById("label-enable-query").innerHTML = "enable-query=" + document.getElementById("form-enable-query").value;
        }

    });

    $("#form-query-port").change(function() {
        var errores = 0;
        var envioaction = "query.port";
        var enviovalor = document.getElementById("form-query-port").value;

        if (enviovalor > 65535 || enviovalor < 1025) {
            errores = 1;
        }

        if (errores == 0) {

            $.ajax({
                type: "POST",
                url: "function/guardarproperties.php",
                data: {
                    action: envioaction,
                    valor: enviovalor
                },
                success: function(data) {
                    var getdebug = 0;
                    if (getdebug == 1) {
                        alert(data);
                    }
                }
            });

            if (document.getElementById("label-query-port") !== null) {
                document.getElementById("label-query-port").innerHTML = "query.port=" + document.getElementById("form-query-port").value;
            }
        }
    });

    $("#form-enable-rcon").change(function() {
        var envioaction = "enable-rcon";
        var enviovalor = document.getElementById("form-enable-rcon").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-enable-rcon") !== null) {
            document.getElementById("label-enable-rcon").innerHTML = "enable-rcon=" + document.getElementById("form-enable-rcon").value;
        }

    });

    $("#form-rconport").change(function() {
        var errores = 0;
        var envioaction = "rcon.port";
        var enviovalor = document.getElementById("form-rconport").value;

        if (enviovalor > 65535 || enviovalor < 1025) {
            errores = 1;
        }

        if (errores == 0) {

            $.ajax({
                type: "POST",
                url: "function/guardarproperties.php",
                data: {
                    action: envioaction,
                    valor: enviovalor
                },
                success: function(data) {
                    var getdebug = 0;
                    if (getdebug == 1) {
                        alert(data);
                    }
                }
            });

            if (document.getElementById("label-rconport") !== null) {
                document.getElementById("label-rconport").innerHTML = "rcon.port=" + document.getElementById("form-rconport").value;
            }
        }
    });

    $("#form-rcon-password").keyup(function() {
        var envioaction = "rcon.password";
        var enviovalor = document.getElementById("form-rcon-password").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-rcon-password") !== null) {
            document.getElementById("label-rcon-password").innerHTML = "rcon.password=" + document.getElementById("form-rcon-password").value;
        }
    });

    $("#form-white-list").change(function() {
        var envioaction = "white-list";
        var enviovalor = document.getElementById("form-white-list").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-white-list") !== null) {
            document.getElementById("label-white-list").innerHTML = "white-list=" + document.getElementById("form-white-list").value;
        }

    });

    $("#form-enforce-whitelist").change(function() {
        var envioaction = "enforce-whitelist";
        var enviovalor = document.getElementById("form-enforce-whitelist").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-enforce-whitelist") !== null) {
            document.getElementById("label-enforce-whitelist").innerHTML = "enforce-whitelist=" + document.getElementById("form-enforce-whitelist").value;
        }

    });

    $("#form-server-ip").keyup(function() {
        var envioaction = "server-ip";
        var enviovalor = document.getElementById("form-server-ip").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-server-ip") !== null) {
            document.getElementById("label-server-ip").innerHTML = "server-ip=" + document.getElementById("form-server-ip").value;
        }

    });

    $("#form-enable-status").change(function() {
        var envioaction = "enable-status";
        var enviovalor = document.getElementById("form-enable-status").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-enable-status") !== null) {
            document.getElementById("label-enable-status").innerHTML = "enable-status=" + document.getElementById("form-enable-status").value;
        }

    });

    $("#form-broadcast-console-to-ops").change(function() {
        var envioaction = "broadcast-console-to-ops";
        var enviovalor = document.getElementById("form-broadcast-console-to-ops").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-broadcast-console-to-ops") !== null) {
            document.getElementById("label-broadcast-console-to-ops").innerHTML = "broadcast-console-to-ops=" + document.getElementById("form-broadcast-console-to-ops").value;
        }

    });

    $("#form-broadcast-rcon-to-ops").change(function() {
        var envioaction = "broadcast-rcon-to-ops";
        var enviovalor = document.getElementById("form-broadcast-rcon-to-ops").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-broadcast-rcon-to-ops") !== null) {
            document.getElementById("label-broadcast-rcon-to-ops").innerHTML = "broadcast-rcon-to-ops=" + document.getElementById("form-broadcast-rcon-to-ops").value;
        }

    });

    $("#form-use-native-transport").change(function() {
        var envioaction = "use-native-transport";
        var enviovalor = document.getElementById("form-use-native-transport").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-use-native-transport") !== null) {
            document.getElementById("label-use-native-transport").innerHTML = "use-native-transport=" + document.getElementById("form-use-native-transport").value;
        }

    });

    $("#form-prevent-proxy-connections").change(function() {
        var envioaction = "prevent-proxy-connections";
        var enviovalor = document.getElementById("form-prevent-proxy-connections").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-prevent-proxy-connections") !== null) {
            document.getElementById("label-prevent-proxy-connections").innerHTML = "prevent-proxy-connections=" + document.getElementById("form-prevent-proxy-connections").value;
        }

    });

    $("#form-enable-jmx-monitoring").change(function() {
        var envioaction = "enable-jmx-monitoring";
        var enviovalor = document.getElementById("form-enable-jmx-monitoring").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-enable-jmx-monitoring") !== null) {
            document.getElementById("label-enable-jmx-monitoring").innerHTML = "enable-jmx-monitoring=" + document.getElementById("form-enable-jmx-monitoring").value;
        }

    });

    $("#form-snooper-enabled").change(function() {
        var envioaction = "snooper-enabled";
        var enviovalor = document.getElementById("form-snooper-enabled").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-snooper-enabled") !== null) {
            document.getElementById("label-snooper-enabled").innerHTML = "snooper-enabled=" + document.getElementById("form-snooper-enabled").value;
        }

    });

    $("#form-sync-chunk-writes").change(function() {
        var envioaction = "sync-chunk-writes";
        var enviovalor = document.getElementById("form-sync-chunk-writes").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-sync-chunk-writes") !== null) {
            document.getElementById("label-sync-chunk-writes").innerHTML = "sync-chunk-writes=" + document.getElementById("form-sync-chunk-writes").value;
        }

    });

    $("#form-max-tick-time").change(function() {
        var errores = 0;
        var envioaction = "max-tick-time";
        var enviovalor = document.getElementById("form-max-tick-time").value;

        if (enviovalor > 300000 || enviovalor < -1) {
            document.getElementById("form-max-tick-time").value = 60000;
            errores = 1;
        }

        if (errores == 0) {

            $.ajax({
                type: "POST",
                url: "function/guardarproperties.php",
                data: {
                    action: envioaction,
                    valor: enviovalor
                },
                success: function(data) {
                    var getdebug = 0;
                    if (getdebug == 1) {
                        alert(data);
                    }
                }
            });

            if (document.getElementById("label-max-tick-time") !== null) {
                document.getElementById("label-max-tick-time").innerHTML = "max-tick-time=" + document.getElementById("form-max-tick-time").value;
            }
        }
    });

    $("#form-op-permission-level").change(function() {
        var errores = 0;
        var envioaction = "op-permission-level";
        var enviovalor = document.getElementById("form-op-permission-level").value;

        if (enviovalor > 4 || enviovalor < 1) {
            errores = 1;
        }

        if (errores == 0) {

            $.ajax({
                type: "POST",
                url: "function/guardarproperties.php",
                data: {
                    action: envioaction,
                    valor: enviovalor
                },
                success: function(data) {
                    var getdebug = 0;
                    if (getdebug == 1) {
                        alert(data);
                    }
                }
            });

            if (document.getElementById("label-op-permission-level") !== null) {
                document.getElementById("label-op-permission-level").innerHTML = "op-permission-level=" + document.getElementById("form-op-permission-level").value;
            }
        }
    });

    $("#form-function-permission-level").change(function() {
        var errores = 0;
        var envioaction = "function-permission-level";
        var enviovalor = document.getElementById("form-function-permission-level").value;

        if (enviovalor > 4 || enviovalor < 1) {
            errores = 1;
        }

        if (errores == 0) {

            $.ajax({
                type: "POST",
                url: "function/guardarproperties.php",
                data: {
                    action: envioaction,
                    valor: enviovalor
                },
                success: function(data) {
                    var getdebug = 0;
                    if (getdebug == 1) {
                        alert(data);
                    }
                }
            });

            if (document.getElementById("label-function-permission-level") !== null) {
                document.getElementById("label-function-permission-level").innerHTML = "function-permission-level=" + document.getElementById("form-function-permission-level").value;
            }
        }
    });

    $("#form-rate-limit").change(function() {
        var envioaction = "rate-limit";
        var enviovalor = document.getElementById("form-rate-limit").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-rate-limit") !== null) {
            document.getElementById("label-rate-limit").innerHTML = "rate-limit=" + document.getElementById("form-rate-limit").value;
        }

    });

    $("#form-network-compression-threshold").change(function() {
        var errores = 0;
        var envioaction = "network-compression-threshold";
        var enviovalor = document.getElementById("form-network-compression-threshold").value;

        if (enviovalor > 256 || enviovalor < -1) {
            document.getElementById("form-network-compression-threshold").value = 256;
            errores = 1;
        }

        if (errores == 0) {

            $.ajax({
                type: "POST",
                url: "function/guardarproperties.php",
                data: {
                    action: envioaction,
                    valor: enviovalor
                },
                success: function(data) {
                    var getdebug = 0;
                    if (getdebug == 1) {
                        alert(data);
                    }
                }
            });

            if (document.getElementById("label-network-compression-threshold") !== null) {
                document.getElementById("label-network-compression-threshold").innerHTML = "network-compression-threshold=" + document.getElementById("form-network-compression-threshold").value;
            }
        }
    });

    $("#form-view-distance").change(function() {
        var errores = 0;
        var envioaction = "view-distance";
        var enviovalor = document.getElementById("form-view-distance").value;

        if (enviovalor > 32 || enviovalor < 3) {
            errores = 1;
        }

        if (errores == 0) {

            $.ajax({
                type: "POST",
                url: "function/guardarproperties.php",
                data: {
                    action: envioaction,
                    valor: enviovalor
                },
                success: function(data) {
                    var getdebug = 0;
                    if (getdebug == 1) {
                        alert(data);
                    }
                }
            });

            if (document.getElementById("label-view-distance") !== null) {
                document.getElementById("label-view-distance").innerHTML = "view-distance=" + document.getElementById("form-view-distance").value;
            }
        }
    });

    function updatemotd(textomotd) {
        $.ajax({
            type: "POST",
            url: "function/visormotd.php",
            data: {
                action: textomotd
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }

                if (document.getElementById("visormotd") !== null) {
                    document.getElementById("visormotd").innerHTML = data;
                }
            }
        });
    }

    $("#form-motd").keyup(function() {
        var envioaction = "motd";
        var enviovalor = document.getElementById("form-motd").value;
        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-motd") !== null) {
            document.getElementById("label-motd").innerHTML = "motd=" + htmlEntities(document.getElementById("form-motd").value);
        }

        if (document.getElementById("form-motd") !== null) {
            updatemotd(document.getElementById("form-motd").value);
        }

    });

    document.getElementById("form-motd").addEventListener('paste', function(event) {
        var envioaction = "motd";
        var enviovalor = event.clipboardData.getData('text');

        var eltext = "";
        var textini = "";
        var textfinal = "";
        var enviar = "";

        var text = document.getElementById("form-motd");

        var startPosition = text.selectionStart;
        var endPosition = text.selectionEnd;
        var longitud = text.leng;

        eltext = document.getElementById("form-motd").value;
        textini = eltext.substring(0, startPosition);
        textfinal = eltext.substring(endPosition, longitud);

        enviar = textini + event.clipboardData.getData('text') + textfinal;
        enviovalor = enviar;

        $.ajax({
            type: "POST",
            url: "function/guardarproperties.php",
            data: {
                action: envioaction,
                valor: enviovalor
            },
            success: function(data) {
                var getdebug = 0;
                if (getdebug == 1) {
                    alert(data);
                }
            }
        });

        if (document.getElementById("label-motd") !== null) {
            document.getElementById("label-motd").innerHTML = "motd=" + htmlEntities(enviovalor);
        }

        if (document.getElementById("visormotd") !== null) {
            updatemotd(enviovalor);
        }

    });

    $("#restablecer").click(function() {
        var eleccion = confirm("¡Confirmacion de restablecer configuracin por defecto!\n\n¡Esta acción creará un nuevo archivo de configuración server.properties, una vez realizado no se podrá cancelar!\n\n¿Seguro que quieres continuar?");
        if (eleccion == true) {

            $.ajax({
                url: 'function/restablecerproperties.php',
                data: {
                    action: 'status'
                },
                type: 'POST',
                success: function(data) {
                    if (data == "OK") {
                        location.reload();
                    } else if (data == "nowriteconfig") {
                        alert("La carpeta config no tiene permisos de escritura");
                    } else if (data == "nowriteproperties") {
                        alert("El archivo /config/serverproperties.txt no tiene permisos de escritura");
                    }

                }
            });
        }
    });

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