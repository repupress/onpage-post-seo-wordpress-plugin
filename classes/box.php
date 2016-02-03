<?php

class wtb_seo_box
{
	/**
	 * box sections array
	 * @var array
	 */
	protected $_sections = array();
	
	/**
	 * general box tips array
	 * @var array
	 */
	public $parameters = array();

	/**
	 * or we need to show error on empty title
	 * @var bool
	 */
	public $showErrorOnEmptyTitle = false;

	/**
	 * or we need to show error on empty content
	 * @var bool
	 */
	public $showErrorOnEmptyContent = false;
	
	/**
	 * article lenght
	 */
	public $articleLenght = 0;

	/**
	 * render and print only box header
	 */
	public function printHeader()
	{
		require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR
				. 'box_header.php';
	}
	
	/**
	 * render and print only box general section
	 */
	public function printGeneral()
	{
		if (!empty($this->parameters) and empty($this->showErrorOnEmptyContent)) {
			require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR
					. 'general.php';
		}
	}
    
    /**
     * get html class name for box
     * @return string
     */
    function getScoreColor($score)
	{
		if ($score >= 90) {
			return 'score-ok';
		} else if ($score >= 80) {
			return 'score-not-bad';
		}
		return 'score-bad';
	}
    
    /**
     * get html class name for general density
     * @return string
     */
    function getDensityColor($density)
	{
        $perfectDensity = $this->getPerfectDensity();
		$densityDiffFromIdeal = ($density/$perfectDensity) * 100;
		
		if ($densityDiffFromIdeal > 115 or $densityDiffFromIdeal < 70) {
			return 'density-bad';
		} else if ($densityDiffFromIdeal > 110 or $densityDiffFromIdeal < 90) {
			return 'density-not-bad';
		}
		
		return 'density-ok';
	}
    
    function getPerfectDensity()
    {
        $pd = 3;
        
        if (count($this->_sections)) {
            foreach ($this->_sections as $sect) {
                $pd = $sect->perfectDensity;
                break;
            }
        } else {
            if (get_option('wtb_seo_ideal_density') !== FALSE) {
                $pd = get_option('wtb_seo_ideal_density');
            }
        }
        
        if ($pd == 0) {
            $pd = 3;
        }
        
        return $pd;
    }
	
	/**
	 * render and print only sections
	 */
	public function printSections()
	{
		$this->printGeneral();
        
		echo '<div id="wtb-seo-accordion">';
		
		foreach ($this->_sections as $section) {
			$section->display();
		}
		
		echo '</div>';
	}

	/**
	 * add keyword section to box
	 * @param wtb_seo_box_section $section
	 */
	public function addSection(wtb_seo_box_section $section)
	{
		$this->_sections[] = $section;
	}
	
	/**
	 * count keyword sections
	 */
	public function countSection()
	{
		return count($this->_sections);
	}
	
	/**
	 * save all to database
	 * @param int $post_ID
	 */
	public function save($post_ID)
	{
		foreach ($this->_sections as $section) {
			$section->save($post_ID);
		}
	}
	
	/**
	 * return rendered box
	 * @return string
	 */
	public function render()
	{
		ob_start();

		echo '<div id="wtb-seo-box">';
		$this->printHeader();
		
		// display sections
		$this->printSections();
		echo '</div>';
		
		$out = ob_get_contents();

		ob_end_clean();
		
		return $out;
	}
	
	/**
	 * display rendered box
	 */
	public function display()
	{
		echo $this->render();
	}
	
	/**
	 * return all names of general parameter
	 * @return array
	 */
	function getParamsNames()
	{
		return array(
			'images' => array(
				'0no'  => __('You do not have an image to add ALT tags', 'wtb_seo'),
				'1yes' => __('You have an image to add ALT tags to', 'wtb_seo'),
				),
			'lenght' => array(
				'0no'  => vsprintf(
							__('The text is not long enough. Please write %s words more.', 'wtb_seo'), 
							(get_option('wtb_seo_ideal_lenght') !== FALSE ? get_option('wtb_seo_ideal_lenght') : 250) - $this->articleLenght
						),
				'1yes' => __('The text is long enough', 'wtb_seo'),
			),
			'intern' => array(
				'0no'  => __('Internal Links are missing', 'wtb_seo'),
				'1yes' => __('Internal Links are here', 'wtb_seo'),
			),
			'h1' => array(
				'0tooMany'  => __('You have too many H1 tags', 'wtb_seo'),
				'0no' =>  __('You have no H1 tag', 'wtb_seo'),
				'1yes' => __('You have one H1 tag', 'wtb_seo'),
			),
			'h2' => array(
				'0tooMany'  => __('You have too many H2 tags', 'wtb_seo'),
				'0no'  => __('You dont have H2 tags', 'wtb_seo'),
				'1yes' => __('You have enough H2 tags', 'wtb_seo'),
			),
			'h3' => array(
				'0no'  => __('You dont have H3 tags', 'wtb_seo'),
				'0tooMany'  => __('You have too many H3 tags', 'wtb_seo'),
				'1yes' => __('You have enough H3 tags', 'wtb_seo'),
			),
		);
	}
	
	/**
	 * return all description of general parameter
	 * @return array
	 */
	function getParamsDescriptions()
	{
		return array(
			'images' => __('It’s adjuvant  to have an image in your post or on your page. It’s useful for visitors and increases your chance to be found in Google images.', 'wtb_seo'),
			'lenght' => __('Search engines prefer text with a minimum length of 250 words.', 'wtb_seo'), 
			'intern' => __('Use internal links to older content with similar subject on your domain, to optimize your internal structure.', 'wtb_seo'),
			'h1' => __('Search engines expect exact one H1 tag on each page. There should be only one H1 tag on each page, but there should be one!', 'wtb_seo'),
			'h2' => __('You should use H2 tags in your post or on your page to help search engines crawling your page. Use one or two H2 tags for optimum.', 'wtb_seo'),
			'h3' => __('You should use H3 tags on your page. Use up to four H3 tags on one page.', 'wtb_seo'),
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
