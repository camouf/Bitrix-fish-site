<?
$APPLICATION->IncludeComponent(
    "bitrix:news.line",
    "slider",
    array(
        "IBLOCK_TYPE" => "Sale",
        "IBLOCKS" => array(
            0 => "6",
        ),
        "NEWS_COUNT" => "5",
        "FIELD_CODE" => array(
            0 => "NAME",
            1 => "PREVIEW_TEXT",
            2 => "PREVIEW_PICTURE",
            3 => "DETAIL_TEXT",
            4 => "",
        ),
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "SORT",
        "SORT_ORDER2" => "ASC",
        "DETAIL_URL" => "",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "300",
        "CACHE_NOTES" => "",
        "CACHE_GROUPS" => "Y",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "COMPONENT_TEMPLATE" => "slider"
    ),
    false
); ?>