<?php

class wtb_seo_calculator
{
	/**
	 * post request
	 * @var array
	 */
	private $post;
	
	/**
	 * ideal post content lenght
	 * @var int
	 */
	private $idealPostLenght = 250;
	
	/**
	 * constructor with given POST array
	 * @param array $post
	 */
	public function __construct($post)
	{
		$this->post = $post;
		
        $this->post['content'] = do_shortcode($this->post['content']);
        
		$this->post['content'] = wtb_seo_helper::strtolower($this->post['content']);
		
		if (get_option('wtb_seo_ideal_lenght') !== FALSE) {
			$this->idealPostLenght = get_option('wtb_seo_ideal_lenght');
		}
	}
	
	/**
	 * generate box by POST info
	 * @return wtb_seo_box
	 */
	public function generateBox()
	{
		$box = new wtb_seo_box();

		if (empty($this->post['title'])) {
			$box->showErrorOnEmptyTitle = true;
		}
		
		if (empty($this->post['content']) or !$this->getTotalWordCount()) {
			$box->showErrorOnEmptyContent = true;
		}
		
		$box->articleLenght = $this->getTotalWordCount();
		
		if (!empty($this->post['content'])) {
			// check box params
			$this->calcGeneralTipps($box);
		}

		$int = 0;
		if (!empty($this->post['keywords'])) {
			foreach ($this->post['keywords'] as $keyword) {
				$int++;

				$keyword = wtb_seo_helper::strtolower(trim($keyword));

				$section = new wtb_seo_box_section($int);
				$section->keyword = $keyword;

				$section->density = $this->calcDensity($keyword);
				$section->parameters = $this->calcParams($keyword);

				$section->wdf = $this->calcWdf($section);
//				$section->idf = $this->calcIdf($section);
				
				$section->score = $this->calcScore($section);

				$box->addSection($section);
			}
		}
		
		return $box;
	}
	
	/**
	 * calculate general tipps
	 * @param wtb_seo_box $box
	 */
	protected function calcGeneralTipps($box)
	{
		$html = str_get_html($this->post['content']);
		
		// img
		$box->parameters['images'] = '0no';
		if (count($html->find('img')) > 0) {
			$box->parameters['images'] = '1yes';
		}
		
		// h1
		if (!empty($this->post['title'])) {
			$box->parameters['h1'] = '1yes';
			if (count($html->find('h1')) > 0) {
				$box->parameters['h1'] = '0tooMany';
			}
		} else {
			$box->parameters['h1'] = '0no';
			if (count($html->find('h1')) == 1) {
				$box->parameters['h1'] = '1yes';
			} else if (count($html->find('h1')) > 1) {
				$box->parameters['h1'] = '0tooMany';
			}
		}
		
		// h2
		if (count($html->find('h2')) == 0) {
			$box->parameters['h2'] = '0no';
		} else if (count($html->find('h2')) <= 2) {
			$box->parameters['h2'] = '1yes';
		} else {
			$box->parameters['h2'] = '0tooMany';
		}
		
		// h3
		if (count($html->find('h3')) == 0) {
			$box->parameters['h3'] = '0no';
		} else if (count($html->find('h3')) <= 5) {
			$box->parameters['h3'] = '1yes';
		} else {
			$box->parameters['h3'] = '0tooMany';
		}
		
		// lenght
		$box->parameters['lenght'] = '1yes';
		if ($this->getTotalWordCount() < $this->idealPostLenght) {
			$box->parameters['lenght'] = '0no';
		}
		
		// intern
		$box->parameters['intern'] = '0no';
		if ($this->countInternLinks() > 0) {
			$box->parameters['intern'] = '1yes';
		}
		
	}

	/**
	 * count the number of internal links
	 * @return int
	 */
	private function countInternLinks()
	{
		$html = str_get_html($this->post['content']);
		
		$count = 0;
		
		foreach ($html->find('a') as $value) {
			if (strpos(strtolower($value->href), get_bloginfo('url')) !== false) {
				$count++;
			}
		}
		
		return $count;
	}
	
	/**
	 * get the number of total words in content
	 * @return int
	 */
	private function getTotalWordCount()
	{
		return wtb_seo_helper::getWordCount($this->post['content']);
	}

	/**
	 * get keywords count in current document
	 * @param string $keyword
	 * @return int
	 */
	protected function getKeywordsCount($keyword)
	{
		$found = 0;
		
		str_replace($keyword, '', $this->post['content'], $found);
		
		return $found;
	}
	
	/**
	 * calc keyword density
	 * @param string $keyword
	 * @return float
	 */
	protected function calcDensity($keyword)
	{
		$total = $this->getTotalWordCount();
		if ($total == 0) {
			return 0;
		}
		
		$found = $this->getKeywordsCount($keyword);
		
		return number_format(100*$found/ $total, 2);
	}
	
