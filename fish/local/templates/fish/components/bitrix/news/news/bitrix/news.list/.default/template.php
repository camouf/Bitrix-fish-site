<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
    <? foreach ($arResult["ITEMS"] as $arItem):
        $renderImage = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array("width" => 250, "height" => 250), BX_RESIZE_IMAGE_EXACT, false);
        ?>
            <div class="news_item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>">
                    <h4><? echo $arItem["NAME"]; ?></h4>
                    <span class="info">
                        <i>&#xf073;</i>
                        <?
                        $arParams["DATE_CREATE"] = "j F Y";
                        echo CIBlockFormatProperties::DateFormat($arParams["DATE_CREATE"], MakeTimeStamp($arItem["DATE_CREATE"], CSite::GetDateFormat()));
                        ?>
                        <i>&#xf0e6;</i> 6 комментариев
                    </span>
                    <? echo $arItem["PREVIEW_TEXT"]; ?>
                    <div class="clb"></div>
                </a>
            </div>
    <? endforeach; ?>
<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <br/><?= $arResult["NAV_STRING"] ?>
<? endif; ?>

