<?php

class DataContainerProben
{
    public function getProbenOptions()
    {
        $objProben = Database::getInstance()
            ->query('SELECT id, title
                     FROM tl_kjg_proben_archive
                     ORDER BY title');

        $arrOptions = array();
        while ($objProben->next()) {
            $arrOptions[$objProben->id] = $objProben->title;
        }

        return $arrOptions;
    }
}
