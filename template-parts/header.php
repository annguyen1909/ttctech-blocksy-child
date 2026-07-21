<?php
$quote = ttc_quote_url();
$account = wc_get_page_permalink('myaccount');
$logo = TTC_THEME_URI . '/assets/img/logo.png';
?>
<header class="ttc-header">
	<div class="ttc-header__top">
		<div class="ttc-container ttc-header__top-inner">
			<a class="ttc-logo" href="<?php echo esc_url(home_url('/')); ?>">
				<img src="<?php echo esc_url($logo); ?>" alt="TTCTECH" width="154" height="47" />
			</a>

			<form class="ttc-search" role="search" method="get" action="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">
				<input type="search" name="s" placeholder="Tìm kiếm sản phẩm..." value="<?php echo esc_attr(get_search_query()); ?>" />
				<input type="hidden" name="post_type" value="product" />
				<button type="submit" aria-label="Tìm kiếm">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
				</button>
			</form>

			<div class="ttc-header__meta">
				<a class="ttc-hotline" href="tel:02462931272">
					<span class="ttc-hotline__label">ĐƯỜNG DÂY NÓNG 24/7</span>
					<strong>024 6293 1272</strong>
				</a>
				<a class="ttc-icon-link" href="<?php echo esc_url($account); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
					Tài khoản
				</a>
			</div>
		</div>
	</div>

	<div class="ttc-header__nav">
		<div class="ttc-container ttc-header__nav-inner">
			<button class="ttc-nav-toggle" type="button" aria-expanded="false" aria-controls="ttc-primary-nav">Danh mục</button>
			<nav id="ttc-primary-nav" class="ttc-nav" aria-label="Điều hướng chính">
				<?php
				if (has_nav_menu('ttc_primary')) {
					wp_nav_menu([
						'theme_location' => 'ttc_primary',
						'container' => false,
						'menu_class' => 'ttc-nav__list',
						'depth' => 2,
						'fallback_cb' => false,
					]);
				}
				?>
			</nav>
			<a class="ttc-btn ttc-btn--accent" href="<?php echo esc_url($quote); ?>">Yêu cầu báo giá</a>
		</div>
	</div>
</header>
