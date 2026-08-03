<?php
$account = wc_get_page_permalink('myaccount');
$logo = TTC_THEME_URI . '/assets/img/logo.png';
$is_product_nav = function_exists('is_woocommerce') && is_woocommerce();
$is_knowledge_nav = is_home() || is_singular('post') || is_category();
$is_careers_nav = is_page('tuyen-dung');
$is_faq_nav = is_page('faqs');
$nav_items = [
	['Trang chủ', home_url('/'), ''],
	['Giới thiệu', home_url('/gioi-thieu/'), ''],
	['Sản phẩm', wc_get_page_permalink('shop'), 'ttc-nav__product'],
	['Kiến thức kỹ thuật', home_url('/kinh-nghiem-ky-thuat/'), ''],
	['Tuyển dụng', home_url('/tuyen-dung/'), ''],
	['FAQs', home_url('/faqs/'), ''],
	['Liên hệ', ttc_contact_url(), ''],
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

			<form class="ttc-search" role="search" method="get" action="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">
				<input type="search" name="s" placeholder="Bạn tìm kiếm sản phẩm gì hôm nay..." value="<?php echo esc_attr(get_search_query()); ?>" />
				<input type="hidden" name="post_type" value="product" />
				<button type="submit" aria-label="Tìm kiếm">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
				</button>
			</form>

			<div class="ttc-header__meta">
				<a class="ttc-hotline" href="tel:02462931272">
					<span class="ttc-hotline__icon" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.62 2.63a2 2 0 0 1-.45 2.11L8 9.73a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.85.29 1.73.5 2.63.62A2 2 0 0 1 22 16.92z"/></svg>
					</span>
					<span>
						<span class="ttc-hotline__label">Hotline</span>
						<strong>02462931272</strong>
					</span>
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
			<nav id="ttc-primary-nav" class="ttc-nav" aria-label="Điều hướng chính">
				<ul class="ttc-nav__list">
					<?php foreach ($nav_items as [$label, $url, $class]) : ?>
						<li class="<?php echo esc_attr($class . ($label === 'Sản phẩm' && $is_product_nav ? ' current-menu-item' : '') . ($label === 'Kiến thức kỹ thuật' && $is_knowledge_nav ? ' current-menu-item' : '') . ($label === 'Tuyển dụng' && $is_careers_nav ? ' current-menu-item' : '') . ($label === 'FAQs' && $is_faq_nav ? ' current-menu-item' : '')); ?>">
							<a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		</div>
	</div>
</header>
<div id="ttc-content" tabindex="-1"></div>
