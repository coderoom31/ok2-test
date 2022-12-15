<?php

namespace Filshin\Seo;

use \Bitrix\Main\Config\Option;

class Helper
{
    public static function getTitleOptions()
    {
        $arTitle = [];

        $arTitle['START'] = Option::get("filshin.seo", "titlestart");
        $arTitle['END'] = Option::get("filshin.seo", "titleend");

        return $arTitle;
    }

    public static function getHeaderOptions()
    {
        $arHeader = [];

        $arHeader['START'] = Option::get("filshin.seo", "headerstart");
        $arHeader['END'] = Option::get("filshin.seo", "headerend");

        return $arHeader;
    }
}