	/**
	 * calc section params by keyword
	 * @param string $keyword
	 * @return array
	 */
	protected function calcParams($keyword)
	{
		$params = array(
			'title' => 0,
			'h1' => 0,
			'h2' => 0,
			'h3' => 0,
			'bold' => 0,
			'italic' => 0,
			'underline' => 0,
			'alt' => 0,
		);

		$title = wtb_seo_helper::strtolower($this->post['title']);
		$content = $this->post['content'];
		$html = str_get_html($content);
		
		// h1
		if (strpos($title, $keyword) !== false) {
			$params['h1'] = 1;
		}
		
		if ($html) {
			foreach ($html->find('h1') as $h1) {
				if (strpos($h1->plaintext, $keyword) !== false) {
					$params['h1'] = 1;
					break;
				}
			}

			// h2
			foreach ($html->find('h2') as $h2) {
				if (strpos($h2->plaintext, $keyword) !== false) {
					$params['h2'] = 1;
					break;
				}
			}

			// h3
			foreach ($html->find('h3') as $h3) {
				if (strpos($h3->plaintext, $keyword) !== false) {
					$params['h3'] = 1;
					break;
				}
			}

			// bold
			foreach ($html->find('strong') as $strong) {
				if (strpos($strong->plaintext, $keyword) !== false) {
					$params['bold'] = 1;
					break;
				}
			}

			foreach ($html->find('b') as $strong) {
				if (strpos($strong->plaintext, $keyword) !== false) {
					$params['bold'] = 1;
					break;
				}
			}

			// italic
			foreach ($html->find('i') as $strong) {
				if (strpos($strong->plaintext, $keyword) !== false) {
					$params['italic'] = 1;
					break;
				}
			}

			foreach ($html->find('em') as $strong) {
				if (strpos($strong->plaintext, $keyword) !== false) {
					$params['italic'] = 1;
					break;
				}
			}

			// underline
			foreach ($html->find('u') as $strong) {
				if (strpos($strong->plaintext, $keyword) !== false) {
					$params['underline'] = 1;
					break;
				}
			}

			foreach ($html->find('span') as $strong) {
				if (strpos($strong->__toString(), 'text-decoration: underline') !== false and strpos($strong->plaintext, $keyword) !== false) {
					$params['underline'] = 1;
					break;
				}
			}

			// img alt
			foreach ($html->find('img') as $img) {
				// because bug on vendor lib
				$imgAsString = $img->__toString();
				if (strpos($imgAsString, $keyword) !== false and 
						strpos($imgAsString, $keyword, (int)strpos($imgAsString, ' alt=')) > (int)strpos($imgAsString, ' alt=')) {
					$params['alt'] = 1;
					break;
				}
			}
		}
		
		// title
		$post = wp_get_post_autosave($this->post['id']);
		if (!$post) {
			$post = get_post($this->post['id']);
		}
		
		// try to simulate wp_title()
		if ( isset($post->post_title) ) {
			$metaTitle = apply_filters('single_post_title', $this->post['title'], $post);
		} else {
			$metaTitle = apply_filters('single_post_title', $this->post['title']);
		}

		$t_sep = '%WP_TITILE_SEP%';

		$prefix = '';
		if ( !empty($metaTitle) ) {
			$prefix = " | ";
		}

		$title_array = explode( $t_sep, $metaTitle );
		$title_array = array_reverse( $title_array );
		$metaTitle = implode( " | ", $title_array ) . $prefix;

		$metaTitle = apply_filters('wp_title', $metaTitle, '|', 'right');

		if (strpos(wtb_seo_helper::strtolower($metaTitle), $keyword) !== false) {
			$params['title'] = 1;
		}

		return $params;
	}
	
