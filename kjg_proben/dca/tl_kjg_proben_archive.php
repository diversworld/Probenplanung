<?php

/**
 * @package   ProbenPlanung
 * @author    Eckhard Becker
 * @license   GNU/GPL
 * @copyright Diversworld, 2012
 */


/**
 * Table tl_kjg_proben_archive
 */
$GLOBALS['TL_DCA']['tl_kjg_proben_archive'] = array
(

    // Config
    'config'      => array
    (
        'dataContainer'     => 'Table',
        'ctable'            => array(),
        'switchToEdit'      => true,
        'enableVersioning'  => true,
        'onsubmit_callback' => array
        (
            array('tl_kjg_proben_archive', 'adjustTime'),
            array('tl_kjg_proben_archive', 'generateProbe')
        )
    ),

    // List
    'list'        => array
    (
        'sorting'           => array
        (
            'mode'        => 1,
            'fields'      => array('title'),
            'flag'        => 1,
            'panelLayout' => 'filter;search,limit',
        ),
        'label'             => array
        (
            'fields' => array('title', 'id'),
            'format' => '%s (ID: %d)'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="e"'
            )
        ),
        'operations'        => array
        (
            'edit'       => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_kjg_proben_archive']['edit'],
                'href'       => 'table=tl_kjg_proben',
                'icon'       => 'edit.gif',
                'attributes' => 'class="contextmenu"'
            ),
            'editheader' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_kjg_proben_archive']['editheader'],
                'href'       => 'act=edit',
                'icon'       => 'header.gif',
                'attributes' => 'class="edit-header"'
            ),
            'copy'       => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_kjg_proben_archive']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif'
            ),
            'delete'     => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_kjg_proben_archive']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show'       => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_kjg_proben_archive']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif'
            )
        )
    ),

    // Palettes
    'palettes'    => array
    (
        //'__selector__'                => array(''),
        'default' => '{title_legend},title,alias;{proben_legend},slotdate,slotstart,slotend,interv;{publish_legend:hide},published,start,stop;'
    ),

    // Subpalettes
    'subpalettes' => array
    (
        '' => ''
    ),

    // Fields
    'fields'      => array
    (
        'title'     => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben_archive']['title'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50 clr')
        ),
        'alias'     => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_kjg_proben_archive']['alias'],
            'exclude'       => true,
            'search'        => true,
            'inputType'     => 'text',
            'eval'          => array('rgxp' => 'alnum', 'unique' => true, 'spaceToUnderscore' => true, 'maxlength' => 128, 'tl_class' => 'w50 clr'),
            'save_callback' => array(array('tl_kjg_proben_archive', 'generateAlias')
            )
        ),
        'slotdate'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben_archive']['slotdate'],
            'default'   => time(),
            'exclude'   => true,
            'filter'    => true,
            'sorting'   => true,
            'flag'      => 6,
            'inputType' => 'text',
            'eval'      => array('rgxp' => 'datim', 'mandatory' => true, 'datepicker' => true, 'tl_class' => 'w50 clr wizard')
        ),
        'slotstart' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben_archive']['slotstart'],
            'exclude'   => true,
            'inputType' => 'text',
            'flag'      => 6,
            'eval'      => array('rgxp' => 'time', 'mandatory' => true, 'tl_class' => 'w50 clr')
        ),
        'slotend'   => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben_archive']['slotend'],
            'exclude'   => true,
            'inputType' => 'text',
            'flag'      => 6,
            'eval'      => array('rgxp' => 'time', 'mandatory' => true, 'tl_class' => 'w50')
        ),
        'interv'    => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben_archive']['interv'],
            'default'   => '30',
            'exclude'   => true,
            'inputType' => 'select',
            'options'   => array('30', '60', '90', '120'),
            'eval'      => array('mandatory' => false, 'maxlength' => 2, 'tl_class' => 'w50 wizard'),
        ),
        'published' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben_archive']['published'],
            'exclude'   => true,
            'filter'    => true,
            'flag'      => 1,
            'inputType' => 'checkbox',
            'eval'      => array('doNotCopy' => true)
        ),
        'start'     => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben_archive']['start'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => array('rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard')
        ),
        'stop'      => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben_archiv']['stop'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => array('rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard')
        )
    )
);

