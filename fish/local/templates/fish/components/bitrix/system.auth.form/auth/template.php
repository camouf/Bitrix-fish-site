<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<a href="#" data-fancybox="" data-src="#login">Войти</a>
<div id="login" class="modal_block">
    <div class="modal-dialog">
        <div class="modal-content modal-form">
            <?
            CJSCore::Init();
            if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
                ShowMessage($arResult['ERROR_MESSAGE']);
            if ($arResult["FORM_TYPE"] == "login"): ?>
                <form name="system_auth_form<?= $arResult["RND"] ?>" method="post" target="_top"
                      action="<?= $arResult["AUTH_URL"] ?>">
                    <?
                    if ($arResult["BACKURL"] <> ''): ?>
                        <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                    <? endif ?>
                    <?
                    foreach ($arResult["POST"] as $key => $value): ?>
                        <input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
                    <? endforeach ?>
                    <input type="hidden" name="AUTH_FORM" value="Y"/>
                    <input type="hidden" name="TYPE" value="AUTH"/>

                    <div class="input-group input-group-lg">
                        <input class="form-control" type="text" name="USER_LOGIN" maxlength="50" value="" size="17"
                               placeholder="Ваша электронная почта"/>
                        <br><br>
                        <input class="form-control" type="password" name="USER_PASSWORD" maxlength="50" size="17"
                               autocomplete="off" placeholder="Ваш пароль"/>
                    </div>
                    <br>
                    <input class="btn btn-default" type="submit" name="Login"
                           value="<?= GetMessage("AUTH_LOGIN_BUTTON") ?>"/>
                    <br>
                    <a href="/personal/auth/getpass.php?forgot_password=yes">Напомнить пароль</a>
                    <i>или</i>
                    <a href="/personal/auth/registration.php">Зарегистрироваться</a>
                </form>
            <?
            else:{
                ?>
                <p>Вы успешно авторизовались на сайте</p>
                <?
            }
            endif ?>
        </div>
    </div>
</div>
