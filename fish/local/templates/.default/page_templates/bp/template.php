<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

CPageTemplate::IncludeLangFile(__FILE__);

class CBPPageTemplate
{
	function GetDescription()
	{
		return array(
			"name" => GetMessage("bp_wizard_name"), 
			"description" => GetMessage("bp_wizard_title"),
			"icon" => "/bitrix/templates/.default/page_templates/bp/images/icon_bp.gif",
			"modules" => array("bizproc", "iblock"),
		);
	}

	function GetFormHtml()
	{
		if (!CModule::IncludeModule('iblock'))
			return '';

		//name
		$s = '
<tr class="section">
	<td colspan="2">'.GetMessage("bp_wizard_settings").'</td>
</tr>
<tr>
	<td class="bx-popup-label bx-width30">'.GetMessage("bp_wizard_lib_name").'</td>
	<td><input type="text" name="bp_TITLE" value="'.GetMessage("bp_wizard_lib_name_val").'" style="width:90%"></td>
</tr>
';		//iblock
		$s .= '
<tr>
	<td class="bx-popup-label">'.GetMessage("bp_wizard_iblock_type").'</td>
	<td>
<script>
window.bp_NewIblockTypeClick = function(el)
{
	el.form.bp_IBLOCK_TYPE.disabled = (el.value == "Y");
	el.form.bp_NEW_IBLOCK_TYPE_TITLE.disabled = (el.value != "Y");
}
</script>

<input type="radio" name="bp_NEW_IBLOCK_TYPE" value="Y" id="bp_NEW_IBLOCK_Y" checked onclick="bp_NewIblockTypeClick(this);"><label for="bp_NEW_IBLOCK_Y">'.GetMessage("bp_wizard_iblock_new").'</label><br>
<input type="text" name="bp_NEW_IBLOCK_TYPE_TITLE" value="" style="width:90%"><br>
<input type="radio" name="bp_NEW_IBLOCK_TYPE" value="N" id="bp_NEW_IBLOCK_N" onclick="bp_NewIblockTypeClick(this);"><label for="bp_NEW_IBLOCK_N">'.GetMessage("bp_wizard_iblock_select").'</label><br>
	<select name="bp_IBLOCK_TYPE" disabled>
';		
		//iblock types and blocks
		$rsIBlockType = CIBlockType::GetList(array("sort"=>"asc"), array("ACTIVE"=>"Y"));
		$sFirstType = "";
		while ($arr=$rsIBlockType->Fetch())
			if($ar=CIBlockType::GetByIDLang($arr["ID"], LANGUAGE_ID))
			{
				if($sFirstType == "")
					$sFirstType = $arr["ID"];
				$s .= '<option value="'.htmlspecialchars($arr["ID"]).'"'.($arr["ID"] == 'bp'? ' selected':'').'>'.htmlspecialchars($ar["NAME"]." [".$arr["ID"]."]").'</option>';
			}
		$s .= '
		</select>
	</td>
</tr>
';

		return $s;
	}

	function GetContent($arParams)
	{
		if (!CModule::IncludeModule('iblock'))
			return false;

		//iblock
		$iblock_type = '';

		if ($_POST['bp_NEW_IBLOCK_TYPE'] == 'Y')
		{
			$lang = "";
			$dbSite = CSite::GetById($arParams['site']);
			if ($arSite = $dbSite->Fetch())
				$lang = $arSite["LANGUAGE_ID"];

			//new iblock
			$ib = new CIBlockType;
			$arFields = Array(
				"ID" => $_POST['bp_NEW_IBLOCK_TYPE_TITLE'],
				"LANG" => array($lang => array("NAME" => $_POST['bp_TITLE']))
			);

			$iblock_type = $ib->Add($arFields);
		}
		else
		{
			$res = CIBlockType::GetByID($_POST['bp_IBLOCK_TYPE']);
			if ($res_arr = $res->Fetch())
				$iblock_type = $res_arr["ID"];
		}

		$s = 
'<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?$APPLICATION->IncludeComponent("bitrix:bizproc.wizards", ".default", array(
	"IBLOCK_TYPE" => "'.EscapePHPString($iblock_type).'",
	"SEF_MODE" => "Y",
	"SET_TITLE" => "Y",
	"SET_NAV_CHAIN" => "Y",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_SHADOW" => "Y",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"SEF_FOLDER" => "'.EscapePHPString($arParams["path"]).'",
	"SEF_URL_TEMPLATES" => Array(
		"index" => "index.php",
		"new" => "new.php",
		"list" => "#block_id#/",
		"start" => "#block_id#/start.php",
		"task" => "#block_id#/task-#task_id#.php",
		"bp" => "#block_id#/bp.php",
		"setvar" => "#block_id#/setvar.php"
	),
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>';
		return $s;
	}
}

$pageTemplate = new CBPPageTemplate;
?>