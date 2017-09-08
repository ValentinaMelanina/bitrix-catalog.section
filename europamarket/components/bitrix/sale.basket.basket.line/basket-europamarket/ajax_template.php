<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$this->IncludeLangFile('template.php');

$cartId = $arParams['cartId'];

require(realpath(dirname(__FILE__)).'/top_template.php');

if ($arParams["SHOW_PRODUCTS"] == "Y" && $arResult['NUM_PRODUCTS'] > 0)
{
?>
	<div data-role="basket-item-list" class="cart-content">

		<?if ($arParams["POSITION_FIXED"] == "Y"):?>
			<div id="<?=$cartId?>status" class="bx-basket-item-list-action" onclick="<?=$cartId?>.toggleOpenCloseCart()"><?=GetMessage("TSB1_COLLAPSE")?></div>
		<?endif?>

		<!-- Список товаров -->
		<ul id="<?=$cartId?>products" class="car-items-list">
			<?foreach ($arResult["CATEGORIES"] as $category => $items):
				if (empty($items))
					continue;
				?>

				<?foreach ($items as $v):?>
					<li class="cart-list-item">
						<!-- Картинка товара -->
						<div class="cart-item-image bx-basket-item-list-item-img">
							<?if ($arParams["SHOW_IMAGE"] == "Y" && $v["PICTURE_SRC"]):?>
								<?if($v["DETAIL_PAGE_URL"]):?>
									<a href="<?=$v["DETAIL_PAGE_URL"]?>"><img src="<?=$v["PICTURE_SRC"]?>" alt="<?=$v["NAME"]?>"></a>
								<?else:?>
									<img src="<?=$v["PICTURE_SRC"]?>" alt="<?=$v["NAME"]?>" />
								<?endif?>
							<?endif?>
						</div>

						<div class="cart-item-info">
							<!-- Название товара -->
							<div class="bx-basket-item-list-item-name">
								<?if ($v["DETAIL_PAGE_URL"]):?>
									<a href="<?=$v["DETAIL_PAGE_URL"]?>"><?=$v["NAME"]?></a>
								<?else:?>
									<?=$v["NAME"]?>
								<?endif?>
							</div>

							<?if (true):/*$category != "SUBSCRIBE") TODO */?>
								<div class="bx-basket-item-list-item-price-block">
									<!-- Показать цену -->
									<?if ($arParams["SHOW_PRICE"] == "Y"):?>
										<div class="bx-basket-item-list-item-price"><strong><?=$v["PRICE_FMT"]?></strong></div>
										<?if ($v["FULL_PRICE"] != $v["PRICE_FMT"]):?>
											<div class="bx-basket-item-list-item-price-old"><?=$v["FULL_PRICE"]?></div>
										<?endif?>
									<?endif?>

									<!-- Показать общую стоимость товара -->
									<?if ($arParams["SHOW_SUMMARY"] == "Y"):?>
										<div class="bx-basket-item-list-item-price-summ">
											<strong><?=$v["SUM"]?></strong>
											<strong>(<?=$v["QUANTITY"]?> <?=$v["MEASURE_NAME"]?>)</strong>
										</div>
									<?endif?>
								</div>
							<?endif?>
						</div>

						<!-- Кнопка Оформить заказ -->
						<div class="cart-item-controls">
							<div class="btn-cross" onclick="<?=$cartId?>.removeItemFromCart(<?=$v['ID']?>)" title="<?=GetMessage("TSB1_DELETE")?>">
							</div>
						</div>

					</li>
				<?endforeach?>

			<?endforeach?>
		</ul>

		<!-- Кнопка оформить заказ -->
		<?if ($arParams["PATH_TO_ORDER"] && $arResult["CATEGORIES"]["READY"]):?>
			<div class="bx-basket-item-list-button-container">
				<a href="<?=$arParams["PATH_TO_ORDER"]?>" class="btn btn-primary"><?=GetMessage("TSB1_2ORDER")?></a>
			</div>
		<?endif?>

	</div>

	<script>
		BX.ready(function(){
			<?=$cartId?>.fixCart();
		});
	</script>
<?
}