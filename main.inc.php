<?php
/*
Plugin Name: Validated By
Version: 1.1
Description: Permet d'associer un paramètre "validated_by" à une photo.
Plugin URI: http://future-lien-github.com
Author: Willy `Linty` D
Author URI: http://lintydotdev.vercel.app
*/

// Bloque l'accès direct au script
defined('PHPWG_ROOT_PATH') or die('Hacking attemp!');

// Definir mes fichiers
define('VALIDATED_BY_ID', basename(dirname(__FILE__)));
define('VALIDATED_BY_PATH', PHPWG_PLUGINS_PATH . VALIDATED_BY_ID . '/');

// Quand "init" est appelé => je lance ma fonction
add_event_handler('init', 'sql_install_validated_by');
function sql_install_validated_by() {
    global $prefixeTable, $pwg_db_link;
    
    // Install : Vérifier si le fichier photo_validated_by.php existe 
    include(VALIDATED_BY_PATH . 'install.php');

    // Vérifier si "validated_by" existe dans la db
    $result = pwg_query("SHOW COLUMNS FROM {$prefixeTable}images LIKE 'validated_by';");

    // Si "validated_by" n'existe pas => add
    if(!pwg_db_fetch_assoc($result)) {
        pwg_query("ALTER TABLE {$prefixeTable}images ADD COLUMN validated_by VARCHAR(100) DEFAULT NULL;");
    }
    include_once(VALIDATED_BY_PATH . 'admin.php');
    include_once(VALIDATED_BY_PATH . 'api.php');
}

add_event_handler('loc_end_picture', 'add_validated_by_info');

function add_validated_by_info() {
    global $template, $prefixeTable, $page;

    // Récupère la valeur actuelle de 'validated_by'
    $image_id = $page['image_id'];
    $query = "SELECT validated_by FROM {$prefixeTable}images WHERE id =".$image_id;
    $result = pwg_query($query);
    $row = pwg_db_fetch_assoc($result);
    // Vérifie si elle est null
    if($row['validated_by'] === null) {
        $validated_by_value = 'Not Validated';
    } else {
        $validated_by_value = $row['validated_by'];
    }
    // Display les infos dans la section metadata de picture.tpl
    $template->append('metadata', array(
        'TITLE' => '',
        'lines' => array('Validated by' => $validated_by_value)
    ));

}

?>