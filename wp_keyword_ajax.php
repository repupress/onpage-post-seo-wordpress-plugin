<?php 

$action=$_GET['action'];

if(trim($action) == 'tag_add'){
	//adding tag to the post 
	$data=$_GET['data'];
	
	//read keywords
	$keys=explode(',', $data);
	$keys= array_filter($keys);
	
	 
	$pid=$_GET['pid'];
	
	//already saved keys 
	$oldkeys=get_post_meta($pid,'onpage_post_seo_tool_density',1 );
	
	if(! is_array($oldkeys)) $oldkeys=array();
	
	//merge new array with old array
	$newkeys=array_merge($oldkeys,$keys);
	
	print_r($newkeys);
	
	//update meta
	update_post_meta($pid, 'onpage_post_seo_tool_density', $newkeys);
	
	
	
	
}elseif($action=='tag_remove'){
	
	 
	//removing tag from the post
	$data=$_GET['data'];
	$pid=$_GET['pid'];
	
	//already saved keys
	$oldkeys=get_post_meta($pid,'onpage_post_seo_tool_density',1 );
	
	
	
	if(! is_array($oldkeys)) $oldkeys=array();
	
	//removing keyword 
	 
	foreach($oldkeys as $index=> $oldkey){
		if( trim($oldkey) == trim($data) ){
			//remove this itm
			unset($oldkeys[$index]);
		}
		 
	}
	
	print_r($oldkeys);
	
	//save new items
	update_post_meta($pid, 'onpage_post_seo_tool_density', $oldkeys);
}


?>