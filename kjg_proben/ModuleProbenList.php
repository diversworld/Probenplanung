<?php

/**
 * @copyright  Eckhard Becker 2012
 * @author     Eckhard Becker
 * @package    Language
 * @license    GNU
 * @filesource
 **/

class ModuleProbenList extends Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_kjg_proben_list';
    protected $strEditTemplate = 'mod_proben_edit';

    public static $strDetailKey = 'ins';
    public static $strViewKey = 'vie';
    public static $strDeleteKey = 'del';

    /**
     * Generate the currenbt element
     */
    public function generate()
    {
        return parent::generate();
    }

    /**
     * Compile the currenbt element
     */
    protected function compile()
    {
        $parUri = '';

        $this->log('Detail: ' . $parUri . ' - ' . $this->Input->get(self::$strDetailKey), 'compile()', 'Probenplan');
        $this->log('Delete: ' . $parUri . ' - ' . $this->Input->get(self::$strDeleteKey), 'compile()', 'Probenplan');
        $this->log('View  : ' . $parUri . ' - ' . $this->Input->get(self::$strViewKey), 'compile()', 'Probenplan');

        if ($this->Input->get(self::$strDetailKey)) {
            $parUri = 'ins';
        }
        if ($this->Input->get(self::$strDeleteKey)) {
            $parUri = 'del';
        }
        if ($this->Input->get(self::$strViewKey)) {
            $parUri = 'view';
        }
        if (!$this->Input->get(self::$strDetailKey) && !$this->Input->get(self::$strDeleteKey) && !$this->Input->get(self::$strViewKey)) {
            $parUri = '';
        }

        $this->log('parUri: ' . $parUri . ' - ' . $this->Input->get(self::$strDetailKey), 'compile()', 'Probenplan');

        switch ($parUri) {
            case 'ins':
                $this->compileEditTemplate();
                break;
            case 'del':
                $this->compileDeleteData($this->Input->get(self::$strDeleteKey));
                $this->compileListTemplate();
                break;
            case 'vie':
                $this->compileViewTemplate();
                break;
            default:
                $this->compileListTemplate();
                break;
        }

    }

    /**
     * Module List
     */
    protected function compileListTemplate()
    {
        $this->Template = new FrontendTemplate($this->strTemplate);

        $time = time();

        $objProbe = Database::getInstance()
            ->prepare('SELECT s.*, a.title AS `archive`, m.lastname, m.firstname
                       FROM tl_kjg_proben s
                       INNER JOIN tl_kjg_proben_archive a
                       ON a.id = s.pid
                       LEFT JOIN tl_member m
                       On m.id = s.sprecher
                       WHERE s.pid=?
                       AND a.published=?
                       AND (a.start=? OR a.start<?)
                       AND (a.stop=? OR a.stop>?)
                       AND s.published=?
                       AND (s.start=? OR s.start<?)
                       AND (s.stop=? OR s.stop>?)')
            ->execute($this->kjg_proben_archives, 1, '', $time, '', $time, 1, '', $time, '', $time);

        $this->Template->probe = $objProbe->fetchAllAssoc();
    }

    /**
     * Module Edit
     *
     */
    protected function compileEditTemplate()
    {
        $this->Template = new FrontendTemplate($this->strEditTemplate);

        $arrFields = array();
        $arrDaten  = array();

        $arrDaten  = $this->getData($this->Input->get(self::$strDetailKey));
        $arrMember = $this->getMemberNames();

        $arrFields['id']       = array
        (
            'name'      => 'id',
            'label'     => $GLOBALS['TL_LANG']['MSC']['id'],
            'inputType' => 'text',
            'value'     => $arrDaten['id'],
            'eval'      => array('hideInput' => true)
        );
        $arrFields['slotdate'] = array
        (
            'name'      => 'slotdate',
            'label'     => $GLOBALS['TL_LANG']['MSC']['slotdate'],
            'inputType' => 'text',
            'value'     => $arrDaten['slotdate'],
            'eval'      => array('readonly' => true)
        );
        $arrFields['title']    = array
        (
            'name'      => 'slot',
            'label'     => $GLOBALS['TL_LANG']['MSC']['title'],
            'inputType' => 'text',
            'value'     => $arrDaten['title'],
            'eval'      => array('mandatory' => true)
        );
        $arrFields['gruppe']   = array
        (
            'name'      => 'gruppe',
            'label'     => $GLOBALS['TL_LANG']['MSC']['gruppe'],
            'inputType' => 'text',
            'value'     => $arrDaten['gruppe'],
            'eval'      => array('mandatory' => true, 'maxlength' => 60)
        );
        $arrFields['sprecher'] = array
        (
            'name'      => 'sprecher',
            'label'     => $GLOBALS['TL_LANG']['MSC']['sprecher'],
            'flag'      => 11,
            'inputType' => 'select',
            'options'   => $arrMember,
            'value'     => $arrDaten['sprecher'],
            'eval'      => array('mandatory' => true, 'includeBlankOption' => false)
        );
        $arrFields['music']    = array
        (
            'name'      => 'music',
            'label'     => $GLOBALS['TL_LANG']['MSC']['music'],
            'inputType' => 'textarea',
            'value'     => $arrDaten['music'],
            'eval'      => array('maxlength' => 255)
        );
        $arrFields['info']     = array
        (
            'name'      => 'info',
            'label'     => $GLOBALS['TL_LANG']['MSC']['info'],
            'inputType' => 'textarea',
            'value'     => $arrDaten['info'],
            'eval'      => array('maxlength' => 255)
        );

        $doNotSubmit = false;
        $arrWidgets  = array();

        // Initialize widgets
        foreach ($arrFields as $arrField) {
            // FFL = Form Field
            $strClass = $GLOBALS['TL_FFL'][$arrField['inputType']];

            $arrField['eval']['required'] = $arrField['eval']['mandatory'];
            $objWidget                    = new $strClass($this->prepareForWidget($arrField, $arrField['name'], $arrField['value']));

            // Validate widget
            if ($this->Input->post('FORM_SUBMIT') == 'probenform_submit') {
                $objWidget->validate();

                if ($objWidget->hasErrors()) {
                    $doNotSubmit = true;
                }
            }

            $arrWidgets[] = $objWidget;
        }

        $this->Template->fields = $arrWidgets;
        $this->Template->submit = $GLOBALS['TL_LANG']['MSC']['probenform_submit'];
        $this->Template->cancel = $GLOBALS['TL_LANG']['MSC']['probenform_cancel'];
        $this->Template->action = ampersand($this->Environment->request);

        // Save Form Data
        if ($this->Input->post('FORM_SUBMIT') == 'probenform_submit' && !$doNotSubmit) {
            $arrSet = array
            (
                'gruppe'   => $this->Input->post('gruppe'),
                'sprecher' => $this->Input->post('sprecher'),
                'music'    => $this->Input->post('music'),
                'info'     => $this->Input->post('info'),
                'tstamp'   => time()
            );

            $this->Database->prepare("UPDATE tl_kjg_proben
			                          SET gruppe = ?, sprecher = ?, music = ?, info = ?, tstamp = ?
			                          WHERE id = ? ")
                ->execute($arrSet['gruppe'], $arrSet['sprecher'], $arrSet['music'],
                $arrSet['info'], $arrSet['tstamp'], $this->Input->post('id')
            );

            $this->log('Form-Submit: ' . $arrSet['gruppe'] . '-' . $arrSet['sprecher'] . ' -- ' . $this->Input->post('id'), 'compileEditTemplate()', 'Probenplan');

            $this->compileListTemplate();
        }

        $this->Template->fields = $arrWidgets;
    }

    /**
     * Module compileDeleteData
     * Set the Default Value for Fields
     */
    protected function compileDeleteData($varId)
    {
        //$varId = $this->Input->get(self::$strDetailKey);
        $arrSet = array();

        $this->log('Delete ID: ' . $varId, 'DeleteData', 'Probenplan');

        $this->Database->prepare
        ("UPDATE tl_kjg_proben
		  SET gruppe = ?,
			  sprecher = ?,
			  music = ?,
			  info = ?,
			  tstamp = ?
		  WHERE id = ? ")
            ->execute('', '', '', '', $arrSet['tstamp'], $varId);
    }

    /**
     * Module getData
     * Set the Default Value for Fields
     */
    protected function getData($varID)
    {
        $arrInhalt = array();

        $objProben = $this->Database
            ->prepare("SELECT tl_kjg_proben.id, tl_kjg_proben.pid,
                              tl_kjg_proben_archive.slotdate, tl_kjg_proben.title,
                              tl_kjg_proben.gruppe, tl_kjg_proben.sprecher,
                              tl_kjg_proben.music, tl_kjg_proben.info
		               FROM tl_kjg_proben, tl_kjg_proben_archive
		               WHERE tl_kjg_proben.pid = tl_kjg_proben_archive.id
		               AND tl_kjg_proben.id = ?")->execute($varID);

        while ($objProben->next()) {
            $newArr = array
            (
                'id'       => trim($objProben->id),
                'pid'      => trim($objProben->pid),
                'slotdate' => trim(date('d.m.Y', $objProben->slotdate)),
                'title'    => trim($objProben->title),
                'gruppe'   => trim($objProben->gruppe),
                'sprecher' => trim($objProben->sprecher),
                'music'    => trim($objProben->music),
                'info'     => trim($objProben->info)
            );

            $arrInhalt[] = $newArr;
        }

        return $newArr;
    }

    /**
     * Get the Member names
     *
     **/
    protected function getMemberNames()
    {
        $arrMembers = array();

        $objMembers = $this->Database
            ->execute("SELECT id, username, firstname, lastname
			           FROM tl_member
			           WHERE login = 1"
        );

        while ($objMembers->next()) {
            $varId   = $objMembers->id;
            $varName = $objMembers->firstname . ' ' . $objMembers->lastname;

            $arrMembers[$varId] = $varName;
        }

        return $arrMembers;
    }

}

?>