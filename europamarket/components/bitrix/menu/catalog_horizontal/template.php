<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

// todo: кнопка вызова каталога

//todo: пункты меню

$this->setFrameMode(true);

if (empty($arResult["ALL_ITEMS"]))
	return;

if (file_exists($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css'))
	$APPLICATION->SetAdditionalCSS($this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css');

$menuBlockId = "catalog_menu_".$this->randString();
?>
<div class="container" id="<?=$menuBlockId?>">
	<ul id="ul_<?=$menuBlockId?>" class="main-categories row row-stretch row-between">
		<!-- first level-->
		<?foreach($arResult["MENU_STRUCTURE"] as $itemID => $arColumns):?>
			<?$existPictureDescColomn = ($arResult["ALL_ITEMS"][$itemID]["PARAMS"]["picture_src"] || $arResult["ALL_ITEMS"][$itemID]["PARAMS"]["description"]) ? true : false;?>
			<li onmouseover="BX.CatalogMenu.itemOver(this);" onmouseout="BX.CatalogMenu.itemOut(this)"
			    class="main-link <?if($arResult["ALL_ITEMS"][$itemID]["SELECTED"]):?>current<?endif?><?if (is_array($arColumns) && count($arColumns) > 0):?> bx_dropdown<?endif?>">

				<a href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>"
				   <?if (is_array($arColumns) && count($arColumns) > 0 && $existPictureDescColomn):?>
					   onmouseover="obj_<?=$menuBlockId?>.changeSectionPicure(this);"<?endif?>
				   title="Перейти в раздел">
					<svg class="svg-sprite-icon <?=$arItem["PARAMS"]["SVG"]?>-icon">
						<use xlink:href="#<?=$arItem["PARAMS"]["SVG"]?>"></use>
					</svg>
					<?=$arResult["ALL_ITEMS"][$itemID]["TEXT"]?>
				</a>

				<?if (is_array($arColumns) && count($arColumns) > 0):?>
					<span style="display: none">
						<?=$arResult["ALL_ITEMS"][$itemID]["PARAMS"]["description"]?>
					</span>
					<span class="bx_children_advanced_panel animate">
						<img src="<?=$arResult["ALL_ITEMS"][$itemID]["PARAMS"]["picture_src"]?>" alt="">
					</span>


					<!-- second level-->
					<div class="bx_children_container b<?=($existPictureDescColomn) ? count($arColumns)+1 : count($arColumns)?> animate">
						<?foreach($arColumns as $key=>$arRow):?>
							<div class="bx_children_block">
								<ul>
									<?foreach($arRow as $itemIdLevel_2=>$arLevel_3):?>
										<li class="parent">
											<a href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>"
											   <?if ($existPictureDescColomn):?>ontouchstart="document.location.href = '<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>';"
											   onmouseover="obj_<?=$menuBlockId?>.changeSectionPicure(this);"<?endif?>
											   data-picture="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["PARAMS"]["picture_src"]?>"
											   title="Перейти в раздел">
												<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["TEXT"]?>
											</a>
							<span style="display: none">
								<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["PARAMS"]["description"]?>
							</span>
							<span class="bx_children_advanced_panel animate">
								<img src="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["PARAMS"]["picture_src"]?>" alt="">
							</span>

									<!-- third level-->
									<?if (is_array($arLevel_3) && count($arLevel_3) > 0):?>
										<ul>
											<?foreach($arLevel_3 as $itemIdLevel_3):?>
												<li>
													<a href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["LINK"]?>" <?if ($existPictureDescColomn):?>ontouchstart="document.location.href = '<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>';return false;" onmouseover="obj_<?=$menuBlockId?>.changeSectionPicure(this);return false;"<?endif?> data-picture="<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["PARAMS"]["picture_src"]?>">
														<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["TEXT"]?>
													</a>
									<span style="display: none">
										<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["PARAMS"]["description"]?>
									</span>
									<span class="bx_children_advanced_panel animate">
										<img src="<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["PARAMS"]["picture_src"]?>" alt="">
									</span>
														</li>
													<?endforeach;?>
												</ul>
											<?endif?>
										</li>
									<?endforeach;?>
								</ul>
							</div>
						<?endforeach;?>
						<?if ($existPictureDescColomn):?>
							<div class="bx_children_block advanced">
								<div class="bx_children_advanced_panel">
						<span class="bx_children_advanced_panel animate">
							<a href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>"><span class="bx_section_picture">
								<img src="<?=$arResult["ALL_ITEMS"][$itemID]["PARAMS"]["picture_src"]?>"  alt="">
							</span></a>
							<img src="<?=$this->GetFolder()?>/images/spacer.png" alt="" style="border: none;">
							<strong><?=$arResult["ALL_ITEMS"][$itemID]["TEXT"]?></strong><span class="bx_section_description bx_item_description"><?=$arResult["ALL_ITEMS"][$itemID]["PARAMS"]["description"]?></span>
						</span>
								</div>
							</div>
						<?endif?>
						<div style="clear: both;"></div>
					</div>
				<?endif?>
			</li>
		<?endforeach;?>
	</ul>
	<div style="clear: both;"></div>
</div>

<script>
	BX.ready(function () {
		window.obj_<?=$menuBlockId?> = new BX.Main.Menu.CatalogHorizontal('<?=CUtil::JSEscape($menuBlockId)?>');
	});
</script>