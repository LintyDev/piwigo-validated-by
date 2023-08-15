<?php 

// Bloque l'accès direct au script
defined('PHPWG_ROOT_PATH') or die('Hacking attempt! 3');
// Récupère dans l'url 'page' s'il existe
if(isset($_GET['page'])){
    $get_page = explode('-', $_GET['page']);
    $image_id = intval(end($get_page));
}
// Lance ma fonction d'ajout d'un nouvel onglet admin
add_event_handler('tabsheet_before_select', 'add_sheet_validated_by', 50);

function add_sheet_validated_by($sheets, $id) {
   
    if ($id == 'photo') {
        $sheets['validated_by'] = array(
            'caption' => '✔ &nbsp;Validated By',
            //'url' => get_root_url().'admin.php?page=photo-'.$_GET['image_id'].'-validated_by',
            'url' => get_root_url().'admin.php?page=photo-'.$_GET['image_id'].'&tab=validated_by',
        );
    }
    return $sheets;
}
// Vérifie si nous sommes sur l'onglet validated_by
if (isset($_GET['tab']) && $_GET['tab'] == 'validated_by') {
    // A la soumission du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['validated_by'])) {
        save_validated_data($image_id);
    }
    display_validate($image_id);
}

function save_validated_data($image_id) {
    global $prefixeTable, $template;

    // Récupère les données pour la requête || "pwg_db_real_escape_string" pour éviter InjecSQL
    $validated_by = pwg_db_real_escape_string($_POST['validated_by']);
    //$get_page = explode('-', $_GET['page']);
    //$image_id = intval(end($get_page));
    
    // Modifie le champ "validated_by"
    $query = "UPDATE {$prefixeTable}images SET validated_by = '".$validated_by."' WHERE id = ".$image_id;
    $result = pwg_query($query);

    // Assigne un message à la template
    if($result) {
        $template->assign('VALIDATED_BY_MESSAGE', array(
            'text' => 'Les paramètres ont été enregistrés avec succès!',
            'type' => 'infos',
            'icon' => '<i class="eiw-icon icon-ok"></i>'
        ));
    } else {
        $template->assign('VALIDATED_BY_MESSAGE', array(
            'text' => 'Une erreur est survenue lors de l\'enregistrement..',
            'type' => 'infosError',
            'icon' => ''
        ));
    }
}

function display_validate($image_id) {
    global $template, $prefixeTable;

    // Récupère les valeurs de la photo dans la bdd
    $query = "SELECT * FROM {$prefixeTable}images WHERE id =".$image_id;
    $result = pwg_query($query);
    $row = pwg_db_fetch_assoc($result);
    // Récupère la valeur actuelle de 'validated_by'
    $current_validated_by = $row['validated_by'];
    $img = DerivativeImage::url(IMG_XXSMALL, $row);

    // Assigne le dirname du plugin à la template
    $template->assign('VALIDATED_BY_PATH', VALIDATED_BY_PATH);
    $template->assign('CURRENT_VALIDATED_BY', $current_validated_by);
    $template->assign('CURRENT_IMG_VALIDATED_BY', $img);
    // Charge le fichier de la template
    $template->set_filenames(array(
        'plugin_admin_content' => VALIDATED_BY_PATH . 'template/validated_by.tpl'
    ));

    // Display la template
    $template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
}
// Ajouter dans les actions par lot mon plugin
add_event_handler('loc_end_element_set_global', 'display_action');
function display_action() {
    global $template;

    $template->set_filenames(array(
        'validated_by_action_content' => VALIDATED_BY_PATH . 'template/validated_by_action.tpl'
    ));

    ob_start();
    $template->pparse('validated_by_action_content');
    $content = ob_get_clean();
    $plugins_actions = array(
        array(
            'ID' => 'validated_by',
            'NAME' => 'Gérer "Validated By"',
            'CONTENT' => $content
            )
    );
    $template->func_combine_css(array(
        "id" => "validated_by_action",
        "path" => VALIDATED_BY_PATH . 'css/validated_by_action.css'
    ));
    $template->assign('element_set_global_plugins_actions', $plugins_actions);
}
// Gerer la function d'action de validated_by
add_event_handler('element_set_global_action', 'validated_by_action');
function validated_by_action($action, $collection) {
    global $prefixeTable;

    // Copie et adaptation du code de batch_manager_global.php
    if ('validated_by' == $action) {

        if (isset($_POST['validated_by_action'])) {
            $_POST['validated_by'] = null;
        }
        
        $datas = array();
        foreach($collection as $img_id) {
            $datas[] = array(
                'id' => $img_id,
                'validated_by' => $_POST['validated_by']
            );
        }

        mass_updates(
            "{$prefixeTable}images",
            array('primary' => array('id'), 'update' => array('validated_by')),
            $datas
        );
        pwg_activity('photo', $collection, 'edit', array('action'=>'validated_by'));
    }
}
?>