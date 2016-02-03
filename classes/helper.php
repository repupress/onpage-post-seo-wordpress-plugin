<?php

class wtb_seo_helper
{
	/**
	 * return word cound in html
	 * @param string $html
	 * @return int
	 */
	static function getWordCount($html)
	{
		$html = str_replace('><', '> <', $html);
		$html = html_entity_decode(strip_tags($html));
		$html = str_replace(array('.', ',', '-', '?', '!'), ' ', $html);
		$html = preg_replace("/\s+/", " ", $html);
		
		$wordsArray = explode(' ', $html);
		$wordsArray = array_filter($wordsArray);
		$total = count($wordsArray);
		
		// $total = str_word_count($html);
		
		return $total;
	}
	
	static function formatNumber($number)
	{
		return number_format( (float)$number, 2, __('.', 'wtb_seo'), '');
	}
	
	static function strtolower($string)
	{
		if (extension_loaded('mbstring')) {
			return mb_strtolower($string, 'UTF-8');
		}
		
		return strtolower($string);
	}
}
