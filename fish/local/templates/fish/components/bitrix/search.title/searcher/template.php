<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

$INPUT_ID = trim($arParams["~INPUT_ID"]);
if (strlen($INPUT_ID) <= 0)
    $INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if (strlen($CONTAINER_ID) <= 0)
    $CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if ($arParams["SHOW_INPUT"] !== "N"):?>
    <div class="sform" id="<? echo $CONTAINER_ID ?>">
        <form action="<? echo $arResult["FORM_ACTION"] ?>">
            <div class="bx-input-group">
                <input id="<? echo $INPUT_ID ?>" type="text" name="q"
                       value="<?= htmlspecialcharsbx($_REQUEST["q"]) ?>"
                       placeholder="Поиск по каталогу"
                       autocomplete="off" class="bx-form-control"/>
                <button type="submit" name="s">Искать</button>
            </div>
        </form>
    </div>
<? endif ?>
<script>
    BX.ready(function () {
        new JCTitleSearch({
            'AJAX_PAGE': '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
            'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
            'INPUT_ID': '<?echo $INPUT_ID?>',
            'MIN_QUERY_LEN': 2
        });
    });
</script>
