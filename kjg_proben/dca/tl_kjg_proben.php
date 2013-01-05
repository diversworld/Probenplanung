<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright  Eckhard Becker 2012
 * @author     Eckhard Becker
 * @package    Language
 * @license    GNU
 * @filesource
 **/

/**
 * Load tl_content language file
 */
$this->loadLanguageFile('tl_content');


/**
 * Table tl_kjg_proben
 */
$GLOBALS['TL_DCA']['tl_kjg_proben'] = array
(

    // Config
    'config'      => array
    (
        'dataContainer'    => 'Table',
        'ptable'           => 'tl_kjg_proben_archive',
        'enableVersioning' => true
    ),

    // List
    'list'        => array
    (
        'sorting'           => array
        (
            'mode'                  => 4,
            'fields'                => array('sorting'),
            'headerFields'          => array('title', 'slotdate', 'slotstart', 'slotend', 'interv'),
            'flag'                  => 11,
            'panelLayout'           => 'filter;search,limit',
            'child_record_callback' => array('tl_kjg_proben', 'listProben')
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations'        => array
        (
            'edit'   => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_kjg_proben']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif'
            ),
            'copy'   => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_kjg_proben']['copy'],
                'href'  => 'act=paste&amp;mode=copy',
                'icon'  => 'copy.gif'
            ),
            'cut'    => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_kjg_proben']['cut'],
                'href'  => 'act=paste&amp;mode=cut',
                'icon'  => 'cut.gif'
            ),
            'delete' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_kjg_proben']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_kjg_proben']['toggle'],
                'icon'            => 'visible.gif',
                'attributes'      => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => array('tl_kjg_proben', 'toggleIcon')
            ),
            'show'   => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_kjg_proben']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif'
            )
        )
    ),

    // Palettes
    'palettes'    => array
    (
        '__selector__' => array(),
        'default'      => '{title_legend},title,alias;{proben_legend},slot,gruppe,sprecher,music,info;{publish_legend},published,start,stop'
    ),

    // Subpalettes
    'subpalettes' => array
    (
        'addImage'        => 'singleSRC,alt,size,imagemargin,imageUrl,fullsize,caption,floating',
        'addEnclosure'    => 'enclosure',
        'source_internal' => 'jumpTo',
        'source_article'  => 'articleId',
        'source_external' => 'url,target'
    ),

    // Fields
    'fields'      => array
    (
        'title'     => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben']['title'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'filter'    => true,
            'flag'      => 1,
            'inputType' => 'text',
            'eval'      => array('readonly' => 'readonly', 'tl_class' => 'w50 clr')
        ),
        'alias'     => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_kjg_proben']['alias'],
            'exclude'       => true,
            'search'        => true,
            'inputType'     => 'text',
            'eval'          => array('rgxp' => 'alnum', 'unique' => true, 'spaceToUnderscore' => true, 'maxlength' => 128, 'tl_class' => 'w50'),
            'save_callback' => array
            (
                array('tl_kjg_proben', 'generateAlias')
            )
        ),
        'gruppe'    => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben']['gruppe'],
            'exclude'   => false,
            'filter'    => true,
            'sorting'   => true,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 100, 'tl_class' => 'w50')
        ),
        'sprecher'  => array
        (
            'label'      => &$GLOBALS['TL_LANG']['tl_kjg_proben']['sprecher'],
            'default'    => $this->User->id,
            'exclude'    => false,
            'filter'     => true,
            'sorting'    => true,
            'flag'       => 11,
            'inputType'  => 'select',
            'foreignKey' => 'tl_user.name',
            'eval'       => array('mandatory' => true, 'includeBlankOption' => true, 'tl_class' => 'w50')
        ),
        'music'     => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben']['music'],
            'exclude'   => false,
            'inputType' => 'textarea',
            'eval'      => array('mandatory' => false)
        ),
        'info'      => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben']['info'],
            'exclude'   => false,
            'inputType' => 'textarea',
            'eval'      => array('mandatory' => false)
        ),
        'published' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben']['published'],
            'exclude'   => true,
            'flag'      => 1,
            'inputType' => 'checkbox',
            'eval'      => array('doNotCopy' => true)
        ),
        'start'     => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben']['start'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => array('rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard')
        ),
        'stop'      => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_kjg_proben']['stop'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => array('rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard')
        )
    )
);


/**
 * Class tl_kjg_proben
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2012
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class tl_kjg_proben extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * Auto-generate the news alias if it has not been set yet
     *
     * @param mixed
     * @param DataContainer
     *
     * @return string
     */
    public function generateAlias($varValue, DataContainer $dc)
    {
        $autoAlias = false;

        // Generate alias if there is none
        if (!strlen($varValue)) {
            $autoAlias = true;
            $varValue  = standardize($this->restoreBasicEntities($dc->activeRecord->title));
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_kjg_proben WHERE alias=?")
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
     * Add the type of input field
     *
     * @param array
     *
     * @return string
     */
    public function listProben($arrRow)
    {
        $time = time();
        $key  = ($arrRow['published'] && ($arrRow['start'] == '' || $arrRow['start'] < $time) && ($arrRow['stop'] == '' || $arrRow['stop'] > $time)) ? 'published' : 'unpublished';
        $date = $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $arrRow['date']);

        return '
        <div class="cte_type ' . $key . '"><strong>' . $arrRow['title'] . '</strong></div>
        <div class="limit_height block">' . ($arrRow['gruppe']) . ' - ' . ($arrRow['sprecher']) . '</div>' . "\n";
    }


    /**
     * Return the "toggle visibility" button
     *
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     *
     * @return string
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen($this->Input->get('tid'))) {
            $this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 1));
            $this->redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_kjg_proben::published', 'alexf')) {
            return '';
        }

        $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['published'] ? '' : 1);

        if (!$row['published']) {
            $icon = 'invisible.gif';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
    }


    /**
     * Disable/enable a user group
     *
     * @param integer
     * @param boolean
     */
    public function toggleVisibility($intId, $blnVisible)
    {
        // Check permissions to edit
        $this->Input->setGet('id', $intId);
        $this->Input->setGet('act', 'toggle');
        $this->checkPermission();

        // Check permissions to publish
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_kjg_proben::published', 'alexf')) {
            $this->log('Not enough permissions to publish/unpublish news item ID "' . $intId . '"', 'tl_kjg_proben toggleVisibility', TL_ERROR);
            $this->redirect('contao/main.php?act=error');
        }

        $this->createInitialVersion('tl_kjg_proben', $intId);

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_kjg_proben']['fields']['published']['save_callback'])) {
            foreach ($GLOBALS['TL_DCA']['tl_kjg_proben']['fields']['published']['save_callback'] as $callback) {
                $this->import($callback[0]);
                $blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE tl_kjg_proben SET tstamp=" . time() . ", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
            ->execute($intId);

        $this->createNewVersion('tl_kjg_proben', $intId);

        // Update the RSS feed (for some reason it does not work without sleep(1))
        sleep(1);
        $this->import('News');
        $this->News->generateFeed(CURRENT_ID);
    }
}

?>