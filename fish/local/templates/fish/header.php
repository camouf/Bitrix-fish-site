<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
//PHP
$CurPage = $APPLICATION->GetCurDir();

use Bitrix\Main\Page\Asset;

// Определние количества отложенных (ИЗБРАННОЕ)
use Bitrix\Main\Loader;

Loader::includeModule("sale");
$delaydBasketItems = CSaleBasket::GetList(
    array(),
    array(
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "ORDER_ID" => "NULL",
        "DELAY" => "Y"
    ),
    array()
);
?>
<!doctype html>
<html lang="ru">
<head>
    <?
    $APPLICATION->ShowHead();
    // CSS
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/bootstrap.min.css');
    Asset::getInstance()->addCss('/bitrix/css/main/font-awesome.min.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/js/fancy/jquery.fancybox.min.css');
    // JS
    CJSCore::Init(array("jquery"));
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/fancy/jquery.fancybox.min.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.touchSwipe.min.js');
    //STRING
    Asset::getInstance()->addString("<meta name='viewport' content='width=device-width, initial-scale=1'>");
    ?>
    <title><? $APPLICATION->ShowTitle() ?></title>
</head>
<body>
<? $APPLICATION->ShowPanel(); ?>
<div class="top_header">
    <div class="container">
        <div class="col-lg-8 col-sm-8">
            <? // Меню - http://dev.1c-bitrix.ru/user_help/settings/settings/components_2/navigation/menu.php
            $APPLICATION->IncludeComponent("bitrix:menu", "top_menu", Array(
                "ROOT_MENU_TYPE" => "top",    // Тип меню для первого уровня
                "MENU_CACHE_TYPE" => "A",    // Тип кеширования
                "MENU_CACHE_TIME" => "3600",    // Время кеширования (сек.)
                "MENU_CACHE_USE_GROUPS" => "Y",    // Учитывать права доступа
                "MENU_CACHE_GET_VARS" => "",    // Значимые переменные запроса
                "MAX_LEVEL" => "1",    // Уровень вложенности меню
                "CHILD_MENU_TYPE" => "left",    // Тип меню для остальных уровней
                "USE_EXT" => "N",    // Подключать файлы с именами вида .тип_меню.menu_ext.php
                "DELAY" => "N",    // Откладывать выполнение шаблона меню
                "ALLOW_MULTI_SELECT" => "N",    // Разрешить несколько активных пунктов одновременно
                "COMPONENT_TEMPLATE" => ".default"
            ),
                false
            ); ?>
        </div>
        <div class="col-md-4 col-sm-4">
            <? if (CUser::IsAuthorized()) { ?>
                <a href="/personal/">В кабинет</a>
                <a href="/?logout=Y">Выйти</a>
            <? } else { ?>
                <?
                //Шаблон всплывающей формы авторизации
                $APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth", Array(
                    "FORGOT_PASSWORD_URL" => "",    // Страница забытого пароля
                    "PROFILE_URL" => "",    // Страница профиля
                    "REGISTER_URL" => "",    // Страница регистрации
                    "SHOW_ERRORS" => "N",    // Показывать ошибки
                ),
                    false
                ); ?>
                <a href="/personal/auth/registration.php">Зарегистрироваться</a>
            <? } ?>
        </div>
    </div>
</div>


<div class="container">
    <div class="row header">
        <div class="col-md-3">
            <a href="/" class="logo">
                <img src="<?= SITE_TEMPLATE_PATH; ?>/img/logo.svg" alt="">
            </a>
        </div>
        <div class="col-md-6">
            <? $APPLICATION->IncludeComponent(
                "bitrix:search.title",
                "searcher",
                array(
                    "NUM_CATEGORIES" => "1",
                    "TOP_COUNT" => "5",
                    "CHECK_DATES" => "N",
                    "SHOW_OTHERS" => "N",
                    "PAGE" => SITE_DIR . "search/",
                    "CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
                    "CATEGORY_0" => array(
                        0 => "iblock_catalog",
                    ),
                    "CATEGORY_0_iblock_catalog" => array(
                        0 => "4",
                    ),
                    "CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
                    "SHOW_INPUT" => "Y",
                    "INPUT_ID" => "title-search-input",
                    "CONTAINER_ID" => "search",
                    "PRICE_CODE" => array(
                        0 => "BASE",
                    ),
                    "SHOW_PREVIEW" => "Y",
                    "PREVIEW_WIDTH" => "75",
                    "PREVIEW_HEIGHT" => "75",
                    "CONVERT_CURRENCY" => "Y",
                    "COMPONENT_TEMPLATE" => "searcher",
                    "ORDER" => "date",
                    "USE_LANGUAGE_GUESS" => "Y",
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "CURRENCY_ID" => "RUB"
                ),
                false
            ); ?>
        </div>
        <div class="col-md-3">
            <span id="basket-container">
            <?
            //Малая AJAX корзина
            $APPLICATION->IncludeComponent(
                "bazarow:basket.small.bazarow",
                "ajax",
                Array(
                    "COMPONENT_TEMPLATE" => "ajax",
                    "PATH_TO_BASKET" => "/personal/cart",
                    "PATH_TO_ORDER" => "/personal/cart",
                    "SHOW_DELAY" => "N",
                    "SHOW_NOTAVAIL" => "Y",
                    "SHOW_SUBSCRIBE" => "Y"
                )
            ); ?>
             </span>
            <a href="/personal/cart/wish.php" class="wish_bask">
                <b>В избранном</b>
                <i id="wishcount"><? echo $delaydBasketItems; ?></i>
            </a>
        </div>
    </div>


    <?
    if ($CurPage == '/') {
        $APPLICATION->IncludeFile(
            SITE_DIR . "/local/includes/slider.php",
            Array(),
            Array("MODE" => "php")
        );
    }
    ?>

    <div class="row">
        <div class="col-md-3 col-sm-4 hidden-xs">
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "aside_catalog_menu",
                array(
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COUNT_ELEMENTS" => "Y",
                    "IBLOCK_ID" => "4",
                    "IBLOCK_TYPE" => "catalog",
                    "SECTION_CODE" => "",
                    "SECTION_FIELDS" => array(
                        0 => "",
                        1 => "",
                    ),
                    "SECTION_ID" => "",
                    "SECTION_URL" => "/catalog/#SECTION_CODE_PATH#/",
                    "SECTION_USER_FIELDS" => array(
                        0 => "",
                        1 => "",
                    ),
                    "SHOW_PARENT_NAME" => "Y",
                    "TOP_DEPTH" => "2",
                    "VIEW_MODE" => "LINE",
                    "COMPONENT_TEMPLATE" => "aside_catalog_menu"
                ),
                false
            );
            ?>
            <? $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                    "AREA_FILE_RECURSIVE" => "Y",
                    "AREA_FILE_SHOW" => "sect",
                    "AREA_FILE_SUFFIX" => "aside_bar",
                    "EDIT_TEMPLATE" => ""
                )
            ); ?>
        </div>
        <div class="col-md-9 col-sm-8">

            <? if ($CurPage == '/') { //Если главная?>
                <!-- Можно вставить что угодно, будет только на главной (вкл область, например)  -->
            <? } else { ?>
                <h1><? $APPLICATION->ShowTitle(false); ?></h1>
                <? // Навигационная цепочка - http://dev.1c-bitrix.ru/user_help/settings/settings/components_2/navigation/breadcrumb.php
                $APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    ".default",
                    array(
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => "s1",
                        "COMPONENT_TEMPLATE" => ".default"
                    ),
                    false
                ); ?>
            <? } ?>




