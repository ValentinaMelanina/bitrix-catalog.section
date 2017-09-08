<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
CJSCore::Init(array("fx"));
$curPage = $APPLICATION->GetCurPage(true);
$theme = COption::GetOptionString("main", "europamarket", "blue", SITE_ID);
?>
<!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="/bitrix/templates/europamarket/image/x-icon" href="<?=SITE_DIR?>favicon.ico" />
	<?$APPLICATION->ShowHead();?>
	<?
	//	CSS стили
//	$APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/template_styles.css", true);
	$APPLICATION->SetAdditionalCSS("/bitrix/css/owl.carousel.css");
	$APPLICATION->SetAdditionalCSS("/bitrix/css/jquery-ui-1.9.2.custom.min.css");
	//	JS
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/plugins/svg4everybody.min.js");
	?>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<title><?$APPLICATION->ShowTitle()?></title>
</head>
<body>
<?include($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/europamarket/include/variables.php');?>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
	<header class="main-header">
		<div id="svg-sprite" class="hidden" hidden data-href="/bitrix/templates/europamarket/images/sprite.svg"></div>

		<div class="top hidden-sm">
			<div class="container">
				<div class="row row-middle">

					<!-- Регион посетителя -->
					<div class="col-2 hidden-md">
						<div class="region-block">
							<span>
							<!--Модуль определения региона по IP-->
							<?if(CModule::IncludeModule("altasib.geoip"))
							{
								$arData = ALX_GeoIP::GetAddr();
								echo $arData["city"];
							}?>
							</span>
						</div>
					</div>

					<!-- Контактный номер и кнопка заказа обратного звонка -->
					<div class="col-5 col-md-4 col-lg-3">
						<div class="callback">
							<!-- Контактный номер телефона -->
							<svg class="svg-sprite-icon">
								<use xlink:href="#em_callnumber"></use>
							</svg>
							<a class="phone-link" href="tel:<?=$phone?>">
								<?=$phone?>
							</a>

							<!-- Заказ обратного звонка  -->
								<?$APPLICATION->IncludeComponent(
									"vr:callback",
									"",
									Array(
										"EMAIL_TO" => "hello@melanina.ru",
										"IBLOCK_ID" => "4",
										"IBLOCK_TYPE" => "vr_callback",
										"INCLUDE_JQUERY" => "Y",
										"MAIL_TEMPLATE" => "FEEDBACK_FORM",
										"PROPERTY_FIO" => "FIO",
										"PROPERTY_FORM_NAME" => "FORM",
										"PROPERTY_PAGE" => "PAGE"
									)
								);?>
						</div>
					</div>

					<!-- Время работы и контакты, авторизация -->
					<div class="col-5 col-md-8 col-lg-7 col-between">
						<!-- Время работы и контакты -->
						<div class="work-info">
							<!-- Время работы -->
							<div class="time">
								<?=$openingHours?>
							</div>

							<!-- Адрес -->
							<address class="address">
								<span><?=$companyAddress?></span>
								<a class="light-link" href="/about/contacts/">Контакты</a>
							</address>
						</div>
						<!-- Авторизованный пользователь -->
						<?if ($USER->IsAuthorized()): //Если пользователь авторизован
							global $USER;
							$fotoUser = CFile::GetPath($USER->GetParam("PERSONAL_PHOTO"));
							$nameUser = $USER->GetFullName();
							?>
							<div class="authorized">
								<!-- Фотография пользователя -->
								<div class="user-photo"><img src="<?=$fotoUser?>" alt="<?=$nameUser?>"></div>
								<!-- Ссылка для перехода в личный кабинет -->
								<a href="/personal/" class="user-name" title="Перейти в личный кабинет"><?=$nameUser;?></a>
								<!-- Ссылка для выхода из системы -->
								<a  href="/login/?logout=yes&backurl=<?=urlencode($_SERVER['REQUEST_URI'])?>"
								    class="logout" title="Выйти">Выйти</a>
							</div>
						<!-- Авторизация/регистрация ПК -->
						<?else:?>
							<div class="auth">
								<a href="/login/?register=yes&backurl=<?=urlencode($_SERVER['REQUEST_URI'])?>"
								   class="register auth-link" title="Перейти на страницу регистрации">
									<svg class="svg-sprite-icon">
										<use xlink:href="#em_user_half"></use>
									</svg>
									<span>Регистрация</span></a>

								<a href="/login/?login=yes&backurl=<?=urlencode($_SERVER['REQUEST_URI'])?>"
								   class="login auth-link" title="Перейти на страницу авторизации">
									<svg class="svg-sprite-icon">
										<use xlink:href="#em_logout"></use>
									</svg>
									<span>Вход</span>
								</a>
							</div>
						<?endif;?>
					</div>
				</div>
			</div>
		</div>

		<!-- todo: мобильное меню -->
		<div class="content">
			<div class="container">
				<div class="row row-middle">
					<!-- Мобильное меню -->
					<div class="col-sm-4 hidden visible-sm">
						<!-- todo: мобильное меню -->
						<div class="mobile-site-menu-wrap">
							<button class="mobile-menu-button">
								<span class="burger-icon"></span>
							</button>
							<div class="mobile-menu-content">
								<!-- todo: мобильный поиск -->
								<div class="mobile-main-search">
									<form action="/">
										<div class="form-group">
											<input type="text" placeholder="Поиск по товарам и артикулу...">
											<button type="submit" class="btn btn-mobile-search">
												<svg class="svg-sprite-icon">
													<use xlink:href="#em_search"></use>
												</svg>
											</button>
										</div>
									</form>
								</div>
								<div class="title block-title">УЧЕТНАЯ ЗАПИСЬ</div>
								<!-- todo: мобильная авторизация -->
								<div class="mobile-auth hidden">
									<a href="#" class="register auth-link" title="Перейти на страницу регистрации">
										<svg class="svg-sprite-icon">
											<use xlink:href="#em_user_half"></use>
										</svg>
										<span>Регистрация</span></a>
									<a href="#" class="login auth-link" title="Перейти на страницу авторизации">
										<svg class="svg-sprite-icon">
											<use xlink:href="#em_logout"></use>
										</svg>
										<span>Вход</span>
									</a>
								</div>
								<div class="mobile-authorized">
									<div class="user-photo">
										<img src="/bitrix/templates/europamarket/images/content/user_photo_auth.jpg" alt="Афанасия Евкакиевна">
									</div>
									<a href="#" class="user-name" title="Перейти в личный кабинет">
										Наталья Борисова
									</a>
									<a  href="#" class="logout" title="Выйти">
										Выход
									</a>
								</div>
								<div class="title block-title">О ЕВРОПА МАРКЕТ</div>
								<!-- todo: ссылки мобильного меню -->
								<ul class="links-list">
									<li>
										<a class="menu-link" href="#" title="Перейти">Главная</a>
									</li>
									<li>
										<a class="menu-link" href="#" title="Перейти">О компании</a>
									</li>
									<li>
										<a class="menu-link" href="#" title="Перейти">Готовые решения</a>
									</li>
									<li>
										<a class="menu-link" href="#" title="Перейти">Наши покупатели</a>
									</li>
									<li>
										<a class="menu-link" href="#" title="Перейти">Отзывы</a>
									</li>
									<li>
										<a class="menu-link" href="#" title="Перейти">Кабинет</a>
									</li>
									<li>
										<a class="menu-link" href="#" title="Перейти">Спецпредложение</a>
									</li>
									<li>
										<a class="menu-link" href="#" title="Перейти">Как нас найти</a>
									</li>
									<li>
										<a class="menu-link" href="#" title="Перейти">Доставка и оплата</a>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<!-- Логотип -->
					<div class="col-2 col-sm-4 no-gutter-sm">
						<!-- Логотип. Добавить ссылку, если не главная стр. -->
						<? if ($APPLICATION->GetCurPage(false) !== '/'): ?>
							<a href="/" class="logo-wrap">
								<svg class="svg-sprite-icon">
									<use xlink:href="#em_logo"></use>
								</svg>
							</a>
							<?else:?>
							<span class="logo-wrap">
								<svg class="svg-sprite-icon">
									<use xlink:href="#em_logo"></use>
								</svg>
							</span>

						<? endif; ?>
					</div>

					<!-- Поиск по сайту -->
					<div class="col-7 hidden-sm">
						<?$APPLICATION->IncludeComponent(
							"bitrix:search.title",
							"europamarket",
							array(
								"NUM_CATEGORIES" => "1",
								"TOP_COUNT" => "5",
								"CHECK_DATES" => "N",
								"SHOW_OTHERS" => "N",
								"PAGE" => SITE_DIR."test/",
								"CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
								"CATEGORY_0" => array(
									0 => "iblock_catalog",
								),
								"CATEGORY_0_iblock_catalog" => array(
									0 => "all",
								),
								"CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
								"SHOW_INPUT" => "Y",
								"INPUT_ID" => "title-search-input",
								"CONTAINER_ID" => "main-search",
								"PRICE_CODE" => array(
									0 => "BASE",
								),
								"SHOW_PREVIEW" => "Y",
								"PREVIEW_WIDTH" => "75",
								"PREVIEW_HEIGHT" => "75",
								"CONVERT_CURRENCY" => "Y",
								"COMPONENT_TEMPLATE" => "europamarket",
								"ORDER" => "date",
								"USE_LANGUAGE_GUESS" => "Y",
								"PRICE_VAT_INCLUDE" => "Y",
								"PREVIEW_TRUNCATE_LEN" => "",
								"CURRENCY_ID" => "RUB"
							),
							false
						);?>
					</div>

					<!-- Корзина -->
					<div class="col-3 col-sm-4">
						<div class="cart-block-wrap">
							<?$APPLICATION->IncludeComponent(
								"bitrix:sale.basket.basket.line",
								"basket-europamarket",
								array(
									"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
									"PATH_TO_PERSONAL" => SITE_DIR."personal/",
									"SHOW_PERSONAL_LINK" => "N",
									"SHOW_NUM_PRODUCTS" => "Y",
									"SHOW_TOTAL_PRICE" => "Y",
									"SHOW_PRODUCTS" => "Y",
									"POSITION_FIXED" => "N",
									"SHOW_AUTHOR" => "N",
									"PATH_TO_REGISTER" => SITE_DIR."login/",
									"PATH_TO_PROFILE" => SITE_DIR."personal/",
									"COMPONENT_TEMPLATE" => "basket-europamarket",
									"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
									"SHOW_EMPTY_VALUES" => "Y",
									"PATH_TO_AUTHORIZE" => "",
									"HIDE_ON_BASKET_PAGES" => "Y",
									"SHOW_DELAY" => "N",
									"SHOW_NOTAVAIL" => "N",
									"SHOW_SUBSCRIBE" => "N",
									"SHOW_IMAGE" => "Y",
									"SHOW_PRICE" => "N",
									"SHOW_SUMMARY" => "Y"
								),
								false
							);?>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>

		<!-- todo: основное меню-->
		<nav class="main-menu hidden-sm">
				<!--Горизонтальное меню-->
				<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"catalog_horizontal", 
	array(
		"ROOT_MENU_TYPE" => "test",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_THEME" => "site",
		"CACHE_SELECTED_ITEMS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "bottom",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "catalog_horizontal"
	),
	false
);?>
		</nav>
	</header>

	<div class="main-wrapper">