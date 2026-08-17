<?php
$items = $args['items'] ?? [];
if (!$items) {
	return;
}
?>
<div class="ttc-toc" data-ttc-toc data-open="false">
	<button
		type="button"
		class="ttc-toc__toggle"
		aria-expanded="false"
		aria-controls="ttc-toc-panel"
	>
		<svg class="ttc-toc__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
			<path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
		<span class="ttc-toc__title">Mục lục bài viết</span>
		<svg class="ttc-toc__chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
			<path d="M7 13l5 5 5-5M7 6l5 5 5-5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
	</button>
	<nav id="ttc-toc-panel" class="ttc-toc__panel" aria-label="Mục lục bài viết">
		<ol class="ttc-toc__list">
			<?php foreach ($items as $item) : ?>
				<li class="ttc-toc__item ttc-toc__item--h<?php echo (int) $item['level']; ?>">
					<a href="#<?php echo esc_attr($item['id']); ?>" data-ttc-toc-link>
						<span class="ttc-toc__num"><?php echo esc_html($item['num']); ?></span>
						<?php echo esc_html($item['text']); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ol>
	</nav>
</div>
