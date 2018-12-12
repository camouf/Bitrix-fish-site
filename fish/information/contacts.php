<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Контакты");
$APPLICATION->SetPageProperty("keywords", "Контакты");
$APPLICATION->SetPageProperty("title", "Контакты");
$APPLICATION->SetTitle("Контакты"); ?>
    <p>
        Товарищи! рамки и место обучения кадров влечет за собой процесс внедрения и модернизации дальнейших направлений
        развития. Равным образом новая модель организационной.
    </p>
    <dl class="row">
        <dt class="col-sm-3">Телефоны</dt>
        <dd class="col-sm-9">
            8-800-123-23-23<br>
            8-800-123-23-23<br>
            <br>
        </dd>
        <dt class="col-sm-3">Отдел продаж</dt>
        <dd class="col-sm-9">
            8-800-123-23-23<br>
            <a href="mailto:example@ex.hover?subject=Письмо с сайта рыбы">example@ex.hover</a><br>
            <br>
        </dd>
        <dt class="col-sm-3">Бухгалтерия</dt>
        <dd class="col-sm-9">
            8-800-123-23-23<br>
            <a href="mailto:example@ex.hover?subject=Письмо с сайта рыбы">example@ex.hover</a><br>
            <br>
        </dd>
        <dt class="col-sm-3">Директорат</dt>
        <dd class="col-sm-9">
            8-800-123-23-23<br>
            <a href="mailto:example@ex.hover?subject=Письмо с сайта рыбы">example@ex.hover</a><br>
        </dd>
    </dl>

<div class="row">
<? $APPLICATION->IncludeComponent("bitrix:main.feedback", "feedform", Array(
    "EMAIL_TO" => "example@ex.hover",    // E-mail, на который будет отправлено письмо
    "EVENT_MESSAGE_ID" => "",    // Почтовые шаблоны для отправки письма
    "OK_TEXT" => "Спасибо, ваше сообщение принято.",    // Сообщение, выводимое пользователю после отправки
    "REQUIRED_FIELDS" => "",    // Обязательные поля для заполнения
    "USE_CAPTCHA" => "Y",    // Использовать защиту от автоматических сообщений (CAPTCHA) для неавторизованных пользователей
),
    false
); ?>
</div>

<h3>Реквизиты</h3>

    <blockquote>
        Разнообразный и богатый опыт рамки и место обучения кадров позволяет выполнять важные задания по разработке
        направлений прогрессивного развития.
    </blockquote>

    <dl class="row">
        <dt class="col-sm-3">ИНН</dt>
        <dd class="col-sm-9">
            8-800-123-23-23
        </dd>
        <dt class="col-sm-3">КПП</dt>
        <dd class="col-sm-9">
            8-800-123-23-23
        </dd>
        <dt class="col-sm-3">ОГРН</dt>
        <dd class="col-sm-9">
            8-800-123-23-23
        </dd>
        <dt class="col-sm-3">Юр. адрес</dt>
        <dd class="col-sm-9">
            г. Любой, ул. Зелёной аллеи, 742 Пристань #548-4 mail: fish@bazarow.ru
        </dd>
    </dl>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>