<?php

class wtb_seo_wp_slot
{
	/**
	 * current wordpress post
	 * @var WP_Post
	 */
	private $post;
	
	/**
	 * constructor which sets current wordpress post
	 * @param WP_Post $post
	 */
	public function __construct($post)
	{
		$this->post = $post;
	}
	
	/**
	 * get post metadata from database
	 * @param string $key
	 * @return string
	 */
	private function getMetaData($key)
	{
		return get_post_meta( $this->post->ID, $key, true );
	}
	
	/**
	 * check or we creating new page or we only editing existing
	 * @global string $pagenow
	 * @return bool
	 */
	private function isNewPage()
	{
		global $pagenow;
		return in_array( $pagenow, array( 'post-new.php' ) );
	}
	
	/**
	 * generate box to show in box on post edit page
	 * @return \wtb_seo_box
	 */
	public function generateBox()
	{
		$box = new wtb_seo_box();
		
		if ($this->isNewPage()) {
			$box->showErrorOnEmptyTitle = $this->isNewPage();
			$box->showErrorOnEmptyContent = $this->isNewPage();
		} else {
			for ($int = 1; $int <= 3; $int++) {
				
				$section = $this->getSection($int);
				
				// ohne title gehen wir nicht weiter
				
				if ($section) {
					$box->addSection($section);
				}
			}
		}
		
		return $box;
	}
	
	public function getSection($int)
	{
		$section = new wtb_seo_box_section($int);

		$section->keyword = esc_attr($this->getMetaData($section->getInfoKey('keyword')));
		if (empty($section->keyword)) {
			return false;
		}

		$section->density = esc_attr($this->getMetaData($section->getInfoKey('density')));
		$section->score = esc_attr($this->getMetaData($section->getInfoKey('score')));
		$section->wdf = esc_attr($this->getMetaData($section->getInfoKey('wdf')));
		$section->idf = esc_attr($this->getMetaData($section->getInfoKey('idf')));

		$section->parameters = array();

		$params = (array)json_decode($this->getMetaData($section->getInfoKey('checkboxes')));
		if (!is_array($params) or empty($params)) {
			$params = array();
		}

		foreach ($params as $key => $value) {
			$section->parameters[$key] = $value;
		}
		
		return $section;
	}
}
