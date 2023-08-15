<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt! 3');
// définie ma nouvelle méthode
function api_validated_by($arr) {

    $service = &$arr[0];
    $service->addMethod(
        'pwg.setvalidatedby',
        'set_validated_by',
        array(
            'image_id' => array('type' => WS_TYPE_ID),
            'validated_by' => array(
                'default'=>null,
                'info'=>'if this field is empty "validated_by" turn to null (like Not Validated)'
            )
        ),
        'Set the validated_by field for an image',
        null,
        array('admin_only'=>true, 'post_only' => true)
    );
}
add_event_handler('ws_add_methods','api_validated_by');
// Fonction maj validated_by
function set_validated_by($params) {
    
    global $prefixeTable;
    $update = array(
        'validated_by' => $params['validated_by']
    );
    $where = array(
        'id' => $params['image_id']
    );
    
   single_update("{$prefixeTable}images", $update, $where);
   return array('result' => 'success');
}
?>