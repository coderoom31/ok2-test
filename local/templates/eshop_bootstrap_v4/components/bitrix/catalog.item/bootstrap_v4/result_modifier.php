<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if(isset($arResult['ITEM']['OFFERS'][0]['PROPERTIES']['COLOR_REF']['VALUE'])) {
    $arResult['ITEM']['DETAIL_PAGE_URL'] .= $arResult['ITEM']['OFFERS'][0]['PROPERTIES']['COLOR_REF']['VALUE'].'/';
}
