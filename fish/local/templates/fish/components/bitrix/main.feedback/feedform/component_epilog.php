
<div class="col-sm-6">
<?$APPLICATION->IncludeComponent(
    "bitrix:map.yandex.view",
    "",
    Array(
        "CONTROLS" => array("ZOOM", "MINIMAP", "TYPECONTROL", "SCALELINE"),
        "INIT_MAP_TYPE" => "MAP",
        "MAP_DATA" => "a:3:{s:10:\"yandex_lat\";s:7:\"55.7383\";s:10:\"yandex_lon\";s:7:\"37.5946\";s:12:\"yandex_scale\";i:10;}",
        "MAP_HEIGHT" => "450",
        "MAP_ID" => "",
        "MAP_WIDTH" => "100%",
        "OPTIONS" => array("ENABLE_SCROLL_ZOOM", "ENABLE_DBLCLICK_ZOOM", "ENABLE_DRAGGING")
    )
);?>
</div>


<div class="clb"></div>