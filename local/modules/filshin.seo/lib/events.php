<?php

namespace Filshin\Seo;

use \Bitrix\Main\Config\Option;

class Events
{
    public function changeSeoParams()
    {
        global $APPLICATION;
        $elementPage = false;

        $sCurrentLink = $APPLICATION->GetCurPage();
        $arCurrentLink = array_diff(explode('/', $sCurrentLink), ['']);
        if ($arCurrentLink[1] == 'catalog' && count($arCurrentLink) > 2) {
            $elementPage = true;
        }

        if ($elementPage) {
            $header = $APPLICATION->GetPageProperty("title");
            $title = $APPLICATION->GetTitle();

            $arTitle = Helper::getTitleOptions();
            $arHeader = Helper::getHeaderOptions();

            $APPLICATION->SetTitle($arHeader['START'] . ' ' . $title . ' ' . $arHeader['END']);
            $APPLICATION->SetPageProperty('title', $arTitle['START'] . ' ' . $header . ' ' . $arTitle['END']);
        }
    }
}