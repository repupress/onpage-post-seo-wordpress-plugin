<?php

class wtb_seo_box_section 
{
	/**
	 * section nummer in box
	 * @var int
	 */
	protected $section_no;
	
	/**
	 * sections keyword
	 * @var string
	 */
	public $keyword;
	
	/**
	 * score of section keyword
	 * @var string
	 */
	public $score;
	
	/**
	 * keyword density
	 * @var string
	 */
	public $density;

	/**
	 * section tips array
	 * @var array
	 */
	public $parameters;

	/**
	 * perfect keyword density, which gives max points to score
	 * @var int
	 */
	public $perfectDensity = 3;

	/**
	 * IDF - Inverse-document Frequency
	 * @var float
	 */
	public $idf;

	/**
	 * WDF - Within-document Frequency
	 * @var float
	 */
	public $wdf;

	/**
	 * constructor
	 * @param int $section_no
	 */
	public function __construct($section_no)
	{
		$this->section_no = (int)$section_no;
		
		if (get_option('wtb_seo_ideal_density') !== FALSE) {
			$this->perfectDensity = get_option('wtb_seo_ideal_density');
		}
	}
	
	/**
	 * get key to use in database and html inputs for each param of section
	 * @param string $label
	 * @return string
	 */
	public function getInfoKey($label)
	{
		return 'wtb_seo_' . $label . '_' . $this->getNo();
	}
	
	/**
	 * display section
	 */
	public function display()
	{
		if (!empty($this->keyword)) {
			require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR
				. 'section.php';
		}
	}
	
	/**
	 * return all names of parameter
	 * @return array
	 */
	function getParamsNames()
	{
		return array(
			'title' => array(
				'no'  => __('There is no keyword in title', 'wtb_seo'),
				'yes' => __('There is keyword in title', 'wtb_seo'),
				),
			'h1' => array(
				'no'  => __('You do not have an H1 tag containing your keyword', 'wtb_seo'),
				'yes' => __('You have an H1 tag containing your keyword', 'wtb_seo'),
				),
			'h2' => array(
				'no'  => __('You do not have an H2 tag containing your keyword', 'wtb_seo'),
				'yes' => __('You have an H2 tag containing your keyword', 'wtb_seo'),
				),
			'h3' => array(
				'no'  => __('You do not have an H3 tag containing your keyword', 'wtb_seo'),
				'yes' => __('You have an H3 tag containing your keyword', 'wtb_seo'),
				),
			'bold' => array(
				'no'  => __('Your keyword is not in bold', 'wtb_seo'),
				'yes' => __('Your keyword is in bold', 'wtb_seo'),
				),
			'italic' => array(
				'no'  => __('Your keyword is not italicized', 'wtb_seo'),
				'yes' => __('Your keyword is italicized', 'wtb_seo'),
				),
			'underline' => array(
				'no'  => __('Your keyword is not underlined', 'wtb_seo'),
				'yes' => __('Your keyword is in underline', 'wtb_seo'),
				),
			'alt' => array(
				'no'  => __('Your keyword is not in image alt tag', 'wtb_seo'),
				'yes' => __('Your keyword is in image alt tag', 'wtb_seo'),
				)
		);
	}
	
	function isParamAllowed($param)
	{
		$settings = get_option('wtb_seo_main', array());
		$cptSettings = !empty($settings['to_check']) ? (array)$settings['to_check'] : array();
		
		if (!empty($cptSettings)) {
			if (!empty($cptSettings[$param])) {
				return true;
			}
			return !array_key_exists($param, $cptSettings);
		}
		return true;
	}
	
	/**
	 * save current keyword box section
	 */
	public function save($postID)
	{
		// sanitize user input
		$this->keyword    = sanitize_text_field( $this->keyword );
		$this->score      = sanitize_text_field( $this->score );
		$this->density    = sanitize_text_field( $this->density );
		if (!is_array($this->parameters)) {
			$this->parameters = array();
		}

		if (!add_post_meta($postID, $this->getInfoKey('score'), $this->score, true)) {
			update_post_meta($postID, $this->getInfoKey('score'), $this->score);
		}
		
		if (!add_post_meta($postID, $this->getInfoKey('keyword'), $this->keyword, true)) {
			update_post_meta($postID, $this->getInfoKey('keyword'), $this->keyword);
		}
		
		if (!add_post_meta($postID, $this->getInfoKey('density'), $this->density, true)) {
			update_post_meta($postID, $this->getInfoKey('density'), $this->density);
		}
		
		if (!add_post_meta($postID, $this->getInfoKey('checkboxes'), json_encode($this->parameters), true)) {
			update_post_meta($postID, $this->getInfoKey('checkboxes'), json_encode($this->parameters));
		}
		
		return true;
	}
	
	/**
	 * return number of section in box
	 * @return string
	 */
	function getNo()
	{
		return $this->section_no;
	}
	
	/**
	 * get density class name to get required color
	 * @return string
	 */
	function getDensityColor()
	{
		$densityDiffFromIdeal = ($this->density/$this->perfectDensity) * 100;
		
		if ($densityDiffFromIdeal > 115 or $densityDiffFromIdeal < 70) {
			return 'density-bad';
		} else if ($densityDiffFromIdeal > 110 or $densityDiffFromIdeal < 90) {
			return 'density-not-bad';
		}
		
		return 'density-ok';
	}
	
	/**
	 * get score class name to get required color
	 * @return string
	 */
	function getScoreColor()
	{
		if ($this->score >= 90) {
			return 'score-ok';
		} else if ($this->score >= 80) {
			return 'score-not-bad';
		}
		return 'score-bad';
	}
	
	/**
	 * return all description of general parameter
	 * @return array
	 */
	function getParamsDescriptions()
	{
		return array(
			'title' => __('For good rankings, your keyword should also be in the title of your page or your post.', 'wtb_seo'),
			'h1' => __('For good rankings  there should be a H1 tag containing the Keyword.', 'wtb_seo'),
			'h2' => __('For good rankings there should be 1 up to 2  H2 tag containing the Keyword. ', 'wtb_seo'),
			'h3' => __('For good rankings there should be at least 1 up to 3 H3 tag containing the Keyword.', 'wtb_seo'),
			'bold' => __('Search engines take highlighted words for more important. That’s why you should at least once use your keyword in bold.', 'wtb_seo'),
			'italic' => __('Search engines take highlighted words for more important. That’s why you should at least once italicize your keyword .', 'wtb_seo'),
			'underline' => __('Search engines take highlighted words for more important. That’s why you should at least once underline your keyword.', 'wtb_seo'),
			'alt' => __('It is good to have an image on your page. Use the alt tag of the image to place your keyword for search engines.', 'wtb_seo'),
		);
	}
	
	/**
	 * 
	 * @param string $key
	 * @return string
	 */
	function getParamsDescription($key)
	{
		$desc = $this->getParamsDescriptions();
		return !empty($desc[$key]) ? $desc[$key] : '';
	}
}
