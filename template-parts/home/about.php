<?php
$about = ttc_home_about();
?>
<section class="ttc-home-section ttc-home-about">
	<div class="ttc-container">
		<div class="ttc-home-section__head">
			<h2>Về chúng tôi</h2>
			<p><?php echo esc_html($about['intro']); ?></p>
		</div>
		<div class="ttc-home-about__grid">
			<div class="ttc-home-about__media">
				<img class="ttc-home-about__img" src="<?php echo esc_url($about['image']); ?>" alt="Đội ngũ kỹ thuật TTCTECH" loading="lazy" decoding="async" width="560" height="440" />
			</div>
			<div class="ttc-home-about__copy">
				<h3 class="ttc-home-about__subtitle"><?php echo esc_html($about['mission_title']); ?></h3>
				<p class="ttc-home-about__body"><?php echo esc_html($about['mission_body']); ?></p>

				<div class="ttc-home-about__values">
					<p class="ttc-home-about__values-title"><?php echo esc_html($about['values_title']); ?></p>
					<ul>
						<?php foreach ($about['values'] as [$title, $desc]) : ?>
							<li>
								<span class="ttc-home-about__values-icon" aria-hidden="true">
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
								</span>
								<span class="ttc-home-about__values-text">
									<strong><?php echo esc_html($title); ?></strong>
									<em><?php echo esc_html($desc); ?></em>
								</span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="ttc-home-about__stats">
					<?php foreach ($about['stats'] as [$num, $label]) : ?>
						<div>
							<strong><?php echo esc_html($num); ?></strong>
							<span><?php echo esc_html($label); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
				<a class="ttc-btn ttc-btn--primary" href="<?php echo esc_url(home_url('/gioi-thieu/')); ?>">Tìm hiểu thêm</a>
			</div>
		</div>
	</div>
</section>
