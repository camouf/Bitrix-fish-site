<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Персональные данные");
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:main.profile", 
	"",
	array(
		"CHECK_RIGHTS" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"SEND_INFO" => "N",
		"SET_TITLE" => "Y",
		"USER_PROPERTY" => array(
			0 => "UF_STREET",
			1 => "UF_HOME",
			2 => "UF_CORP",
			3 => "UF_FLL",
		),
		"USER_PROPERTY_NAME" => "",
		"COMPONENT_TEMPLATE" => "user"
	),
	false
);?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>