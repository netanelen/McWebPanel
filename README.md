# McWebPanel
McWebPanel es un panel de administración de Software Libre exclusivo para Servidores Minecraft, creado para PHP7 para ser utilizado en servidores Apache.

Diseñado pensando en usuarios con conocimientos limitados a la hora de crear servidores y con el objetivo de utilizar el menor número de dependencias posibles.

Una interfaz de usuario responsive bajo Bootstrap para una navegación fácil para los usuarios.

![PanelGif](https://user-images.githubusercontent.com/34619567/93478584-1ec69800-f8fc-11ea-9319-51a590a30313.gif)

## Comenzando 🚀

Estas instrucciones te permitirán obtener una copia del proyecto en funcionamiento en tu servidor.



### Pre-requisitos 📋

Estos son los requisitos para que McWebPanel funcione

```
Ubuntu Server 18/20 (Sistema Operativo)
Apache2             (Servidor Web)
Php 7.2 o superior  (Paginas PHP)
OpenJDK             (Maquina Virtual Java)
screen              (GNU Screen)
php-mbstring        (Libreria strings php)
php-zip             (Libreria Zip php)
php-cli             (Libreria cli php)
Apache Mod Rewrite  (Modulo Activado)
```

### Instalación 🔧

Guia paso a paso para realizar la instalación

Instalar Requisitos

```
sudo apt install apache2 php libapache2-mod-php default-jdk screen php-mbstring php-zip php-cli
```

Activar MOD Rewrite

```
sudo a2enmod rewrite
```
