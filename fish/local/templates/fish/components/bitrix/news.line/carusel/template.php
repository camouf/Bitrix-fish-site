<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="list_carousel responsive">
            <ul id="news_carusel">
                <? foreach ($arResult["ITEMS"] as $arItem): ?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <li id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                        <span>
                        <?
                        $arParams["DATE_CREATE"] = "j F Y";
                        echo CIBlockFormatProperties::DateFormat($arParams["DATE_CREATE"], MakeTimeStamp($arElement["DATE_CREATE"], CSite::GetDateFormat()));
                        ?>
                        </span>
                        <a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>">
                            <h5><? echo $arItem["NAME"] ?></h5>
                        </a>
                        <p><? echo TruncateText($arItem['PREVIEW_TEXT'], 90) ?></p>
                    </li>
                <? endforeach; ?>
            </ul>
            <a id="prev_news_carusel" class="prev fa" href="#">&#xf104;</a>
            <a id="next_news_carusel" class="next fa" href="#">&#xf105;</a>
            <a href="/news/" class="all_news">Все новости</a>
        </div>
    </div>
</div>
