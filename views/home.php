<div class="row header justify-content-center">
	<div class="row no-gutters imgRow">
		<!-- генерация страницы по роли -->
		<?php foreach ($roles as $role) : ?>
			<?php if (strcasecmp($role, 'regular') == 0) : ?>
				<div class="row no-gutters imgRow">
					<h1>Страница для обычного пользователя</h1>
				</div>
				<div class="row no-gutters imgRow">
					<div class="col-12  d-flex justify-content-center my-auto imgCol">
						<img src="<?php echo URL . UPLOAD_DIR . '/' . 'Beach.jpg'; ?>" class="img-thumbnail" alt="Картинка для обычного пользователя">
					</div>
					<div>
					<?php endif; ?>
					<?php if (strcasecmp($role, 'vk') == 0) : ?>
						<div class="row no-gutters imgRow">
							<h1>Страница для пользователя VK</h1>
						</div>
						<div class="row no-gutters imgRow">
							<div class="col-12  d-flex justify-content-center my-auto imgCol">
								<img src="<?php echo URL . UPLOAD_DIR . '/' . 'Monkey.jpg'; ?>" class="img-thumbnail" alt="Картинка для пользователя VK">
							</div>
							<div>
							<?php endif; ?>
						<?php endforeach; ?>
							</div>
						</div>