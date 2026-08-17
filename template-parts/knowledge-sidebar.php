<?php
/** Knowledge sidebar supplied by TTCTech Addons widgets. */
?>
<aside class="ttc-knowledge-sidebar">
	<?php
	$sidebar_widgets = wp_get_sidebars_widgets()['sidebar-1'] ?? [];
	$has_ttctech_widgets = array_filter(
		$sidebar_widgets,
		static fn ($id) => str_starts_with($id, 'ttctech_knowledge_')
	);

	if ($has_ttctech_widgets) {
		dynamic_sidebar('sidebar-1');
	} elseif (
		class_exists('TTCTech_Knowledge_Catalog_Widget') &&
		class_exists('TTCTech_Knowledge_Popular_Widget')
	) {
		$widget_args = ['before_widget' => '', 'after_widget' => ''];
		the_widget('TTCTech_Knowledge_Catalog_Widget', [], $widget_args);
		the_widget('TTCTech_Knowledge_Popular_Widget', ['number' => 3], $widget_args);
	}
	?>
</aside>
