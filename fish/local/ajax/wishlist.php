<?
//Подключаем ядро Битрикс и главный модуль
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;

//Подключаем модуль sale
Loader::includeModule("sale");

//Получаем корзину текущего пользователя
$fUserID = CSaleBasket::GetBasketUserID(True);
$fUserID = IntVal($fUserID);

//Создаем переменные для обработчика
$arFields = array(
    "PRODUCT_ID" => $_POST['p_id'],
    "PRODUCT_PRICE_ID" => $_POST['pp_id'],
    "PRICE" => $_POST['p'],
    "CURRENCY" => "RUB",
    "WEIGHT" => 0,
    "QUANTITY" => 1,
    "LID" => 's1',
    "DELAY" => "Y",
    "CAN_BUY" => "Y",
    "NAME" => $_POST['name'],
    "MODULE" => "sale",
    "NOTES" => "",
    "DETAIL_PAGE_URL" => $_POST['dpu'],
    "FUSER_ID" => $fUserID
);

//Получаем количество отложеных товаров
if (CSaleBasket::Add($arFields)) {
    $arBasketItems = array();
    $dbBasketItems = CSaleBasket::GetList(
        array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL",
            "DELAY" => "Y",
        ),
        false,
        false,
        array("PRODUCT_ID")
    );

    while ($arItems = $dbBasketItems->Fetch()){
        $arBasketItems[] = $arItems["PRODUCT_ID"];
    }

    //Загоняем отложенне в переменную
    $inwished = count($arBasketItems);
}

//Выводи количество отложенных товаров
echo $inwished;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>