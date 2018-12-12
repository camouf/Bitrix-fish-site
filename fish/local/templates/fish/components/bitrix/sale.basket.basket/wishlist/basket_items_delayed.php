<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="row wish_list">
    <?
    foreach ($arResult["GRID"]["ROWS"] as $k => $arItem) {
        if ($arItem["DELAY"] == "Y") {
            ?>
            <?
//            foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
//                if (in_array($arHeader["id"]))
//                continue;
//           if ($arHeader["id"] == "NAME"):
                    //$elId = $arItem['ID'];
                    //echo '<pre>';print_r($arItem);echo '<pre>';
                    ?>

                <div class="col-lg-3 col-sm-4 col-xs-6">
                    <a class="item" href="<?=$arItem['DETAIL_PAGE_URL']?>" class="">
                        <span style="background: url(<?=$arItem['DETAIL_PICTURE_SRC']?>) center no-repeat"></span>
                        <h4><?=$arItem['NAME']?></h4>
                        <strong><?=$arItem['PRICE_FORMATED']?> Руб</strong>
                    </a>
                    <a class="del" href="<?= str_replace("#ID#", $arItem["ID"], $arUrls["delete"]) ?>">
                        Убрать из избранного
                    </a>
                </div>
                <?
 //             endif;
 //           endforeach;
        }
    }
    ?>
</div>