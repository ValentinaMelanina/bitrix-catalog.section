<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogProductsViewedComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

if (isset($arResult['ITEM'])) // Проверяем есть ли элемент в массиве результата
{
    // Присваиваем значения переменным из массива результата для более понятного и удобного взаимодействия
	$item = $arResult['ITEM']; // Массив элемента
	$areaId = $arResult['AREA_ID']; // ID области редактирования элемента (редактирование и удаление)

    // ВАЖНО! Идентфикаторы тегов на странице для работы с информацией размещающейся в тегах, например вывод цены, когда мы меняем количество товара +/-
    // Данные идентификаторы должны оставиться на странице в тех же блоках для корректной работы JS, удаляя ID, вы рискуете что часть функций перестанет работать
	$itemIds = array(
		'ID' => $areaId,
		'PICT' => $areaId.'_pict',
		'SECOND_PICT' => $areaId.'_secondpict',
		'PICT_SLIDER' => $areaId.'_pict_slider',
		'STICKER_ID' => $areaId.'_sticker',
		'SECOND_STICKER_ID' => $areaId.'_secondsticker',
		'QUANTITY' => $areaId.'_quantity',
		'QUANTITY_DOWN' => $areaId.'_quant_down',
		'QUANTITY_UP' => $areaId.'_quant_up',
		'QUANTITY_MEASURE' => $areaId.'_quant_measure',
		'QUANTITY_LIMIT' => $areaId.'_quant_limit',
		'BUY_LINK' => $areaId.'_buy_link',
		'BASKET_ACTIONS' => $areaId.'_basket_actions',
		'NOT_AVAILABLE_MESS' => $areaId.'_not_avail',
		'SUBSCRIBE_LINK' => $areaId.'_subscribe',
		'COMPARE_LINK' => $areaId.'_compare_link',
		'PRICE' => $areaId.'_price',
		'PRICE_OLD' => $areaId.'_price_old',
		'PRICE_TOTAL' => $areaId.'_price_total',
		'DSC_PERC' => $areaId.'_dsc_perc',
		'SECOND_DSC_PERC' => $areaId.'_second_dsc_perc',
		'PROP_DIV' => $areaId.'_sku_tree',
		'PROP' => $areaId.'_prop_',
		'DISPLAY_PROP_DIV' => $areaId.'_sku_prop',
		'BASKET_PROP_DIV' => $areaId.'_basket_prop',
	);
	$obName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $areaId); // Имя переменной объекта JS JCCatalogItem
	$isBig = isset($arResult['BIG']) && $arResult['BIG'] === 'Y'; // Используется ли BigData

	// Устанавливаем Title страницы исходя из SEO настроек элемента
	$productTitle = isset($item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
		? $item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
		: $item['NAME'];

    // Устанавливаем Title изображения анонса исходя из SEO настроек элемента
	$imgTitle = isset($item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
		? $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
		: $item['NAME'];

	$skuProps = array(); //Иинициализирование переменной содержащий массив свойств торговых предложений

	$haveOffers = !empty($item['OFFERS']); // Устанавливаем значение использования торговых предложений true/false
    if ($haveOffers) // Проверяем используются ли торговые предложения в данном товаре
	{
	    // Использование торговых предложений
	    // Так как торговые предложения это группа товаров, нам необходимо выбрать конкретный "по умолчанию"
        // и вывести информацию о нём на странице
		$actualItem = isset($item['OFFERS'][$item['OFFERS_SELECTED']])
			? $item['OFFERS'][$item['OFFERS_SELECTED']]
			: reset($item['OFFERS']);
	}
	else
	{
	    // Использование обычного товара
		$actualItem = $item;
	}
	// Теперь $actualItem содержит массив конкретного выбранного товара

	// "Схема отображения" в параметрах компонента. N - простой режим, Y - расширеный
    // В расширенном режиме можно выбрать конкретное торговое предложение самостоятельно
    // Поэтому здесь мы проверяем включен ли простой режим для торговых предложений? Иесли он включен, то нам надо указать
    // цену и прочие параметры, которые выводятся вместо выбора тогового предложения и кнопки купить.
	if ($arParams['PRODUCT_DISPLAY_MODE'] === 'N' && $haveOffers)
	{
		$price = $item['ITEM_START_PRICE']; // Минимальная цена из всех предложений
		$minOffer = $item['OFFERS'][$item['ITEM_START_PRICE_SELECTED']]; // Массив торгового предложения
		$measureRatio = $minOffer['ITEM_MEASURE_RATIOS'][$minOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']; // Коэффициент единицы измерения
		$morePhoto = $item['MORE_PHOTO']; // Дополнительные фотографии товара
	}
	else
	{
		$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']]; // Выбираем цену выбранного товара
		$measureRatio = $price['MIN_QUANTITY']; // Выбираем коэффициент количества
		$morePhoto = $actualItem['MORE_PHOTO']; // Дополнительные фотографии товара
	}

	$showSlider = is_array($morePhoto) && count($morePhoto) > 1; // Проверяем будем ли показывать слайдер изображений для товара
	$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($item['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

	// Формируем класс разположения блока скидки на товар
	$discountPositionClass = isset($arResult['BIG_DISCOUNT_PERCENT']) && $arResult['BIG_DISCOUNT_PERCENT'] === 'Y'
		? 'product-item-label-big'
		: 'product-item-label-small';
	$discountPositionClass .= $arParams['DISCOUNT_POSITION_CLASS'];

    // Формируем класс разположения блока метки товара
	$labelPositionClass = isset($arResult['BIG_LABEL']) && $arResult['BIG_LABEL'] === 'Y'
		? 'product-item-label-big'
		: 'product-item-label-small';
	$labelPositionClass .= $arParams['LABEL_POSITION_CLASS'];

    // Формируем класс размера кнопок
	$buttonSizeClass = isset($arResult['BIG_BUTTONS']) && $arResult['BIG_BUTTONS'] === 'Y' ? 'btn-md' : 'btn-sm';


	// НАЧАЛО ВЫВОДА HTML КОДА
	?>

	<div class="product-item-container<?=(isset($arResult['SCALABLE']) && $arResult['SCALABLE'] === 'Y' ? ' product-item-scalable-card' : '')?>"
		id="<?=$areaId?>" data-entity="item"><?// Контейнер товара?>
		<?
		$documentRoot = Main\Application::getDocumentRoot(); // Абсолютный путь к корню сайта, например /var/www/bitrix/data/www/yandex.ru
		$templatePath = strtolower($arResult['TYPE']).'/template.php'; // Путь к файлу шаблона блока товара
		$file = new Main\IO\File($documentRoot.$templateFolder.'/'.$templatePath); // Проверяем наличие файа шаблона
		if ($file->isExists())
		{
			include($file->getPath()); // Подключаем файл шаблона
		}

		// По своей сути данный компонент делится на обработку товаров обычных и с торговыми предложениями.
        // Поэтому в зависимости от типа товара формируются разные массивы с параметрами и html блоков на странице.
		if (!$haveOffers)
		{
		    // Формируем массив параметров для JS JCCatalogItem без торговых предложений
			$jsParams = array(
				'PRODUCT_TYPE' => $item['CATALOG_TYPE'],
				'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
				'SHOW_ADD_BASKET_BTN' => false,
				'SHOW_BUY_BTN' => true,
				'SHOW_ABSENT' => true,
				'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
				'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
				'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
				'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
				'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
				'BIG_DATA' => $item['BIG_DATA'],
				'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
				'VIEW_MODE' => $arResult['TYPE'],
				'USE_SUBSCRIBE' => $showSubscribe,
				'PRODUCT' => array(
					'ID' => $item['ID'],
					'NAME' => $productTitle,
					'DETAIL_PAGE_URL' => $item['DETAIL_PAGE_URL'],
					'PICT' => $item['SECOND_PICT'] ? $item['PREVIEW_PICTURE_SECOND'] : $item['PREVIEW_PICTURE'],
					'CAN_BUY' => $item['CAN_BUY'],
					'CHECK_QUANTITY' => $item['CHECK_QUANTITY'],
					'MAX_QUANTITY' => $item['CATALOG_QUANTITY'],
					'STEP_QUANTITY' => $item['ITEM_MEASURE_RATIOS'][$item['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
					'QUANTITY_FLOAT' => is_float($item['ITEM_MEASURE_RATIOS'][$item['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
					'ITEM_PRICE_MODE' => $item['ITEM_PRICE_MODE'],
					'ITEM_PRICES' => $item['ITEM_PRICES'],
					'ITEM_PRICE_SELECTED' => $item['ITEM_PRICE_SELECTED'],
					'ITEM_QUANTITY_RANGES' => $item['ITEM_QUANTITY_RANGES'],
					'ITEM_QUANTITY_RANGE_SELECTED' => $item['ITEM_QUANTITY_RANGE_SELECTED'],
					'ITEM_MEASURE_RATIOS' => $item['ITEM_MEASURE_RATIOS'],
					'ITEM_MEASURE_RATIO_SELECTED' => $item['ITEM_MEASURE_RATIO_SELECTED'],
					'MORE_PHOTO' => $item['MORE_PHOTO'],
					'MORE_PHOTO_COUNT' => $item['MORE_PHOTO_COUNT']
				),
				'BASKET' => array(
					'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
					'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
					'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
					'EMPTY_PROPS' => empty($item['PRODUCT_PROPERTIES']),
					'BASKET_URL' => $arParams['~BASKET_URL'],
					'ADD_URL_TEMPLATE' => $arParams['~ADD_URL_TEMPLATE'],
					'BUY_URL_TEMPLATE' => $arParams['~BUY_URL_TEMPLATE']
				),
				'VISUAL' => array(
					'ID' => $itemIds['ID'],
					'PICT_ID' => $item['SECOND_PICT'] ? $itemIds['SECOND_PICT'] : $itemIds['PICT'],
					'PICT_SLIDER_ID' => $itemIds['PICT_SLIDER'],
					'QUANTITY_ID' => $itemIds['QUANTITY'],
					'QUANTITY_UP_ID' => $itemIds['QUANTITY_UP'],
					'QUANTITY_DOWN_ID' => $itemIds['QUANTITY_DOWN'],
					'PRICE_ID' => $itemIds['PRICE'],
					'PRICE_OLD_ID' => $itemIds['PRICE_OLD'],
					'PRICE_TOTAL_ID' => $itemIds['PRICE_TOTAL'],
					'BUY_ID' => $itemIds['BUY_LINK'],
					'BASKET_PROP_DIV' => $itemIds['BASKET_PROP_DIV'],
					'BASKET_ACTIONS_ID' => $itemIds['BASKET_ACTIONS'],
					'NOT_AVAILABLE_MESS' => $itemIds['NOT_AVAILABLE_MESS'],
					'COMPARE_LINK_ID' => $itemIds['COMPARE_LINK'],
					'SUBSCRIBE_ID' => $itemIds['SUBSCRIBE_LINK']
				)
			);
		}
		else
		{
            // Формируем массив параметров для JS JCCatalogItem с торговыми предложениями
			$jsParams = array(
				'PRODUCT_TYPE' => $item['CATALOG_TYPE'],
				'SHOW_QUANTITY' => false,
				'SHOW_ADD_BASKET_BTN' => false,
				'SHOW_BUY_BTN' => true,
				'SHOW_ABSENT' => true,
				'SHOW_SKU_PROPS' => false,
				'SECOND_PICT' => $item['SECOND_PICT'],
				'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
				'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
				'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
				'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
				'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
				'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
				'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
				'BIG_DATA' => $item['BIG_DATA'],
				'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
				'VIEW_MODE' => $arResult['TYPE'],
				'USE_SUBSCRIBE' => $showSubscribe,
				'DEFAULT_PICTURE' => array(
					'PICTURE' => $item['PRODUCT_PREVIEW'],
					'PICTURE_SECOND' => $item['PRODUCT_PREVIEW_SECOND']
				),
				'VISUAL' => array(
					'ID' => $itemIds['ID'],
					'PICT_ID' => $itemIds['PICT'],
					'SECOND_PICT_ID' => $itemIds['SECOND_PICT'],
					'PICT_SLIDER_ID' => $itemIds['PICT_SLIDER'],
					'QUANTITY_ID' => $itemIds['QUANTITY'],
					'QUANTITY_UP_ID' => $itemIds['QUANTITY_UP'],
					'QUANTITY_DOWN_ID' => $itemIds['QUANTITY_DOWN'],
					'QUANTITY_MEASURE' => $itemIds['QUANTITY_MEASURE'],
					'QUANTITY_LIMIT' => $itemIds['QUANTITY_LIMIT'],
					'PRICE_ID' => $itemIds['PRICE'],
					'PRICE_OLD_ID' => $itemIds['PRICE_OLD'],
					'PRICE_TOTAL_ID' => $itemIds['PRICE_TOTAL'],
					'TREE_ID' => $itemIds['PROP_DIV'],
					'TREE_ITEM_ID' => $itemIds['PROP'],
					'BUY_ID' => $itemIds['BUY_LINK'],
					'DSC_PERC' => $itemIds['DSC_PERC'],
					'SECOND_DSC_PERC' => $itemIds['SECOND_DSC_PERC'],
					'DISPLAY_PROP_DIV' => $itemIds['DISPLAY_PROP_DIV'],
					'BASKET_ACTIONS_ID' => $itemIds['BASKET_ACTIONS'],
					'NOT_AVAILABLE_MESS' => $itemIds['NOT_AVAILABLE_MESS'],
					'COMPARE_LINK_ID' => $itemIds['COMPARE_LINK'],
					'SUBSCRIBE_ID' => $itemIds['SUBSCRIBE_LINK']
				),
				'BASKET' => array(
					'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
					'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
					'SKU_PROPS' => $item['OFFERS_PROP_CODES'],
					'BASKET_URL' => $arParams['~BASKET_URL'],
					'ADD_URL_TEMPLATE' => $arParams['~ADD_URL_TEMPLATE'],
					'BUY_URL_TEMPLATE' => $arParams['~BUY_URL_TEMPLATE']
				),
				'PRODUCT' => array(
					'ID' => $item['ID'],
					'NAME' => $productTitle,
					'DETAIL_PAGE_URL' => $item['DETAIL_PAGE_URL'],
					'MORE_PHOTO' => $item['MORE_PHOTO'],
					'MORE_PHOTO_COUNT' => $item['MORE_PHOTO_COUNT']
				),
				'OFFERS' => array(),
				'OFFER_SELECTED' => 0,
				'TREE_PROPS' => array()
			);

			// Здесь ключевой момент вывода данных
            // Если в параметрах указано выводить торговые предложения в расширенном  режиме и предложения есть, то
            // данные с торговыми предложениями загружаются JS объект
			if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && !empty($item['OFFERS_PROP']))
			{
				$jsParams['SHOW_QUANTITY'] = $arParams['USE_PRODUCT_QUANTITY'];
				$jsParams['SHOW_SKU_PROPS'] = $item['OFFERS_PROPS_DISPLAY'];
				$jsParams['OFFERS'] = $item['JS_OFFERS'];
				$jsParams['OFFER_SELECTED'] = $item['OFFERS_SELECTED'];
				$jsParams['TREE_PROPS'] = $skuProps;
			}
		}

		// Добавляем информацию в массив, если установлена опция сравнения товаров
		if ($arParams['DISPLAY_COMPARE'])
		{
			$jsParams['COMPARE'] = array(
				'COMPARE_URL_TEMPLATE' => $arParams['~COMPARE_URL_TEMPLATE'],
				'COMPARE_DELETE_URL_TEMPLATE' => $arParams['~COMPARE_DELETE_URL_TEMPLATE'],
				'COMPARE_PATH' => $arParams['COMPARE_PATH']
			);
		}

		// Является ли данный товар предложением из BigData, а не товаром из раздела каталога https://yadi.sk/d/r0fZVKc93LxZY2
		if ($item['BIG_DATA'])
		{
		    // Если да, то ID товара из BigData добавляем в массив параметров JS объекта
			$jsParams['PRODUCT']['RCM_ID'] = $item['RCM_ID'];
		}

		$jsParams['PRODUCT_DISPLAY_MODE'] = $arParams['PRODUCT_DISPLAY_MODE'];
		$jsParams['USE_ENHANCED_ECOMMERCE'] = $arParams['USE_ENHANCED_ECOMMERCE']; // Параметры компонента - "Отправлять данные электронной торговли в Google и Яндекс"
		$jsParams['DATA_LAYER_NAME'] = $arParams['DATA_LAYER_NAME']; // Название переменной JS dataLayer для данных электронной торговли Google и Яндекс, возможность указать появляется при включении USE_ENHANCED_ECOMMERCE
		$jsParams['BRAND_PROPERTY'] = !empty($item['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]) // Содержит название свойства производителя товара, возможность выбрать появляется при включении USE_ENHANCED_ECOMMERCE
			? $item['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
			: null;

		// Данный массив $templateData используется в ./component_epilog.php
		$templateData = array(
			'JS_OBJ' => $obName,
			'ITEM' => array(
				'ID' => $item['ID'],
				'IBLOCK_ID' => $item['IBLOCK_ID'],
				'OFFERS_SELECTED' => $item['OFFERS_SELECTED'],
				'JS_OFFERS' => $item['JS_OFFERS']
			)
		);
		?>
        <?// Подключаем JS объект из файла ./script.js?>
		<script>
		  var <?=$obName?> = new JCCatalogItem(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
		</script>
	</div>
	<?
	unset($item, $actualItem, $minOffer, $itemIds, $jsParams);
}