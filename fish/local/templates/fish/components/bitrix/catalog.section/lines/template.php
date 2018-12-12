<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$CurPage = $APPLICATION->GetCurDir(true);
?>
<div class="row">
    <? foreach ($arResult["ITEMS"] as $cell => $arElement):
        $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

        $id = $arElement['ID'];
        $dbDelayItems = CSaleBasket::GetList(
            array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "PRODUCT_ID" => $id,
                "ORDER_ID" => "NULL"
            ),
            false,
            false,
            array("PRODUCT_ID", "DELAY")
        );

        $renderImage = CFile::ResizeImageGet($arElement["DETAIL_PICTURE"], Array("width" => 150, "height" => 150), BX_RESIZE_IMAGE_PROPORTIONAL, false);
        ?>
        <div class="col-xs-12" id="<?= $this->GetEditAreaId($arElement['ID']); ?>">
                <a href="<? echo $arElement["DETAIL_PAGE_URL"] ?>" title="<?= $arElement["NAME"] ?>">



                    <!-- Картинка -->
                    <span class="images">
                        <? if (strlen($arElement["DETAIL_PICTURE"]["SRC"]) !== 0) { ?>
                            <img class="img-responsive" src="<?=$renderImage['src'];?>" alt="<?=$arElement['NAME']?>"/>
                        <? } else { ?>
                            <img class="img-responsive" src="/local/images/no_foto.jpg" alt="<?=$arElement['NAME']?>"/>
                        <? } ?>
                    </span>



                    <!-- Свойства -->
                    <small>
                        <? foreach ($arResult["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>
                            <? echo $arProperty["DISPLAY_VALUE"]; ?>
                        <? endforeach ?>
                    </small>



                    <!-- Название -->
                    <h5 class="titleitem">
                        <?= $arElement["NAME"];?>
                    </h5>
                </a>



                <!-- Цены -->
                <? foreach ($arElement["PRICES"] as $code => $arPrice): ?>
                    <? if ($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]): ?>
                        <strong><s><?= $arPrice["PRINT_VALUE"] ?></s>
                        <?= $arPrice["PRINT_DISCOUNT_VALUE"] ?></strong>
                    <? else: ?>
                        <strong><?= $arPrice["PRINT_VALUE"] ?></strong>
                    <? endif; ?>
                <? endforeach; ?>



                <!-- Добавление в отложенные -->
                <div class="add_buttons">
                    <a href="javascript:void(0)" rel="nofollow" class="wish_fav
                       <?
                        if ((in_array($arElement["ID"], $delaydBasketItems)) || (isset($itInDelay))) {
                            echo 'in_wish';
                        }
                        ?>"
                       onclick="add2wish<? echo $arElement['ID']; ?>('<?= $arElement["ID"] ?>','<?= $arElement["CATALOG_PRICE_ID_1"] ?>','<?= $arElement["CATALOG_PRICE_1"] ?>','<?= $arElement["NAME"] ?>','<?= $arElement["DETAIL_PAGE_URL"] ?>',this)">
                        <span></span>
                    </a>
                </div>



                <!-- Добавление в корзину -->
                    <form action="<?= POST_FORM_ACTION_URI ?>" method="post" enctype="multipart/form-data" class="add_form">
                        <input type="text" name="QUANTITY" value="1" size="5" style="display: none;">
                        <input type="hidden" name="<? echo $arParams["ACTION_VARIABLE"] ?>" value="BUY">
                        <input type="hidden" name="<? echo $arParams["PRODUCT_ID_VARIABLE"] ?>" value="<? echo $arElement["ID"] ?>">
                        <input type="submit" name="<? echo $arParams["ACTION_VARIABLE"] . "BUY" ?>" value="<? echo GetMessage("CATALOG_BUY") ?>" style="display: none;">
                        <input type="submit" name="<? echo $arParams["ACTION_VARIABLE"] . "ADD2BASKET" ?>"
                               <? if (isset($itInBasket)) { ?>value="В корзине"
                               <? } else { ?>value="В корзину"<? } ?>
                               onclick="if (this.value == ' В корзину') this.value = 'В корзине';"
                               class="btn btn-success">
                    </form>

        </div>
        <?
        unset($itInBasket);
        unset($itInDelay);
    endforeach; ?>
</div>
<? if ( (CSite::InDir('/catalog/')) || (CSite::InDir('/search/')) ) { //Если каталог или поиск?>
    <?= $arResult["NAV_STRING"] ?>
<?}?>





