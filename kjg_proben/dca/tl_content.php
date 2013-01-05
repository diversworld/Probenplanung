<?php

/**
 * Table tl_content
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['kjg_proben_viewer'] = '{title_legend},type,headline;{kjg_proben_legend},kjg_proben;{protected_legend:hide},protected;{expert_legend:hide},guests,invisible,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['fields']['kjg_proben'] = array(
    'label'            => $GLOBALS['TL_LANG']['tl_content']['kjg_proben'],
    'inputType'        => 'select',
    'options_callback' => array('DataContainerProben', 'getProbenOptions'),
    'eval'             => array('mandatory' => true, 'chosen' => true, 'includeBlankOption' => true),

);