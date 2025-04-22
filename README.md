<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🖨️ Gestión de Impresoras - Laravel + SNMP

Aplicación web desarrollada en **Laravel** con motor de plantillas **Blade**, que permite administrar y supervisar impresoras dentro de una empresa a través del protocolo **SNMP**. Incluye funcionalidades para la monitorización diaria de páginas impresas y la visualización de estadísticas mediante gráficos.

---

## 🚀 Características principales

-   Gestión CRUD de impresoras (modelo, IP, ubicación, etc.).
-   Conexión SNMP a impresoras para recuperar información como:
    -   Total de páginas impresas
    -   Modelo
    -   Número de serie
    -   Dirección MAC
-   Almacenamiento histórico de páginas impresas por día.
-   Visualización gráfica mensual de páginas impresas.
-   Automatización mediante **cron job** para actualizar datos diariamente.

---

## 🧱 Tecnologías utilizadas

-   ⚙️ **Laravel** (framework backend)
-   🎨 **Blade** (motor de plantillas)
-   🖧 **SNMP** (consulta de datos de red)
-   📈 **Chart.js** (gráficos interactivos)
-   🕒 **Scheduler de Laravel** + **cron job** (automatización diaria)

---

## 📊 Visualización de datos

La aplicación muestra un **gráfico de barras** con las páginas impresas por cada mes del año, calculadas automáticamente a partir de los datos históricos obtenidos mediante SNMP.

---

## 🛠️ Requisitos

### Requisitos del Sistema
- PHP 8.1 o superior
- Laravel 10.x
- Node.js 16.x o superior
- MySQL 5.7 o superior (o MariaDB 10.3+)
- Composer 2.x
- php-snmp extension (versión compatible con tu versión de PHP)
- snmpd service

### Requisitos de Hardware Recomendados
- Memoria RAM: 2GB mínimo
- Espacio en disco: 1GB mínimo para la aplicación
- CPU: 2 cores mínimo recomendado

### Requisitos de Red
- Acceso a las impresoras vía SNMP (puerto 161/UDP)
- Conexión a Internet para la instalación de dependencias

---

## 📦 Instalación

### 1. Preparación del Sistema
```bash
# Instalación de dependencias del sistema
sudo apt-get update
sudo apt-get install php-snmp snmp snmpd
```

### 2. Instalación de la Aplicación
```bash
# Clonar el repositorio
cd /var/www/html/
git clone https://github.com/pmerida08/impresorasCrud.git
cd impresorasCrud

# Instalar dependencias
composer install
npm install
npm run build

# Configurar permisos
sudo chown -R www-data:www-data /var/www/html/impresorasCrud
sudo chmod -R 775 storage bootstrap/cache

# Configuración inicial
cp .env.example .env
php artisan key:generate
```

### 3. Configuración de la Base de Datos

Tienes dos opciones para configurar la base de datos:

#### Opción A: Crear una nueva base de datos
1. Crear una base de datos MySQL
```bash
mysql -u root -p
CREATE DATABASE impresoras_db;
GRANT ALL PRIVILEGES ON impresoras_db.* TO 'tu_usuario'@'localhost';
FLUSH PRIVILEGES;
```

2. Configurar el archivo .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=impresoras_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

3. Ejecutar las migraciones
```bash
php artisan migrate
```

#### Opción B: Importar la base de datos existente
1. Acceder a phpMyAdmin (http://localhost/phpmyadmin o la URL correspondiente)
2. Crear una nueva base de datos (por ejemplo, "impresoras_db")
3. Seleccionar la base de datos creada
4. Ir a la pestaña "Importar"
5. Hacer clic en "Seleccionar archivo" y elegir el archivo `impresorasproyecto.sql` del proyecto
6. Clic en "Continuar" o "Go" para realizar la importación

7. Configurar el archivo .env con los datos de acceso:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=impresoras_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

Nota: Si utilizas la Opción B (importar la base de datos), no necesitas ejecutar las migraciones ya que la estructura de la base de datos se importará junto con los datos.
```

---

## ⚙️ Configuración

### Apache

#### 📝 Pasos:

1. Abre el archivo /etc/hosts (Linux) y añade:
```bash
127.0.0.1 tudominio.test
# o
IP_DEL_SERVIDOR tudominio.test
```

2. Crea el archivo /etc/apache2/sites-available/tudominio.conf
```apache
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

3. Habilita el sitio y el módulo rewrite
```bash
sudo a2ensite tudominio.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Cron job

Para la actualización automática de datos:

1. Abre el crontab:
```bash
crontab -e
```

2. Añade la siguiente línea:
```bash
* * * * * php /ruta/a/tu/proyecto/artisan schedule:run >> /dev/null 2>&1
```

---

## 🔧 Configuración de Desarrollo

### Entorno de Desarrollo
1. Instalar las dependencias de desarrollo:
```bash
composer install --dev
npm install
```

2. Configurar el archivo .env.testing para pruebas

### Herramientas Recomendadas
- Visual Studio Code con extensiones para PHP/Laravel
- Laravel Debugbar para desarrollo
- PHP CS Fixer para estándares de código
- PHPUnit para pruebas

### Ejecutar Pruebas
```bash
php artisan test
```

---

## 🛡️ Seguridad

### Configuración de SNMP
- Usar SNMP v3 cuando sea posible
- Cambiar las community strings por defecto
- Limitar el acceso SNMP a IPs específicas

### Permisos y Accesos
- Mantener los permisos correctos en los directorios
- Usar roles y permisos para acceso a funcionalidades
- Mantener las dependencias actualizadas

### Buenas Prácticas
- Realizar backups regulares de la base de datos
- Monitorizar los logs de acceso
- Mantener el sistema actualizado

---

## 📋 Solución de Problemas Comunes

### Problemas de Permisos
```bash
# Si hay problemas de escritura en storage:
sudo chown -R www-data:www-data storage
sudo chmod -R 775 storage
```

### Errores SNMP
- Verificar que el servicio SNMP está activo en las impresoras
- Comprobar la conectividad de red
- Verificar las community strings

### Problemas de Base de Datos
- Verificar las credenciales en .env
- Comprobar que el servicio MySQL está activo
- Verificar los permisos del usuario de la base de datos

### Comandos Útiles
```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Verificar estado de servicios
systemctl status snmpd
systemctl status mysql
systemctl status apache2
```

---

## 📂 Estructura de carpetas relevante

```arduino
app/
├── Console/
│   └── Kernel.php        ← Programador de tareas
├── Http/
│   └── Controllers/
│       └── ImpresoraController.php
│       └── ImpresoraHistoricoController.php
├── Models/
│   └── Impresora.php     ← Modelo con conexión SNMP
│   └── ImpresoraHistorico.php
resources/
└── views/
    └── impresora/
        └── historico.blade.php  ← Gráfico de estadísticas
```