class tl_kjg_proben_archive extends Backend
{

    /**
     * Auto-generate the screencast alias if it has not been set yet
     *
     * @param mixed
     * @param object
     *
     * @return string
     */
    public function generateAlias($varValue, DataContainer $dc)
    {
        $autoAlias = false;

        // Generate alias if there is none
        if (!strlen($varValue)) {
            $autoAlias = true;
            $varValue  = standardize($dc->activeRecord->title);
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_kjg_proben_archive WHERE alias=?")
            ->execute($varValue);

        // Check whether the news alias exists
        if ($objAlias->numRows > 1 && !$autoAlias) {
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
        }

        // Add ID to alias
        if ($objAlias->numRows && $autoAlias) {
            $varValue .= '-' . $dc->id;
        }

        return $varValue;
    }

    /**
     * Auto-generate the slots
     *
     * @param object
     */
    public function generateProbe(DataContainer $dc)
    {
        // Return if there is no active record (override all)
        if (!$dc->activeRecord) {
            return;
        }

        switch ($dc->activeRecord->interv) {
            case 30:
                $int = 1800;
                break;
            case 60:
                $int = 3600;
                break;
            case 90:
                $int = 5400;
                break;
            case 120:
                $int = 7200;
                break;
        }
        ;

        $von = strtotime(date('d.m.Y', $dc->activeRecord->slotdate) . ' ' . date('H:i:s', $dc->activeRecord->slotstart));
        $bis = $von + $int;

        if (substr(date('H:i:s', $dc->activeRecord->slotend), 0, 1) == '0') {
            $dc->activeRecord->slotdate += 86400;
        }

        $ende = strtotime(date('d.m.Y', $dc->activeRecord->slotdate) . ' ' . date('H:i:s', $dc->activeRecord->slotend));

        $sorting = 1;

        while ($bis <= $ende) {
            $slot = date('H:i', $von) . ' - ' . date('H:i', $bis);

            $arrSet['pid']       = $dc->id;
            $arrSet['sorting']   = $sorting;
            $arrSet['title']     = $slot;
            $arrSet['tstamp']    = time();
            $arrSet['gruppe']    = '';
            $arrSet['sprecher']  = '';
            $arrSet['music']     = '';
            $arrSet['info']      = '';
            $arrSet['published'] = 1;

            $this->Database->prepare("INSERT INTO tl_kjg_proben %s")->set($arrSet)->execute();

            $von = $von + $int;
            $bis = $bis + $int;
            $sorting++;
        }
    }

    /**
     * Adjust start end end time of the event based on date, span, startTime and endTime
     *
     * @param object
     */
    public function adjustTime(DataContainer $dc)
    {
        $slotdate = 0;

        // Return if there is no active record (override all)
        if (!$dc->activeRecord) {
            return;
        }

        $arrSet['slotdate']  = strtotime(date('d.m.Y', $dc->activeRecord->slotdate) . ' ' . date('H:i:s', $dc->activeRecord->slotstart));
        $arrSet['slotstart'] = $arrSet['slotdate'];

        if (substr(date('H:i:s', $dc->activeRecord->slotend), 0, 1) == '0') {
            $slotdate += 86400;
        }

        $slotdate          = strtotime(date('d.m.Y', $dc->activeRecord->slotdate) . ' ' . date('H:i:s', $dc->activeRecord->slotend));
        $arrSet['slotend'] = $slotdate;

        $this->Database->prepare("UPDATE tl_kjg_proben_archive %s WHERE id=?")->set($arrSet)->execute($dc->id);
    }
}