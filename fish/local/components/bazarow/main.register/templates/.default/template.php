<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
<? if ($USER->IsAuthorized()):
    //header( 'Location: http://техноряд.рф/personal/', true, 301 );
else: ?>
    <?
    if (count($arResult["ERRORS"]) > 0):
        foreach ($arResult["ERRORS"] as $key => $error)
            if (intval($key) == 0 && $key !== 0)
                $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;" . GetMessage("REGISTER_FIELD_" . $key) . "&quot;", $error);

        ShowError(implode("<br />", $arResult["ERRORS"]));

    elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
        ?>
        <p><? echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT") ?></p>
    <? endif ?>
    <form method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regform" enctype="multipart/form-data">
        <?
        if ($arResult["BACKURL"] <> ''):
            ?>
            <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
        <?
        endif;
        ?>
        <? foreach ($arResult["SHOW_FIELDS"] as $FIELD): ?>

            <div class="input-group input-group-lg">
                <? if ($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true): ?>
                    <select name="REGISTER[AUTO_TIME_ZONE]"
                            onchange="this.form.elements['REGISTER[TIME_ZONE]'].disabled=(this.value != 'N')">
                        <option value=""><? echo GetMessage("main_profile_time_zones_auto_def") ?></option>
                        <option value="Y"<?= $arResult["VALUES"][$FIELD] == "Y" ? " selected=\"selected\"" : "" ?>><? echo GetMessage("main_profile_time_zones_auto_yes") ?></option>
                        <option value="N"<?= $arResult["VALUES"][$FIELD] == "N" ? " selected=\"selected\"" : "" ?>><? echo GetMessage("main_profile_time_zones_auto_no") ?></option>
                    </select>
                    <? echo GetMessage("main_profile_time_zones_zones") ?>
                    <select name="REGISTER[TIME_ZONE]"<? if (!isset($_REQUEST["REGISTER"]["TIME_ZONE"])) echo 'disabled="disabled"' ?>>
                        <? foreach ($arResult["TIME_ZONE_LIST"] as $tz => $tz_name): ?>
                            <option value="<?= htmlspecialcharsbx($tz) ?>"<?= $arResult["VALUES"]["TIME_ZONE"] == $tz ? " selected=\"selected\"" : "" ?>><?= htmlspecialcharsbx($tz_name) ?></option>
                        <? endforeach ?>
                    </select>
                <? else: ?>
                    <?
                    switch ($FIELD) {
                        case "PASSWORD":
                            ?>
                            <input class="form-control" size="30" type="password" name="REGISTER[<?= $FIELD ?>]"
                                   value="" placeholder="<?= GetMessage("REGISTER_FIELD_" . $FIELD) ?>"
                                   autocomplete="off" class="bx-auth-input"/>
                            <?
                            break;
                        case "CONFIRM_PASSWORD":
                            ?><input class="form-control" size="30" type="password" name="REGISTER[<?= $FIELD ?>]" value=""
                                     placeholder="<?= GetMessage("REGISTER_FIELD_" . $FIELD) ?>"
                                     autocomplete="off" /><?
                            break;
                        case "PERSONAL_GENDER":
                            ?><select name="REGISTER[<?= $FIELD ?>]">
                            <option value=""><?= GetMessage("USER_DONT_KNOW") ?></option>
                            <option value="M"<?= $arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : "" ?>><?= GetMessage("USER_MALE") ?></option>
                            <option value="F"<?= $arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : "" ?>><?= GetMessage("USER_FEMALE") ?></option>
                            </select><?
                            break;

                        case "PERSONAL_COUNTRY":
                        case "WORK_COUNTRY":
                            ?><select name="REGISTER[<?= $FIELD ?>]"><?
                            foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value) {
                                ?>
                                <option value="<?= $value ?>"<?
                                if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif ?>><?= $arResult["COUNTRIES"]["reference"][$key] ?></option>
                                <?
                            }
                            ?></select><?
                            break;

                        case "PERSONAL_PHOTO":
                        case "WORK_LOGO":
                            ?><input class="form-control" size="30" type="file" name="REGISTER_FILES_<?= $FIELD ?>" /><?
                            break;

                        case "PERSONAL_NOTES":
                        case "WORK_NOTES":
                            ?><textarea cols="30" rows="5"
                                        name="REGISTER[<?= $FIELD ?>]"><?= $arResult["VALUES"][$FIELD] ?></textarea><?
                            break;
                        default:
                            if ($FIELD == "PERSONAL_BIRTHDAY"):?>
                                <small><?= $arResult["DATE_FORMAT"] ?></small><br/><?endif;
                            ?><input class="form-control" size="30" type="text" name="REGISTER[<?= $FIELD ?>]" value=""
                                     placeholder="Ваша электронная почта" /><?
                    } ?>
                <? endif ?>
            </div>
        <? endforeach ?>

        <? // ********************* User properties ***************************************************?>
        <? if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y"): ?>
            <?= strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB") ?>
        <? endif; ?>
        <? // ******************** /User properties ***************************************************?>
        <br>
        <input type="submit" name="register_submit_button" class="btn btn-default" value="Зарегистрироваться"/>
    </form>
<? endif ?>
<br>
<a href="/personal/auth/getpass.php?forgot_password=yes">Напомнить пароль</a>
<i>или</i>
<a href="/personal/auth/registration.php">Зарегистрироваться</a>

