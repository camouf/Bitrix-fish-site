<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>


<? //echo '<pre>'; print_r($arResult); echo '</pre>';?>



<? if (count($arResult) > 0) { ?>
    <div class="footer_comapare_wish hidden-xs">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="compare_list">
                        <h6>Сравнение товаров</h6>
                        <i><?= (count($arResult)) ?></i>
                        <? // if (count($arResult) >= 2): ?>
                        <form action="<?= $arParams["COMPARE_URL"] ?>" method="get">
                            <input class="to_compare" type="submit" value="&#xf080; &nbsp; Сравнить"/>
                            <input type="hidden" name="action" value="COMPARE"/>
                            <input type="hidden" name="IBLOCK_ID" value="Перейти в список"/>
                        </form>
                        <? // endif; ?>



                        <a href="#" class="trigger_4">
                            <span class="fa">&#xf095;</span>
                            &nbsp;
                            Нужна консультация?
                        </a>

                        <?
                        foreach ($arResult as $arElement) {
                            ?>
                            <a href="<?= $curPage ?>?action=DELETE_FROM_COMPARE_LIST&id=0" rel="nofollow" class="clear_up" title="очистить список">Очистить список</a>
                            <?
                            break;
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="clb"></div>
    </div>
<? } ?>

<? /*if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


$itemCount = count($arResult);
$needReload = (isset($_REQUEST["compare_list_reload"]) && $_REQUEST["compare_list_reload"] == "Y");
$idCompareCount = 'compareList'.$this->randString();
$obCompare = 'ob'.$idCompareCount;
$idCompareTable = $idCompareCount.'_tbl';
$idCompareRow = $idCompareCount.'_row_';
$idCompareAll = $idCompareCount.'_count';
$mainClass = 'bx_catalog-compare-list';
if ($arParams['POSITION_FIXED'] == 'Y')
{
    $mainClass .= ' fix '.($arParams['POSITION'][0] == 'bottom' ? 'bottom' : 'top').' '.($arParams['POSITION'][1] == 'right' ? 'right' : 'left');
}
$style = ($itemCount == 0 ? ' style="display: none;"' : '');
?><div id="<? echo $idCompareCount; ?>" class="<? echo $mainClass; ?> "<? echo $style; ?>><?
    unset($style, $mainClass);
    if ($needReload)
    {
        $APPLICATION->RestartBuffer();
    }
    $frame = $this->createFrame($idCompareCount)->begin('');
    ?><div class="bx_catalog_compare_count"><?
        if ($itemCount > 0)
        {
            ?><p><? echo GetMessage('CP_BCCL_TPL_MESS_COMPARE_COUNT'); ?>&nbsp;<span id="<? echo $idCompareAll; ?>"><? echo $itemCount; ?></span></p>
            <p class="compare-redirect"><a href="<? echo $arParams["COMPARE_URL"]; ?>"><? echo GetMessage('CP_BCCL_TPL_MESS_COMPARE_PAGE'); ?></a></p><?
        }
        ?></div><?
    if (!empty($arResult))
    {
        ?><div class="bx_catalog_compare_form">
        <table id="<? echo $idCompareTable; ?>" class="compare-items">
            <thead><tr><td align="center" colspan="2"><?=GetMessage("CATALOG_COMPARE_ELEMENTS")?></td></tr></thead>
            <tbody><?
            foreach($arResult as $arElement)
            {
                ?><tr id="<? echo $idCompareRow.$arElement['PARENT_ID']; ?>">
                <td><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></td>
                <td><noindex><a href="javascript:void(0);"  data-id="<? echo $arElement['PARENT_ID']; ?>" rel="nofollow"><?=GetMessage("CATALOG_DELETE")?></a></noindex></td>
                </tr><?
            }
            ?>
            </tbody>
        </table>
        </div><?
    }
    $frame->end();
    if ($needReload)
    {
        die();
    }
    $currentPath = CHTTP::urlDeleteParams(
        $APPLICATION->GetCurPageParam(),
        array(
            $arParams['PRODUCT_ID_VARIABLE'],
            $arParams['ACTION_VARIABLE'],
            'ajax_action'
        ),
        array("delete_system_params" => true)
    );

    $jsParams = array(
        'VISUAL' => array(
            'ID' => $idCompareCount,
        ),
        'AJAX' => array(
            'url' => $currentPath,
            'params' => array(
                'ajax_action' => 'Y'
            ),
            'reload' => array(
                'compare_list_reload' => 'Y'
            ),
            'templates' => array(
                'delete' => (strpos($currentPath, '?') === false ? '?' : '&').$arParams['ACTION_VARIABLE'].'=DELETE_FROM_COMPARE_LIST&'.$arParams['PRODUCT_ID_VARIABLE'].'='
            )
        ),
        'POSITION' => array(
            'fixed' => $arParams['POSITION_FIXED'] == 'Y',
            'align' => array(
                'vertical' => $arParams['POSITION'][0],
                'horizontal' => $arParams['POSITION'][1]
            )
        )
    );
    ?></div>
<script type="text/javascript">
    var <? echo $obCompare; ?> = new JCCatalogCompareList(<? echo CUtil::PhpToJSObject($jsParams, false, true); ?>)
</script>
*/ ?>
