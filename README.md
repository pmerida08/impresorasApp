<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions">
        <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
    </a>
</p>

# 🖨️ Gestión de Impresoras - Laravel + SNMP

Aplicación web desarrollada en **Laravel** con motor de plantillas **Blade**, que permite administrar y supervisar impresoras dentro de una empresa a través del protocolo **SNMP**. Incluye funcionalidades para la monitorización diaria de páginas impresas y la visualización de estadísticas mediante gráficos.

---

## 🚀 Características principales

- Gestión CRUD de impresoras (modelo, IP, ubicación, etc.).
- Conexión SNMP a impresoras para recuperar información como:
    - Total de páginas impresas
    - Modelo
    - Número de serie
    - Dirección MAC
- Almacenamiento histórico de páginas impresas por día.
- Visualización gráfica mensual de páginas impresas.
- Automatización mediante **cron job** para actualizar datos diariamente.

---

## 🧱 Tecnologías utilizadas

- **Laravel** (framework backend)
- **Blade** (motor de plantillas)
- **SNMP** (consulta de datos de red)
- **Chart.js** (gráficos interactivos)
- **Scheduler de Laravel** + **cron job** (automatización diaria)

---

## 📦 Instalación

### 1. Preparación del Sistema

#### Ubuntu/Debian

```bash
sudo apt-get update
sudo apt-get install php-snmp snmp snmpd apache2 php php-mysql mysql-server npm composer git
sudo apt install phpmyadmin # Opcional

```

#### Red Hat 9.5 / Fedora 38
```bash
sudo dnf update -y

# Habilitar SSH (opcional)
sudo dnf install openssh-server
sudo systemctl start sshd
sudo systemctl enable sshd

# (Opcional, NO recomendado en producción) Permitir acceso root por SSH:
# Edita /etc/ssh/sshd_config y cambia:
# PermitRootLogin yes
# Luego reinicia:
sudo systemctl restart sshd

# PHP y SNMP
sudo dnf install https://rpms.remirepo.net/enterprise/remi-release-9.rpm
sudo dnf config-manager --set-enabled remi
sudo dnf module enable php:remi-8.3
sudo dnf install php php-cli php-gd php-curl php-zip php-mbstring php-snmp

# SNMP Server
sudo dnf install net-snmp net-snmp-utils
# Edita [snmpd.conf](http://_vscodecontentref_/0) y cambia la community string 'public' por una más segura
sudo systemctl enable snmpd
sudo systemctl start snmpd
snmpwalk -v2c -c tu_comunidad localhost

# Apache
sudo dnf install httpd
sudo systemctl enable --now httpd
sudo systemctl status httpd

# MariaDB, Composer y Laravel
sudo dnf install mariadb-server php-fpm php-json php-zip php-mysqlnd curl unzip -y
sudo systemctl start php-fpm httpd mariadb
sudo systemctl enable php-fpm httpd mariadb

# phpMyAdmin y Git
sudo dnf install phpMyAdmin git

# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
composer --version

# Node.js y npm
curl -fsSL https://rpm.nodesource.com/setup_22.x -o nodesource_setup.sh
sudo -E bash nodesource_setup.sh
sudo dnf install nodejs -y
node -v
npm -v
```

### 2. Clonar el repositorio e instalar dependencias

```bash	
cd /var/www/html/
git clone https://github.com/pmerida08/impresorasCrud.git
cd impresorasCrud

composer update
composer install
npm install
npm install vite --save-dev
npm run build
```

#### Configurar permisos
  - Ubuntu/Debian:
```bash
sudo chown -R www-data:www-data /var/www/html/impresorasCrud

cp [.env.example](http://_vscodecontentref_/0) .env
php artisan key:generate
```

 - Red Hat/Fedora:
```bash
sudo chown -R apache:apache /var/www/html/impresorasCrud

sudo chmod -R 775 storage bootstrap/cache

cp [.env.example](http://_vscodecontentref_/0) .env
php artisan key:generate
```

### 3. Configurar la base de datos

Accede a MariaDB/MySQL y ejecuta:
```sql
CREATE USER 'laravel_user'@'localhost' IDENTIFIED BY 'laravel_user';
CREATE DATABASE impresoras_db;
GRANT ALL PRIVILEGES ON impresoras_db.* TO 'laravel_user'@'localhost';
FLUSH PRIVILEGES;
```
### 4. Configurar el archivo `.env`
Edita el archivo `.env` y configura los siguientes parámetros:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=impresoras_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_user
```

Ejecuta las migraciones para crear las tablas necesarias:

```bash
php artisan migrate
```

### 5. Configuración de Apache

- Ubuntu/Debian:
```bash
sudo nano /etc/apache2/sites-available/impresoras.conf

# Añade el siguiente contenido:
<VirtualHost *:80>
    ServerName tudominio.test
    DocumentRoot /var/www/html/impresorasCrud/public

    <Directory /var/www/html/impresorasCrud/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/tudominio_error.log
    CustomLog ${APACHE_LOG_DIR}/tudominio_access.log combined
</VirtualHost>
```

Habilita el sitio y reinicia Apache:

```bash
sudo a2ensite tudominio.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```
- Red Hat/Fedora:
```bash
sudo nano /etc/httpd/conf.d/impresoras.conf
# Añade el siguiente contenido:
<VirtualHost *:80>
    DocumentRoot /var/www/html/impresorasCrud/public
    ServerName impresoras.test

    <Directory /var/www/html/impresorasCrud/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog /var/log/httpd/impresoras.test_error.log
    CustomLog /var/log/httpd/impresoras.test_access.log combined
</VirtualHost>
```
Reinicia Apache:

```bash
sudo systemctl restart httpd
```

### 6. Configurar el archivo `hosts`

```bash
sudo nano /etc/hosts
# Añade la siguiente línea:
10.67.0.47 impresoras.test
```

### 7. Cron Job para actualización diaria
Edita el archivo de cron:

```bash
crontab -e
```
Añade la siguiente línea para ejecutar el comando de actualización diariamente a las 2 AM:

```bash
0 * * * * /usr/bin/php /var/www/html/impresorasCrud/artisan impresoras:actualizar_paginas >> /dev/null 2>&1
0 * * * * /usr/bin/php /var/www/html/impresorasCrud/artisan impresoras:actualizar-snmp-impresoras >> /dev/null 2>&1
```

## 🔧 Utilidades y problemas comunes
### Problemas de permisos en carpetas

Si encuentras problemas de permisos, asegúrate de que las carpetas `storage` y `bootstrap/cache` tienen los permisos correctos:

```bash
# Ubuntu/Debian:
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

# Red Hat/Fedora:
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R apache:apache storage bootstrap/cache
```

### Comandos útiles para servicios

```bash
# Ubuntu/Debian:
systemctl status snmpd
systemctl status mysql
systemctl status apache2

# Red Hat/Fedora:
systemctl status snmpd
systemctl status mariadb
systemctl status httpd
```

### Problemas de permisos a la hora de crear base de datos en phpmyadmin

Si tienes problemas de permisos al crear bases de datos en phpMyAdmin, asegúrate de que el usuario tiene los privilegios necesarios:

```sql
CREATE USER 'nombre_usuario'@'localhost' IDENTIFIED BY 'tu_contraseña_segura';
GRANT ALL PRIVILEGES ON *.* TO 'nombre_usuario'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
```

_Hay que tener en cuenta que en las tablas que se crean o se importan, que los identificadores (atributo -> id) sean AutoIncrementables_
