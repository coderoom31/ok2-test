<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

global $APPLICATION;

if (!empty($templateData['TEMPLATE_LIBRARY'])) {
    $loadCurrency = false;

    if (!empty($templateData['CURRENCIES'])) {
        $loadCurrency = Loader::includeModule('currency');
    }

    CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
    if ($loadCurrency) {
        ?>
        <script>
            BX.Currency.setCurrencies(<?=$templateData['CURRENCIES']?>);
        </script>
        <?
    }
}

if (isset($templateData['JS_OBJ'])) {
    ?>
    <script>
        BX.ready(BX.defer(function () {
            if (!!window.<?=$templateData['JS_OBJ']?>) {
                window.<?=$templateData['JS_OBJ']?>.allowViewedCount(true);
            }
        }));
    </script>

    <?
    // check compared state
    if ($arParams['DISPLAY_COMPARE']) {
        $compared = false;
        $comparedIds = array();
        $item = $templateData['ITEM'];

        if (!empty($_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']])) {
            if (!empty($item['JS_OFFERS'])) {
                foreach ($item['JS_OFFERS'] as $key => $offer) {
                    if (array_key_exists($offer['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS'])) {
                        if ($key == $item['OFFERS_SELECTED']) {
                            $compared = true;
                        }

                        $comparedIds[] = $offer['ID'];
                    }
                }
            } elseif (array_key_exists($item['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS'])) {
                $compared = true;
            }
        }

        if ($templateData['JS_OBJ']) {
            ?>
            <script>
                BX.ready(BX.defer(function () {
                    if (!!window.<?=$templateData['JS_OBJ']?>) {
                        window.<?=$templateData['JS_OBJ']?>.setCompared('<?=$compared?>');

                        <? if (!empty($comparedIds)): ?>
                        window.<?=$templateData['JS_OBJ']?>.setCompareInfo(<?=CUtil::PhpToJSObject($comparedIds, false, true)?>);
                        <? endif ?>
                    }
                }));
            </script>
            <?
        }
    }

    // select target offer
    $request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
    $offerNum = false;
    $offerId = (int)$this->request->get('OFFER_ID');
    $offerCode = $this->request->get('OFFER_CODE');

    if ($arResult['OFFER_NUM'] > 0) {
        $offerId = $arResult['OFFER_NUM'];
    }

    if ($offerId > 0 && !empty($templateData['OFFER_IDS']) && is_array($templateData['OFFER_IDS'])) {
        $offerNum = array_search($offerId, $templateData['OFFER_IDS']);
    } elseif (!empty($offerCode) && !empty($templateData['OFFER_CODES']) && is_array($templateData['OFFER_CODES'])) {
        $offerNum = array_search($offerCode, $templateData['OFFER_CODES']);
    }

    if (!empty($offerNum)) {
        ?>
        <script>
            BX.ready(function () {
                if (!!window.<?=$templateData['JS_OBJ']?>) {
                    window.<?=$templateData['JS_OBJ']?>.setOffer(<?=$offerNum?>);
                }
            });
        </script>
        <?
    }
}

if ($arResult['HAS_COLOR'] === false) {
    if (!defined("ERROR_404"))
        define("ERROR_404", "Y");

    \CHTTP::setStatus("404 Not Found");

    if ($APPLICATION->RestartWorkarea()) {
        require(\Bitrix\Main\Application::getDocumentRoot() . "/404.php");
        die();
    }
}