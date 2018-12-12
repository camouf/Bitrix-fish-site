<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Catalog;
use Bitrix\Iblock;

$themes = array();
if (\Bitrix\Main\ModuleManager::isModuleInstalled('bitrix.eshop'))
	$themes['site'] = GetMessage('CP_SBB_TPL_THEME_SITE');

$themesList = array(
	'blue' => GetMessage('CP_SBB_TPL_THEME_BLUE'),
	'green' => GetMessage('CP_SBB_TPL_THEME_GREEN'),
	'red' => GetMessage('CP_SBB_TPL_THEME_RED'),
	'wood' => GetMessage('CP_SBB_TPL_THEME_WOOD'),
	'yellow' => GetMessage('CP_SBB_TPL_THEME_YELLOW'),
	'black' => GetMessage('CP_SBB_TPL_THEME_BLACK')
);
$dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__)."/themes/"));
if (is_dir($dir))
{
	foreach ($themesList as $themeID => $themeName)
	{
		if (!is_file($dir.$themeID.'/style.css'))
			continue;
		$themes[$themeID] = $themeName;
	}
}

$arTemplateParameters['TEMPLATE_THEME'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_SBB_TPL_TEMPLATE_THEME'),
	'TYPE' => 'LIST',
	'VALUES' => $themes,
	'DEFAULT' => 'blue',
	'ADDITIONAL_VALUES' => 'Y'
);

if (\Bitrix\Main\Loader::includeModule('catalog'))
{
	$arSKU = false;
	$boolSKU = false;
	$arOfferProps = array();
	$arSkuData = array();

	// get iblock props from all catalog iblocks including sku iblocks
	$arSkuIblockIDs = array();
	$iterator = \Bitrix\Catalog\CatalogIblockTable::getList(array(
		'select' => array('IBLOCK_ID', 'PRODUCT_IBLOCK_ID', 'SKU_PROPERTY_ID'),
		'filter' => array('!=PRODUCT_IBLOCK_ID' => 0)
	));
	while ($row = $iterator->fetch())
	{
		$boolSKU = true;
		$arSkuIblockIDs[] = $row['IBLOCK_ID'];
		$arSkuData[$row['IBLOCK_ID']] = $row;
	}
	unset($row, $iterator);

	// iblock props
	$arProps = array();
	foreach ($arSkuIblockIDs as $iblockID)
	{
		$dbProps = CIBlockProperty::GetList(
			array(
				"SORT"=>"ASC",
				"NAME"=>"ASC"
			),
			array(
				"IBLOCK_ID" => $iblockID,
				"ACTIVE" => "Y",
				"CHECK_PERMISSIONS" => "N",
			)
		);

		while ($arProp = $dbProps->GetNext())
		{
			if ($arProp['ID'] == $arSkuData[$iblockID]["SKU_PROPERTY_ID"])
				continue;

			if ($arProp['XML_ID'] == 'CML2_LINK')
				continue;

			$strPropName = '['.$arProp['ID'].'] '.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];

			if ($arProp['PROPERTY_TYPE'] != 'F')
			{
				$arOfferProps[$arProp['CODE']] = $strPropName;
			}
		}

		if (!empty($arOfferProps) && is_array($arOfferProps))
		{
			$arTemplateParameters['OFFERS_PROPS'] = array(
				'PARENT' => 'OFFERS_PROPS',
				'NAME' => GetMessage('SALE_PROPERTIES_RECALCULATE_BASKET'),
				'TYPE' => 'LIST',
				'MULTIPLE' => 'Y',
				'SIZE' => '7',
				'ADDITIONAL_VALUES' => 'N',
				'REFRESH' => 'N',
				'DEFAULT' => '-',
				'VALUES' => $arOfferProps
			);
		}
	}
}

$arTemplateParameters['USE_ENHANCED_ECOMMERCE'] = array(
	'PARENT' => 'ANALYTICS_SETTINGS',
	'NAME' => GetMessage('CP_SBB_TPL_USE_ENHANCED_ECOMMERCE'),
	'TYPE' => 'CHECKBOX',
	'REFRESH' => 'Y',
	'DEFAULT' => 'N'
);

