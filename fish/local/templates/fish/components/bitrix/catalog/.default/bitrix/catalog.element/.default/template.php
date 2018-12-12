<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$id = $arResult['ID'];
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
while ($arItemsDelay = $dbDelayItems->Fetch()) {
    if ($arItemsDelay['DELAY'] === 'Y') {
        $itInDelay = 'Yes';
    } else {
        $itInBasket = $arItemsDelay['PRODUCT_ID'];
    }
}
$iblockid = $arResult['IBLOCK_ID'];
if (isset($_SESSION["CATALOG_COMPARE_LIST"][$iblockid]["ITEMS"][$id])) {
    $checked = 'checked';
} else {
    $checked = '';
}
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

    function compare_tov(id) {
        var chek = document.getElementById('compareid_' + id);
        if (chek.checked) {
            //Добавить
            var AddedGoodId = id;
            $.get("/local/ajax/list_compare.php",
                {
                    action: "ADD_TO_COMPARE_LIST", id: AddedGoodId
                },
                function (data) {
                    $("#compare_list_count").html(data);
                }
            );
        }
        else {
            //Удалить
            var AddedGoodId = id;
            $.get("/local/ajax/list_compare.php",
                {
                    action: "DELETE_FROM_COMPARE_LIST", id: AddedGoodId
                },
                function (data) {
                    $("#compare_list_count").html(data);
                }
            );
        }
    }
</script>

<div class="row" itemscope itemtype="http://schema.org/Product">

    <!-- Картинки товара -->
    <div class="col-lg-4 fotos">
        <? if (strlen($arResult["DETAIL_PICTURE"]["SRC"]) !== 0) { ?>
            <a href="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>" data-fancybox="images" data-caption="<?= $arResult["NAME"] ?>">
                <img itemprop="image" src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>" alt="<?= $arResult["NAME"] ?>"/>
            </a>
        <? } else { ?>
            <a href="/local/images/nf_f.jpg" data-fancybox="images"
               data-caption="<?= $arResult["NAME"] ?>">
                <img width="20%" src="/local/images/nf_f.jpg" alt="<?= $arResult["NAME"] ?>"/>
            </a>
        <? } ?>
        <? if (count($arResult["MORE_PHOTO"]) > 0): ?>
            <? foreach ($arResult["MORE_PHOTO"] as $PHOTO):
                $renderImage = CFile::ResizeImageGet($PHOTO, Array("width" => 150, "height" => 150), BX_RESIZE_IMAGE_EXACT, false);
                ?>
                <a href="<?= $PHOTO["SRC"] ?>" data-fancybox="images" data-caption="<?= $arResult["NAME"] ?>">
                    <img src="<?= $renderImage["src"] ?>" alt="<?= $arResult["NAME"] ?>"/>
                </a>
            <? endforeach ?>
        <? endif ?>
        <div class="clb"></div>
    </div>


    <!-- Информация о товаре -->
    <div class="col-lg-4 info_detail">
        <!-- Добавление в избранное и сравнение -->
        <div class="wish_compare">
            <noindex>
                <a href="javascript:void(0)" rel="nofollow" <? if ((in_array($arResult["ID"], $delaydBasketItems)) || (isset($itInDelay))) {echo 'class="in_wishlist"';} ?> onclick="add2wish('<?= $arResult["ID"] ?>','<?= $arResult["CATALOG_PRICE_ID_1"] ?>','<?= $arResult["CATALOG_PRICE_1"] ?>','<?= $arResult["NAME"] ?>','<?= $arResult["DETAIL_PAGE_URL"] ?>',this)">
                    <strong class="st1"><span class="fa">&#xf08a;</span> В избранное</strong>
                    <strong class="st2"><span class="fa">&#xf004;</span> В избранном</strong>
                </a>
                <input class="to_compare_inp" <?= $checked; ?> type="checkbox" id="compareid_<?= $arResult['ID']; ?>" onchange="compare_tov(<?= $arResult['ID']; ?>);">
                <label for="compareid_<?= $arResult['ID']; ?>">
                    <strong class="st1"><span class="fa">&#xf080;</span> В сравнение</strong>
                    <strong class="st2"><span class="fa">&#xf080;</span> В сравнении</strong>
                </label>
            </noindex>
        </div>
        <!-- Свойства товара (отображаемые в настройках компонента) -->
        <ul>
            <? foreach ($arResult["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>
                <li>
                    <strong>
                        <?= TruncateText($arProperty["NAME"], 25);?>
                    </strong>
                    <span><? echo $arProperty["DISPLAY_VALUE"]; ?></span>
                </li>
            <? endforeach ?>
        </ul>
    </div>


    <div class="col-lg-4" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
        <div class="user_block">
            <? foreach ($arResult["PRICES"] as $code => $arPrice): ?>
                <span itemprop="price"><?= $arPrice["PRINT_VALUE"] ?></span>
                <span itemprop="priceCurrency">RUB</span>
            <? endforeach; ?>
            <form action="<?= POST_FORM_ACTION_URI ?>" method="post" enctype="multipart/form-data" class="add_form">
                <a href="javascript:void(0)" class="minus" onclick="if (BX('QUANTITY<?= $arElement['ID'] ?>').value &gt; 1) BX('QUANTITY<?= $arElement['ID'] ?>').value--;">-</a>
                <input type="text" min="1" max="<? echo $arResult['CATALOG_QUANTITY']; ?>" name="QUANTITY" value="1" id="QUANTITY<?= $arElement['ID'] ?>"/>
                <a href="javascript:void(0)" class="plus" onclick="BX('QUANTITY<?= $arElement['ID'] ?>').value++;">+</a>
                <input type="hidden" name="<? echo $arParams["ACTION_VARIABLE"] ?>" value="BUY">
                <input type="hidden" name="<? echo $arParams["PRODUCT_ID_VARIABLE"] ?>" value="<? echo $arResult["ID"] ?>">
                <input style="display: none;" type="submit" name="<? echo $arParams["ACTION_VARIABLE"] . "BUY" ?>" value="<? echo GetMessage("CATALOG_BUY") ?>">
                <input class="btn btn-danger" type="submit" name="<? echo $arParams["ACTION_VARIABLE"] . "ADD2BASKET" ?>" value="<? echo GetMessage("CATALOG_ADD_TO_BASKET") ?>">
            </form>
        </div>
    </div>

</div>


<div class="row">
    <div class="col-lg-12">
        <div class="detail_text">
            <?= $arResult["DETAIL_TEXT"] ?>
        </div>
    </div>
</div>