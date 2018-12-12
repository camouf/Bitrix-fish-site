<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("");
if (CUser::IsAuthorized()) {
    header('Location: /personal/', true, 301);
} else {
    $APPLICATION->IncludeComponent(
        "bazarow:main.register",
        "",
        Array(
            "AUTH" => "Y",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO",
            "REQUIRED_FIELDS" => array("EMAIL"),
            "SET_TITLE" => "N",
            "SHOW_FIELDS" => array("EMAIL"),
            "SUCCESS_PAGE" => "/personal/",
            "USER_PROPERTY" => array(),
            "USER_PROPERTY_NAME" => "",
            "USE_BACKURL" => "Y"
        )
    );
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>