if (isset($arCurrentValues['USE_ENHANCED_ECOMMERCE']) && $arCurrentValues['USE_ENHANCED_ECOMMERCE'] === 'Y')
{
	if (Loader::includeModule('catalog'))
	{
		$arIblockIDs = array();
		$arIblockNames = array();
		$catalogIterator = Catalog\CatalogIblockTable::getList(array(
			'select' => array('IBLOCK_ID', 'NAME' => 'IBLOCK.NAME'),
			'order' => array('IBLOCK_ID' => 'ASC')
		));
		while ($catalog = $catalogIterator->fetch())
		{
			$catalog['IBLOCK_ID'] = (int)$catalog['IBLOCK_ID'];
			$arIblockIDs[] = $catalog['IBLOCK_ID'];
			$arIblockNames[$catalog['IBLOCK_ID']] = $catalog['NAME'];
		}
		unset($catalog, $catalogIterator);

		if (!empty($arIblockIDs))
		{
			$arProps = array();
			$propertyIterator = Iblock\PropertyTable::getList(array(
				'select' => array('ID', 'CODE', 'NAME', 'IBLOCK_ID'),
				'filter' => array('@IBLOCK_ID' => $arIblockIDs, '=ACTIVE' => 'Y', '!=XML_ID' => CIBlockPropertyTools::XML_SKU_LINK),
				'order' => array('IBLOCK_ID' => 'ASC', 'SORT' => 'ASC', 'ID' => 'ASC')
			));
			while ($property = $propertyIterator->fetch())
			{
				$property['ID'] = (int)$property['ID'];
				$property['IBLOCK_ID'] = (int)$property['IBLOCK_ID'];
				$property['CODE'] = (string)$property['CODE'];

				if ($property['CODE'] == '')
				{
					$property['CODE'] = $property['ID'];
				}

				if (!isset($arProps[$property['CODE']]))
				{
					$arProps[$property['CODE']] = array(
						'CODE' => $property['CODE'],
						'TITLE' => $property['NAME'].' ['.$property['CODE'].']',
						'ID' => array($property['ID']),
						'IBLOCK_ID' => array($property['IBLOCK_ID'] => $property['IBLOCK_ID']),
						'IBLOCK_TITLE' => array($property['IBLOCK_ID'] => $arIblockNames[$property['IBLOCK_ID']]),
						'COUNT' => 1
					);
				}
				else
				{
					$arProps[$property['CODE']]['ID'][] = $property['ID'];
					$arProps[$property['CODE']]['IBLOCK_ID'][$property['IBLOCK_ID']] = $property['IBLOCK_ID'];

					if ($arProps[$property['CODE']]['COUNT'] < 2)
					{
						$arProps[$property['CODE']]['IBLOCK_TITLE'][$property['IBLOCK_ID']] = $arIblockNames[$property['IBLOCK_ID']];
					}

					$arProps[$property['CODE']]['COUNT']++;
				}
			}
			unset($property, $propertyIterator, $arIblockNames, $arIblockIDs);

			$propList = array();
			foreach ($arProps as $property)
			{
				$iblockList = '';

				if ($property['COUNT'] > 1)
				{
					$iblockList = ($property['COUNT'] > 2 ? ' ( ... )' : ' ('.implode(', ', $property['IBLOCK_TITLE']).')');
				}

				$propList['PROPERTY_'.$property['CODE']] = $property['TITLE'].$iblockList;
			}
			unset($property, $arProps);
		}
	}

	$arTemplateParameters['DATA_LAYER_NAME'] = array(
		'PARENT' => 'ANALYTICS_SETTINGS',
		'NAME' => GetMessage('CP_SBB_TPL_DATA_LAYER_NAME'),
		'TYPE' => 'STRING',
		'DEFAULT' => 'dataLayer'
	);

	if (!empty($propList))
	{
		$arTemplateParameters['BRAND_PROPERTY'] = array(
			'PARENT' => 'ANALYTICS_SETTINGS',
			'NAME' => GetMessage('CP_SBB_TPL_BRAND_PROPERTY'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'DEFAULT' => '',
			'VALUES' => array('' => '') + $propList
		);
	}
}