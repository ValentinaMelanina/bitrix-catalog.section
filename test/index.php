<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тестовый раздел");
?>
    <div class="mobile-main-search hidden visible-sm">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <form action="/">
                        <div class="form-group">
                            <input type="text" placeholder="Поиск по товарам и артикулу...">
                            <button type="submit" class="btn btn-mobile-search">

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

	<!-- promo-offer -->
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "promo-offer_inc",
			"EDIT_TEMPLATE" => ""
		)
	);?>

	<!-- catalog-list -->
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "catalog-list_inc",
			"EDIT_TEMPLATE" => ""
		)
	);?>

	<!-- ready-solutions-features -->
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "ready-solutions-features_inc",
			"EDIT_TEMPLATE" => ""
		)
	);?>

	<!-- categories-list -->
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "categories-list_inc",
			"EDIT_TEMPLATE" => ""
		)
	);?>

	<!-- order-callback -->
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "order-callback_inc",
			"EDIT_TEMPLATE" => ""
		)
	);?>

	<!-- about-services -->
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "about-services_inc",
			"EDIT_TEMPLATE" => ""
		)
	);?>

	<!-- main-features -->
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "main-features_inc",
			"EDIT_TEMPLATE" => ""
		)
	);?>

	<!-- about-shipping -->
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "about-shipping_inc",
			"EDIT_TEMPLATE" => ""
		)
	);?>

	<!-- clients-reviews -->
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "clients-reviews_inc",
			"EDIT_TEMPLATE" => ""
		)
	);?>

	<!-- brands-slider -->
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "brands-slider_inc",
			"EDIT_TEMPLATE" => ""
		)
	);?>


<!-- Вывод результатов поиска -->
<?$APPLICATION->IncludeComponent(
	"bitrix:search.page",
	"search.page-europamarket",
	Array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "N",
		"COMPONENT_TEMPLATE" => ".default",
		"DEFAULT_SORT" => "rank",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"FILTER_NAME" => "",
		"NO_WORD_LOGIC" => "N",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Результаты поиска",
		"PAGE_RESULT_COUNT" => "50",
		"PATH_TO_USER_PROFILE" => "",
		"RATING_TYPE" => "",
		"RESTART" => "N",
		"SHOW_RATING" => "",
		"SHOW_WHEN" => "N",
		"SHOW_WHERE" => "N",
		"USE_LANGUAGE_GUESS" => "Y",
		"USE_SUGGEST" => "N",
		"USE_TITLE_RANK" => "N",
		"arrFILTER" => "",
		"arrWHERE" => ""
	)
);?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>