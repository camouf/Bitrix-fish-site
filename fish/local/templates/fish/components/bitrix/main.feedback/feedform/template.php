<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<div class="col-sm-6">
    <h2>Пишите нам</h2>
    <div class="mfeedback">
        <? if (!empty($arResult["ERROR_MESSAGE"])) {
            foreach ($arResult["ERROR_MESSAGE"] as $v)
                ShowError($v);
        }
        if (strlen($arResult["OK_MESSAGE"]) > 0) {
            ?>
            <div class="mf-ok-text"><?= $arResult["OK_MESSAGE"] ?></div><?
        }
        ?>
        <form action="<?= POST_FORM_ACTION_URI ?>" method="POST">
            <?= bitrix_sessid_post() ?>
            <input type="text" name="user_name" value="" placeholder="Как к Вам обращаться" required>
            <input type="email" name="user_email" value="" placeholder="Электронная почта для ответа" required>
            <textarea name="MESSAGE" rows="5" cols="40" placeholder="Текст вопроса или обращения" required></textarea>
            <? if ($arParams["USE_CAPTCHA"] == "Y"): ?>
                <div class="mf-captcha">
                    <div class="mf-text"><?= GetMessage("MFT_CAPTCHA") ?></div>
                    <input type="hidden" name="captcha_sid" value="<?= $arResult["capCode"] ?>">
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["capCode"] ?>" width="180" height="40"
                         alt="CAPTCHA">
                    <div class="mf-text"><?= GetMessage("MFT_CAPTCHA_CODE") ?><span class="mf-req">*</span></div>
                    <input type="text" name="captcha_word" size="30" maxlength="50" value="">
                </div>
            <? endif; ?>
            <label><input type="checkbox" id="check" onchange="changeButtonState(this)" class="chekbox"> Даю согласие на</label>
            <a href="/information/confedectial.php">обработку данных</a>
            <div class="clb"></div>
            <input type="hidden" name="PARAMS_HASH" value="<?= $arResult["PARAMS_HASH"] ?>">
            <input type="submit" name="submit" value="Отправить" id="btn" disabled="disabled">
        </form>
    </div>
</div>


<script>
    function changeButtonState(checkbox) {
        var btn = document.getElementById('btn');
        if (checkbox.checked) {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    }
</script>