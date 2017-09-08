<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<section class="order-callback hidden-sm">
	<div class="container">
		<div class="row">
			<div class="col-8 col-offset-2 no-gutter">
				<h2 class="title">
					Требуется помощь?
				</h2>
				<div class="callback-form">
					<p class="form-description">
						Оставьте заявку на звонок нашего менеджера, и он перезвонит через 5 минут
					</p>
					<form action="send_form_handler.php" class="horizontal-form">
						<div class="form-group">
							<div class="input-group error-input">
								<input class="form-control" type="text" placeholder="Как к Вам обращаться?" value="">
								<div class="error-msg">
									Проверьте правильность введенного значения поля
								</div>
							</div>
							<div class="input-group">
								<input class="form-control" type="text" placeholder="Введите номер телефона" value="">
							</div>
							<div class="input-group">
								<input class="btn btn-default btn-md" value="Позвоните мне" type="submit">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>