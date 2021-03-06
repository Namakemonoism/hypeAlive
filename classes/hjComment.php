<?php

class hjComment extends hjObject {

	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = "hjcomment";
	}

	public function getURL() {
		$path = implode('/', $this->getAncestry());
		return elgg_get_site_url() . "stream/view/$path";
	}

	public function getEditURL() {
		return elgg_get_site_url() . "ajax/view/framework/alive/comments/form?comment_guid=$this->guid";
	}

	public function getDeleteURL() {
		return elgg_add_action_tokens_to_url(elgg_normalize_url("action/alive/delete?guid=$this->guid"));
	}
	
	public function getOriginalContainer() {
		$check = true;
		$container = $this;
		while ($check) {
			if (!$container instanceof hjComment) {
				$check = false;
			} else {
				$container = $container->getContainerEntity();
			}
		}
		return $container;
	}

	public function getAncestry() {
		$check = true;
		$container = $this;
		$ancestry = array($container->guid);
		while ($check) {
			if (!$container instanceof hjComment) {
				$check = false;
			} else {
				$container = $container->getContainerEntity();
				array_unshift($ancestry, $container->guid);
			}
		}
		return $ancestry;
	}

	public function getDepthToOriginalContainer() {
		$check = true;
		$container = $this;
		$count = 1;
		while ($check) {
			if (!$container instanceof hjComment) {
				$check = false;
			} else {
				$container = $container->getContainerEntity();
				$count = $count + 1;
			}
		}
		return $count;
	}

	public function getOriginalOwner() {
		return $this->findOriginalContainer()->getOwnerEntity();
	}

	public function getSubscribedUsers() {

		$options = array(
			'type' => 'user',
			'relationship' => 'subscribed',
			'relationship_guid' => $this->getOriginalContainer()->guid,
			'inverse_relationship' => true,
			'limit' => 0
		);

		$users = elgg_get_entities_from_relationship($options);

		return $users;
	}
}

