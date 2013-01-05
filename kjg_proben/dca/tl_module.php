<?php

/**
 * Table tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['kjg_proben_list'] = '{title_legend},name,headline,type;{config_legend},kjg_proben_archives;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['fields']['kjg_proben_archives'] = array(
    'lable'      => $GLOBALS['TL_LANG']['tl_module']['kjg_proben_archives'],
    'inputType'  => 'select',
    'foreignKey' => 'tl_kjg_proben_archive.title',
    'eval'       => array('mandatory' => true)
);

?>