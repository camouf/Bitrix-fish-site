<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<?
if (!empty($arResult["ITEMS"])) {
    ?>
<div class="you_view">
    <h5>Вы смотрели</h5>
    <? foreach ($arResult["ITEMS"] as $cell => $arElement):?>
        <a class="w_item" href="<?= $arElement["DETAIL_PAGE_URL"] ?>" title="Купить <?= $arElement["NAME"] ?> ">
        <div class="row">
            <div class="col-sm-4">
                <img src="<?=$arElement["DETAIL_PICTURE"]['SRC'] ?>" title="<?= $arElement['NAME']; ?>"/>
            </div>
            <div class="col-sm-8">
                <span>
                    <?= $arElement['NAME']; ?>
                </span>
                <strong>
                    <? foreach ($arElement["ITEM_PRICES"] as $code => $arPrice): ?>
                        <?= $arPrice["PRINT_BASE_PRICE"] ?>
                    <? endforeach; ?>
                </strong>
            </div>
        </div>
        </a>
    <? endforeach; ?>
</div>
<?}?>

