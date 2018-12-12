<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$CurPage = $APPLICATION->GetCurDir(true);
?>
<div class="row">
    <? foreach ($arResult["ITEMS"] as $cell => $arElement):
        $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        $renderImage = CFile::ResizeImageGet($arElement["DETAIL_PICTURE"], Array("width" => 150, "height" => 150), BX_RESIZE_IMAGE_PROPORTIONAL, false);
        ?>

        <script>
            function add2wish(p_id, pp_id, p, name, dpu, th) {
                $.ajax({
                    type: "POST",
                    url: "/local/ajax/wishlist.php",
                    data: "p_id=" + p_id + "&pp_id=" + pp_id + "&p=" + p + "&name=" + name + "&dpu=" + dpu,
                    success: function (html) {
                        $(th).addClass('in_wishlist');
                        $('#wishcount').html(html);
                    }
                });
            };
        </script>



        <div class="col-md-3 col-sm-4 col-xs-6" id="<?= $this->GetEditAreaId($arElement['ID']); ?>">
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


                <!-- Добавление в корзину -->
                    <form action="<?= POST_FORM_ACTION_URI ?>" method="post" enctype="multipart/form-data" class="add_form">
                        <input type="text" name="QUANTITY" value="1" size="5" style="display: none;">
                        <input type="hidden" name="<? echo $arParams["ACTION_VARIABLE"] ?>" value="BUY">
                        <input type="hidden" name="<? echo $arParams["PRODUCT_ID_VARIABLE"] ?>" value="<? echo $arElement["ID"] ?>">
                        <input type="submit" name="<? echo $arParams["ACTION_VARIABLE"] . "BUY" ?>" value="<? echo GetMessage("CATALOG_BUY") ?>" style="display: none;">
                        <input type="submit" name="<? echo $arParams["ACTION_VARIABLE"] . "ADD2BASKET" ?>" value="В корзину" class="btn btn-success">
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





