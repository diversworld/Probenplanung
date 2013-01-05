<?php

/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['kjg_proben'] = array(
    'kjg_probenverwaltung' => array(
        'tables' => array('tl_kjg_proben_archive', 'tl_kjg_proben'),
        'icon'   => 'system/modules/kjg_proben/assets/images/icon.png',

    )
);

/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['kjg_proben'] = array(
    'kjg_proben_list' => 'ModuleProbenList'
);

/**
 * Content elements
 */
$GLOBALS['TL_CTE']['kjg_proben'] = array(
    'kjg_proben_viewer' => 'ContentProbenViewer'
);
?>