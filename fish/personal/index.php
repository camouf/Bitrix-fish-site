<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Персональный раздел");
if (CUser::IsAuthorized()) {
    ?>
    <p>Вы успешно авторизовались на сайте</p>
    <ul>
        <li><a href="/">Перейти на главную</a></li>
        <li><a href="/personal/auth/personal.php">Персональные данные</a></li>
        <li><a href="/personal/orders/">Ваши заказы</a></li>
        <li><a href="/?logout=yes">Выйти</a></li>
    </ul>
<?
} else {
    header('Location: / ');
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>