<?php
session_start();
// PARA saber si estamos en un servidor local
define('IS_LOCAL',      in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']));
define('URL',           (IS_LOCAL ? 'http://127.0.0.1/proyectoCotizador/' : 'LA URL DE SERVER EN PRODUCCION'));

//RUTAS PARA CARPETAS
define('DS',            DIRECTORY_SEPARATOR);
define('ROOT',          getcwd() . DS);
define('APP',           ROOT. 'app' . DS);
define('ASSETS',        ROOT. 'assets' . DS);
define('TEMPLATES',     ROOT. 'templates' . DS);
define('INCLUDES',      TEMPLATES. 'includes' . DS);
define('MODULES',       TEMPLATES. ',modules' . DS);
define('VIEWS',         TEMPLATES. 'views' . DS);
define('UPLOADS' ,      ROOT. 'uploads' . DS);

define('CSS', URL.      'assets/css/');
define('IMG', URL.      'assets/img/');
define('JS', URL.       'assets/js/');

define('APP_NAME',      'Cotizador');
define('TAXES_RATE',    16);
define('SHIPPING',      99.50);
//CARGANDO FUNCIONES
require_once APP.'functions.php';
