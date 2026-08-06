<?php
$projects = ttc_home_projects();
?>
<section class="ttc-home-section ttc-home-projects" id="du-an">
	<div class="ttc-container">
		<div class="ttc-home-section__head">
			<p class="ttc-home-eyebrow">Giải pháp gia công của TTCTECH</p>
			<h2>Dự án tiêu biểu</h2>
			<p>Một số hạng mục TTCTECH đã đồng hành cùng khách hàng trong gia công và trang bị dụng cụ.</p>
		</div>
		<ul class="ttc-home-projects__grid">
			<?php foreach ($projects as $project) : ?>
				<li class="ttc-home-project">
					<a class="ttc-home-project__media" href="<?php echo esc_url($project['url']); ?>">
						<img src="<?php echo esc_url($project['img']); ?>" alt="<?php echo esc_attr($project['title']); ?>" loading="lazy" decoding="async" />
					</a>
					<div class="ttc-home-project__body">
						<h3><?php echo esc_html($project['title']); ?></h3>
						<p><?php echo esc_html($project['excerpt']); ?></p>
						<div class="ttc-home-project__metrics">
							<div class="ttc-home-project__metric">
								<strong><?php echo esc_html($project['stat']); ?></strong>
								<span><?php echo esc_html($project['stat_label']); ?></span>
							</div>
							<div class="ttc-home-project__metric ttc-home-project__metric--muted">
								<strong><?php echo esc_html($project['days']); ?></strong>
								<span><?php echo esc_html($project['days_label']); ?></span>
							</div>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="ttc-home-section__cta">
			<a class="ttc-btn ttc-btn--primary" href="<?php echo esc_url(home_url('/#du-an')); ?>">Xem tất cả dự án</a>
		</div>
	</div>
</section>
