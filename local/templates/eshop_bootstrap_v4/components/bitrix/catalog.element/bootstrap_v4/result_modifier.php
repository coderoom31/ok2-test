<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$cp = $this->__component;

if (isset($arParams['COLOR_CODE'])) {
    $bHasColor = false;
    $sColorName = '';

    foreach ($arResult['SKU_PROPS']['COLOR_REF']['VALUES'] as $arColor) {
        if ($arColor['XML_ID'] == $arParams['COLOR_CODE']) {
            $bHasColor = true;
            $sColorName = $arColor['NAME'];
        }
    }
    if (!$bHasColor) {
        $arResult['HAS_COLOR'] = false;

        if (is_object($cp)) {
            $cp->arResult['HAS_COLOR'] = $arResult['HAS_COLOR'];
            $cp->SetResultCacheKeys(array('HAS_COLOR'));
        }
    } else {
        $arResult['META_TAGS']['TITLE'] .= ' ' . $sColorName;
        $arResult['META_TAGS']['BROWSER_TITLE'] .= ' ' . $sColorName;

        // TODO выбор правильного цвета в JS
        $offerNum = 1;

        foreach ($arResult['JS_OFFERS'] as $arJsOffer) {

        }
        echo '<pre>';
        //print_r($arResult['JS_OFFERS']);
        //print_r($arResult['SKU_PROPS']['COLOR_REF']['ID']);
        //print_r($arResult['SKU_PROPS']['COLOR_REF']['VALUES']);
        echo '</pre>';
    }
}