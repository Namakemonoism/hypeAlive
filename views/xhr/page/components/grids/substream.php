<?php

elgg_push_context('substream-view');

$entities = elgg_extract('entities', $vars);
$list_options = elgg_extract('list_options', $vars);

$viewer_options = elgg_extract('viewer_options', $vars);
$vars = array_merge($vars, $viewer_options);

$output['list_type'] = $list_options['list_type'];
$output['list_id'] = $vars['list_id'];
$output['head'] = elgg_view('page/components/grids/elements/substream/head', $vars);

$item_class = trim("elgg-item " . elgg_extract('item_class', $list_options, ''));

$output['items'] = array();

if (is_array($entities) && count($entities) > 0) {

	foreach ($entities as $entity) {
		$vars['entity'] = $entity;
		$vars['class'] = $item_class;
		$output['items'][] = elgg_view('page/components/grids/elements/substream/item', $vars);
	}

} else {
	$output['items'][] = '';
}

$show_pagination = elgg_extract('pagination', $list_options, true);

$pagination_type = elgg_extract('pagination_type', $list_options, 'paginate');

if ($show_pagination) {
	$pagination = elgg_view("page/components/grids/elements/pagination/$pagination_type", $vars);
}

$list_id = elgg_extract('list_id', $vars);
$pagination = '<li class="hj-framework-list-pagination-wrapper row-fluid" for="' . $list_id . '">' . $pagination . '</li>';

$output['pagination'] = $pagination;

echo json_encode($output);

elgg_pop_context();