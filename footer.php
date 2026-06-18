	</div>
</section>

<div class="footer-emblems"></div>
<footer>
	<div class="wrapper">
		<div class="menu_cont mb-12">
			<nav id="nav-footer" class="nav-footer" role="navigation">
				<?php leader_dance_render_nav_menu( 'footer-navigation' ); ?>
			</nav>
		</div>
		<div class="row">
			<div class="col">
				<div class="embl_cont">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="На главную страницу">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/emblem.svg' ); ?>" class="emblem" width="208" height="58" alt="Логотип Leader Dance" title="Логотип Leader Dance" />
					</a>
				</div>
				<div class="vcard hcard">
					<?php leader_dance_render_contacts(); ?>
				</div>
			</div>
			<div class="col">
				<p>
					Вся представленная на сайте информация носит информационный характер и не является публичной офертой. Любое использование материалов сайта возможно только с письменного согласия ИП Гливенко Дениса Сергеевича
				</p>
				<p>
					<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">
						Политика конфиденциальности и обработки персональных данных
					</a>
				</p>
				<p>
					2007-<?php echo esc_html( gmdate( 'Y' ) ); ?> © Танцевальный центр «Leader Dance» Астрахань
				</p>
				<p>
					Разработка: <a href="https://shibitov.ru/" target="_blank" rel="noopener noreferrer">JSH</a>
				</p>
			</div>
		</div>
	</div>
</footer>

<a href="https://api.whatsapp.com/send?phone=79272821765" class="wa_button">
	Напишите нам <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/wa.svg' ); ?>" alt="Whatsapp" width="16" height="16" />
</a>

<?php wp_footer(); ?>
</body>
</html>
