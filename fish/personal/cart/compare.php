<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Список сравниваемых товаров");
?>



<? $APPLICATION->IncludeComponent(
	"bitrix:catalog.compare.result", 
	"compare_table", 
	array(
		"ACTION_VARIABLE" => "action",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BASKET_URL" => "/personal/cart/",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#.php",
		"DISPLAY_ELEMENT_SELECT_BOX" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD_BOX" => "name",
		"ELEMENT_SORT_FIELD_BOX2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER_BOX" => "asc",
		"ELEMENT_SORT_ORDER_BOX2" => "desc",
		"FIELD_CODE" => array(
			0 => "DETAIL_PICTURE",
		),
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "5",
		"IBLOCK_TYPE" => "1c_catalog",
		"NAME" => "CATALOG_COMPARE_LIST",
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"PRICE_CODE" => array(
			0 => "Розничная цена",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PROPERTY_CODE" => array(
			0 => "SOSTAV",
			1 => "PREDNAZNACHENIE",
			2 => "VYSOTA_M",
			3 => "DOPOLNITELNYY_DEKOR",
			4 => "KONSTRUKTSIYA",
			5 => "MATERIAL",
			6 => "KOLICHESTVO_VETOK_SHT",
			7 => "DIAMETR_M",
			8 => "ZASNEZHENNAYA",
			9 => "",
		),
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "yellow",
		"USE_PRICE_COUNT" => "N",
		"COMPONENT_TEMPLATE" => "compare_table",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
); ?>

<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>