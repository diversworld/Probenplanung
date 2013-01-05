<?php

class ContentProbenViewer extends ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_kjg_proben_viewer';

    /**
     * Compile the current element
     */
    protected function compile()
    {
        $time = time();

        $objProben = Database::getInstance()
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
            ->execute($this->kjg_proben, 1, '', $time, '', $time, 1, '', $time, '', $time);

        $this->Template->proben = $objProben->fetchAllAssoc();
    }
}
