<?php

class wtb_seo_post_saver
{
	/**
	 * generate box to save it
	 * @return \wtb_seo_box
	 */
	public function generateBox()
	{
		$box = new wtb_seo_box();
		
		for ($int = 1; $int <= 3; $int++) {
			$section = new wtb_seo_box_section($int);
			
			// keyword
			$section->keyword = '';
			$inputName = $section->getInfoKey('keyword');
			if (!empty($_POST[$inputName])) {
				$section->keyword = trim($_POST[$inputName]);
			
				$section->density = $this->getFromPostRequest($section->getInfoKey('density'));
				$section->score = $this->getFromPostRequest($section->getInfoKey('score'));
				$section->wdf = $this->getFromPostRequest($section->getInfoKey('wdf'));
				$section->idf = $this->getFromPostRequest($section->getInfoKey('idf'));

				// parameters
				$section->parameters = array();

				$paramsInputName = $section->getInfoKey('checkboxes');
				if (!empty($_POST[$paramsInputName]) and is_array($_POST[$paramsInputName])) {
					$section->parameters = $_POST[$paramsInputName];
				}
			}
			
			$box->addSection($section);
		}
		
		return $box;
	}
	
	/**
	 * get info from POST request array
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	private function getFromPostRequest($key, $default = 0)
	{
		return !empty($_POST[$key]) ? $_POST[$key] : $default;
	}
}