	/**
	 * calculate section score
	 * @param wtb_seo_box_section $section
	 * @return float
	 */
	protected function calcScore($section)
	{
		$maxAvailable = 0;
		$score = 0;
		
		// keyword in title 25%
		if ($section->isParamAllowed('title'))	{
			$maxAvailable += 25;
			$score += !empty($section->parameters['title']) ? 25 : 0;
		}
		
		// keyword in H1 21%
		if ($section->isParamAllowed('h1'))	{
			$maxAvailable += 21;
			$score += !empty($section->parameters['h1']) ? 21 : 0;
		}
		
		// keyword in H2 8%
		if ($section->isParamAllowed('h2'))	{
			$maxAvailable += 8;
			$score += !empty($section->parameters['h2']) ? 8 : 0;
		}
		
		// keyword in H3 5%
		if ($section->isParamAllowed('h3'))	{
			$maxAvailable += 5;
			$score += !empty($section->parameters['h3']) ? 5 : 0;
		}
		
		// keyword in bold 3%
		if ($section->isParamAllowed('bold'))	{
			$maxAvailable += 3;
			$score += !empty($section->parameters['bold']) ? 3 : 0;
		}
		
		// keyword in italic 3%
		if ($section->isParamAllowed('italic'))	{
			$maxAvailable += 3;
			$score += !empty($section->parameters['italic']) ? 3 : 0;
		}
		
		// keyword in underline 3%
		if ($section->isParamAllowed('underline'))	{
			$maxAvailable += 3;
			$score += !empty($section->parameters['underline']) ? 3 : 0;
		}
		
		// keyword in alt 2%
		if ($section->isParamAllowed('alt')) {
			$maxAvailable += 2;
			$score += !empty($section->parameters['alt']) ? 2 : 0;
		}
		
		// keyword desnsity 15%
		$maxAvailable += 15;
		if ($section->density >= $section->perfectDensity*1.27) {
			$score += 0;
		} else if ($section->density >= $section->perfectDensity*1.23) {
			$score += 6;
		} else if ($section->density >= $section->perfectDensity*1.16) {
			$score += 9;
		} else if ($section->density >= $section->perfectDensity*1.1) {
			$score += 13;
		} else if ($section->density > $section->perfectDensity) {
			$score += 15;
		} else if ($section->perfectDensity != 0) {
			$score += number_format(15*$section->density/$section->perfectDensity, 2);
		}
		
		// lenght 15%
		$maxAvailable += 15;
		if ($this->getTotalWordCount() >= $this->idealPostLenght) {
			$score += 15;
		} else {
			if ($this->idealPostLenght != 0) {
				$score += 15 * $this->getTotalWordCount() / $this->idealPostLenght;
			}
		}
		
		return $score * 100 / $maxAvailable;
	}
	
	/**
	 * calculate WDF
	 * log2(1 + keywords count in document) / log2(total word count in document)
	 * @param wtb_seo_box_section $section
	 */
	protected function calcWdf(wtb_seo_box_section $section) 
	{
		// divide from 0 is not allowed
		if (log($this->getTotalWordCount(), 2) == 0) {
			return 0;
		}
		return log(1+$this->getKeywordsCount($section->keyword), 2) / log($this->getTotalWordCount(), 2);
	}
	
	/**
	 * calculate IDF
	 * log(1 + total documents count) / documents count containing our keyword
	 * @param wtb_seo_box_section $section
	 */
	protected function calcIdf(wtb_seo_box_section $section) 
	{
		$containsKeyword = $this->getDocumentsWithKeywordCount($section->keyword);
		return log10(1 + (
				$containsKeyword ? 
					($this->getTotalDocumentsCount() / $containsKeyword) : 
					0
				));
	}
	
	/**
	 * get total count of all documents in database
	 * @global wpdb $wpdb
	 * @return int
	 */
	protected function getTotalDocumentsCount()
	{
		global $wpdb;
		
		// allways is current document
		$total = 1;
		
		$cpt = $this->getPostTypesForUse();
		
		$postsCountInDb = $wpdb->get_var( "
			SELECT COUNT(*) 
			FROM $wpdb->posts 
			WHERE post_type IN ('".implode("', '", $cpt)."') 
				AND id != " . (int)$this->post['post']['post_ID'] . "
				AND post_status = 'publish'" );

		if ($postsCountInDb) {
			$total += $postsCountInDb;
		}
		
		return $total;
	}
	
	protected function getPostTypesForUse()
	{
		$ourCPT = array();
		$settings = get_option('wtb_seo_main', array());
		$cptSettings = !empty($settings['cpt']) ? (array)$settings['cpt'] : array();
		
		foreach (get_post_types() as $cpt) {
			if (!in_array($cpt, array('attachment', 'revision', 'nav_menu_item'))) {
				if (empty($settings) or (!empty($cptSettings[$cpt]) and $cptSettings[$cpt] == 1)) {
					$ourCPT[] = $cpt;
				}
			}
		}
		
		if (empty($ourCPT)) {
			$ourCPT = array('page', 'post');
		}
		
		return $ourCPT;
	}
	
	/**
	 * get count of documents in database containing given keyword
	 * @param string $name
	 * @return int
	 */
	protected function getDocumentsWithKeywordCount($keyword)
	{
		global $wpdb;
		
		$count = (int)(bool)$this->getKeywordsCount($keyword);
		
		$cpt = $this->getPostTypesForUse();
		
		$postsCountInDb = $wpdb->get_var( "
			SELECT COUNT(*) 
			FROM $wpdb->posts 
			WHERE post_type IN ('".implode("', '", $cpt)."') 
				AND id != " . (int)$this->post['post']['post_ID'] . "
				AND post_status = 'publish'
				AND post_content like '%" . mysql_real_escape_string($keyword) . "%'
				" );

		if ($postsCountInDb) {
			$count += $postsCountInDb;
		}
		
		return $count;
	}
}
