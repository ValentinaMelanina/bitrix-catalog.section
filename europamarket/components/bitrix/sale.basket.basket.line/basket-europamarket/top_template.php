<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>
	<?
		if (!$arResult["DISABLE_USE_BASKET"])
		{?>
			<a href="<?=$arParams['PATH_TO_BASKET'] ?>" class="cart-link">

				<?if (!$compositeStub)
				{
					// Количество товаров
					if ($arParams['SHOW_NUM_PRODUCTS'] == 'Y' && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y'))
					{?>
						<div class="cart-icon-wrap">
							<svg class="svg-sprite-icon cart-icon">
								<use xlink:href="#em_bag_1"></use>
							</svg>
							<span class="badge"><?=$arResult['NUM_PRODUCTS'];?></span>
						</div>
					<?}

					// Общая стоимость
					if ($arParams['SHOW_TOTAL_PRICE'] == 'Y'):?>
						<? if ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y'):?>
						<div class="cart-info hidden-sm">
							<span class="cart-title"><?=GetMessage('TSB1_CART')?></span>
							<span class="cart-price"><?=$arResult['TOTAL_PRICE']?></span>
						</div>
						<?endif ?>
					<?endif;?>
					<?
				}?>
			</a>
			<button class="btn-chevron btn-chevron-down btn-toggle-cart hidden-sm" type="button">
				<span></span>
			</button>
		<?}?>
