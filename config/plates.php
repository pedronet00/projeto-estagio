<?php
require_once 'vendor/autoload.php'; // Carrega o autoload do Composer

use League\Plates\Engine;

// Define o diretório dos templates
$templates = new Engine(__DIR__);

// Define a extensão dos arquivos de template (se for diferente de .php)
$templates->setFileExtension('php');

return $templates;
?>
