<?php

/**
 *  Display the comments bar with all comments and likes
 *
 *  @uses $vars['entity'] Entity that is being commented on
 *  @uses $vars['aname'] Name of the annotation generic_comment|group_topic_post
 */

$entity = elgg_extract('entity', $vars, false);

if (!$entity) {
	return true;
}

$params = hj_alive_prepare_view_params($entity);

$menu = elgg_view_menu('interactions', array(
	'entity' => $params['entity'],
	'class' => 'elgg-menu-hz elgg-menu-comments elgg-menu-replies',
	'sort_by' => 'priority',
	'params' => $params,
		));

$replies = elgg_view('framework/alive/replies/replies', $params);
$likes = elgg_view('framework/alive/likes/wrapper', $params);

$params['menu'] = $menu;
$params['replies'] = $replies;
$params['likes'] = $likes;

echo elgg_view('framework/alive/replies/wrapper', $params);
