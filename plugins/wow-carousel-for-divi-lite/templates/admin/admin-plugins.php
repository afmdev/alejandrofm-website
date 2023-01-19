<?php

/**
 * Admin main template
 */

defined('ABSPATH') || die();

$dp_plugins  = self::get_plugins();
$base_dp_url = 'https://divipeople.com/';
$url_suffix  = 'plugins/';
?>

<div class="wrap">
	<h1 class="screen-reader-text"><?php esc_html_e('Wow Divi Carousel', 'wdcl-wow-divi-carousel-lite'); ?></h1>
	<div id="wdcl-header-upgrade-message">
		<p><span class="dashicons dashicons-info"></span>
			Thank you for using the free version of <b>Wow Divi Carousel</b>. <a href="https://divipeople.com/wow-divi-carousel/" target="_blank">Upgrade to Pro</a> for create beautiful carousels with Divi layout, Instagam Feed, Posts, Products, etc.</p>
	</div>
	<form class="wdcl-admin" id="wdcl-admin-form">
		<div class="wdcl-admin-header">
			<div class="wdcl-admin-logo-inline">
				<img class="wdcl-logo-icon-size" src="<?php echo WDCL_PLUGIN_ASSETS; ?>imgs/admin/wdcl-logo-white.svg" alt="">
			</div>
			<div class="wdcl-button-wrap">
				<a href="https://divipeople.com/wow-divi-carousel/" target="_blank" class="button wdcl-btn pro wdcl-btn-primary">
					<?php esc_html_e('UPGRADE TO PRO', 'wdcl-wow-divi-carousel-lite'); ?>
				</a>
			</div>
		</div>
		<div class="wdcl-admin-tabs">
			<div class="wdcl-admin-tabs-content">
				<div class="wdcl-admin-panel">
					<div class="wdcl-home-body">
						<div class="about-divi-people">
							<h2>Divi People</h2>
							<p>DiviPeople provides the most secure, stable, feature-rich, and intuitive Divi Extensions. We take pride in ourselves for having helped businesses across 110+ countries to propel to the next level. We are one of the top developers in the area of Divi third-party plugins and have over 25,000+ active customers.</p>
							<h3>Our Creations</h3>
							<p>DiviPeople provides the most secure, stable, feature-rich, and intuitive Divi Plugins. We take pride in ourselves for having helped developers.</p>
						</div>
						<div class="wdcl-adm-plugins">
							<?php

							foreach ($dp_plugins as $dp_plugin) {
								if ('contact-form-7-for-divi' === $dp_plugin['slug']) {
									$url_suffix = '';
								}

							?>
								<div class="wdcl-adm-plugin">
									<figure>
										<img src="<?php echo WDCL_PLUGIN_ASSETS . 'imgs/banners/' . $dp_plugin['slug'] ?>.webp" alt="">
									</figure>
									<div class="wdcl-adm-plugin-content">
										<h3><?php echo $dp_plugin['name']; ?></h3>
										<p><?php echo $dp_plugin['desc']; ?></p>
										<div class="wdcl-adm-plugin-btn">
											<a target="_blank" href="<?php echo $base_dp_url . $url_suffix . $dp_plugin['slug']; ?>">Read More</a>
										</div>
									</div>

								</div>

							<?php }

							?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="wdcl-footer wdcl-row-copyright">
			<h4>WowCarousel from <a href="https://divipeople.com/" target="_blank">Divipeople</a></h4>
		</div>
	</form>
</div>
