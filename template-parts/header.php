<?php
$logo = TTC_THEME_URI . '/assets/img/logo.png';
$shop = wc_get_page_permalink('shop');
$is_front = is_front_page();
$is_product_nav = function_exists('is_woocommerce') && is_woocommerce();
$is_knowledge_nav = is_page('kinh-nghiem-ky-thuat') || (is_singular('post') && !is_home());
$is_careers_nav = is_page('tuyen-dung');
$nav_items = [
	['Trang chủ', home_url('/'), $is_front],
	['Giới thiệu', home_url('/gioi-thieu/'), is_page('gioi-thieu')],
	['Sản phẩm', $shop, $is_product_nav && !$is_front, 'ttc-nav__product'],
	['Thương hiệu', home_url('/#thuong-hieu'), false],
	['Cẩm nang kỹ thuật', home_url('/kinh-nghiem-ky-thuat/'), $is_knowledge_nav],
	['Tuyển dụng', home_url('/tuyen-dung/'), $is_careers_nav],
	['FAQ', home_url('/faqs/'), is_page('faqs')],
	['Liên hệ', ttc_contact_url(), is_page('lien-he')],
];
?>
<a class="ttc-skip-link" href="#ttc-content">Chuyển đến nội dung chính</a>
<header class="ttc-header">
	<div class="ttc-header__top">
		<div class="ttc-container ttc-header__top-inner">
			<a class="ttc-logo" href="<?php echo esc_url(home_url('/')); ?>">
				<img src="<?php echo esc_url($logo); ?>" alt="TTCTECH" width="154" height="47" />
			</a>

			<button class="ttc-nav-toggle" type="button" aria-expanded="false" aria-controls="ttc-primary-nav">
				<span class="ttc-nav-toggle__icon" aria-hidden="true"><span></span><span></span><span></span></span>
				<span>Menu</span>
			</button>

			<form class="ttc-search" role="search" method="get" action="<?php echo esc_url($shop); ?>">
				<button type="submit" aria-label="Tìm kiếm">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
				</button>
				<input type="search" name="s" placeholder="Tìm kiếm sản phẩm..." value="<?php echo esc_attr(get_search_query()); ?>" />
				<input type="hidden" name="post_type" value="product" />
			</form>

			<div class="ttc-header__meta">
				<a class="ttc-hotline" href="tel:0977020209">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
					<span>
						<em class="ttc-hotline__label">Hotline</em>
						<strong>0977 020 209</strong>
					</span>
				</a>
			</div>
		</div>
	</div>

	<div class="ttc-header__nav">
		<div class="ttc-container ttc-header__nav-inner">
			<nav id="ttc-primary-nav" class="ttc-nav" aria-label="Điều hướng chính">
				<ul class="ttc-nav__list">
					<?php foreach ($nav_items as $item) :
						[$label, $url, $current] = $item;
						$class = $item[3] ?? '';
						if ($current) {
							$class = trim($class . ' current-menu-item');
						}
						?>
						<li class="<?php echo esc_attr($class); ?>">
							<a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		</div>
	</div>
</header>
<div id="ttc-content" tabindex="-1"></div>
