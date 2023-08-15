<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

// Création d'un fichier pour l'intégration des tabs
$adminPath =  PHPWG_ROOT_PATH . 'admin/';
$filename = 'photo_validated_by.php';

if(!file_exists($adminPath . $filename)) {
    file_put_contents($adminPath . $filename, "<?php \n ?>");
}

?>