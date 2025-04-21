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

- ⚙️ **Laravel** (framework backend)
- 🎨 **Blade** (motor de plantillas)
- 🖧 **SNMP** (consulta de datos de red)
- 📈 **Chart.js** (gráficos interactivos)
- 🕒 **Scheduler de Laravel** + **cron job** (automatización diaria)

---

## 📊 Visualización de datos

La aplicación muestra un **gráfico de barras** con las páginas impresas por cada mes del año, calculadas automáticamente a partir de los datos históricos obtenidos mediante SNMP.

---

## ⚙️ Configuración del cron job

Para que la aplicación actualice automáticamente el número de páginas impresas diariamente, debes configurar un **cron job** en tu servidor.

### 📝 Pasos:

1. Abre el archivo de cron con el siguiente comando:

```bash
crontab -e
```

2. Añade la siguiente línea al final del archivo (ajustando la ruta a tu proyecto):

```bash
* * * * * php /ruta/a/tu/proyecto/artisan schedule:run >> /dev/null 2>&1
```

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

## 🛠️ Requisitos

- PHP 8.x

- Laravel 10.x

- SNMP habilitado en el servidor

- MySQL o equivalente

- Composer

## 📦 Instalación

```bash

git clone https://github.com/pmerida08/impresorasCrud.git
cd impresorasCrud
composer install
npm install
cp .env.example .env
php artisan key:generate
# Configura la base de datos en .env
php artisan migrate
php artisan serve
```
