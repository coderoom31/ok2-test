<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$cp = $this->__component;

foreach ($arResult['JS_OFFERS'] as $key => &$arJsOffer) {
    $arJsOffer['DETAIL_PAGE_URL'] = $arResult['DETAIL_PAGE_URL'] . $arResult['SKU_PROPS']['COLOR_REF']['VALUES'][$arJsOffer['TREE']['PROP_21']]['XML_ID'] . '/';
    $arJsOffer['HEADER'] = $arResult['META_TAGS']['TITLE'] . ' ' . $arResult['SKU_PROPS']['COLOR_REF']['VALUES'][$arJsOffer['TREE']['PROP_21']]['NAME'];
    $arJsOffer['TITLE'] = $arResult['META_TAGS']['BROWSER_TITLE'] . ' ' . $arResult['SKU_PROPS']['COLOR_REF']['VALUES'][$arJsOffer['TREE']['PROP_21']]['NAME'];
}

if (isset($arParams['COLOR_CODE'])) {
    $bHasColor = false;
    $sColorName = '';
    $iColorId = 0;

    foreach ($arResult['SKU_PROPS']['COLOR_REF']['VALUES'] as $arColor) {
        if ($arColor['XML_ID'] == $arParams['COLOR_CODE']) {
            $bHasColor = true;
            $sColorName = $arColor['NAME'];
            $sColorCode = $arParams['COLOR_CODE'];
            $iColorId = $arColor['ID'];
        }
    }
    if (!$bHasColor) {
        $arResult['HAS_COLOR'] = false;

        if (is_object($cp)) {
            $cp->arResult['HAS_COLOR'] = $arResult['HAS_COLOR'];
            $cp->SetResultCacheKeys(array('HAS_COLOR'));
        }
    } else {
        if($arResult['JS_OFFERS'][0]['TREE']['PROP_21'] != $iColorId) {
            foreach ($arResult['JS_OFFERS'] as $arJsOffer) {
                if($arJsOffer['TREE']['PROP_21'] == $iColorId){
                    $arResult['OFFER_NUM'] = $arJsOffer['ID'];
                }
            }
        }

        $arResult['META_TAGS']['TITLE'] .= ' ' . $sColorName;
        $arResult['META_TAGS']['BROWSER_TITLE'] .= ' ' . $sColorName;

        $cp->SetResultCacheKeys(array('META_TAGS', 'JS_OFFERS', 'OFFER_NUM'));
    }
} else {
    $cp->SetResultCacheKeys(array('JS_OFFERS'));
}