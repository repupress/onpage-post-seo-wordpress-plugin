var chosenword = '';
var randIndex = 0;
var newItem = '';

//FUNCTION RANDOM INT
function randomIntFromInterval(min,max)
{
		    return Math.floor(Math.random()*(max-min+1)+min);
}

//FUNCTION TO DRIBBLE ITEMS
function wptgaddone(wptgitems){
    if( wptgitems.length  > 0 ){
        itm = wptgitems[0];
        
        wptgitems.splice(0,1);
        jQuery('#onpage-post-seo-items').append('<li style="display:none">' + itm + '</li>').find('li:last-child').fadeIn('slow',function(){
            wptgaddone(wptgitems);
        });
        
    }
}



//EVENTS
jQuery(document).ready(function(){
	
	
	
	//SUGGEST BUTTON
	jQuery('#onpage-post-seo-generate').click(function(){
		
		//console.log(wptgDbtemp.length + ' temp length' ) ;
		
		//word 
		 chosenword= jQuery('#field-wptg').val();
		
		
		jQuery('#onpage-post-seo-items').slideUp('fast',function(){
			jQuery('#onpage-post-seo-items li').remove();
		});
		
		
		
		
		if( wptgDbtemp.length < 8 ){
		    console.log('lower than 8 items');
		     wptgDbtemp = Array();
		    wptgDbtemp = wptgDbtemp.concat( wptgDb);
		}

		var wptgi = 0 ;
		var wptgitems = Array();
		for( wptgi ;wptgi < 8 ;wptgi ++ ) {
		    
		    randIndex=randomIntFromInterval(0,wptgDbtemp.length - 1);
		    
		    //console.log('rand index: ' + randIndex );
		    
		    //console.log ( wptgDbtemp);
		    
		     newItem=wptgDbtemp[randIndex];


		    wptgitems.push( newItem.replace( '{word}' , chosenword) ); 
		    
		    wptgDbtemp.splice(randIndex,1);

		} 

		console.log(wptgitems);
		wptgaddone(wptgitems);
		console.log(wptgDbtemp.length);

		jQuery('#onpage-post-seo-items').slideDown('fast');

		return false;

	});
	
	
	
	//CHOOSE TITLE
	jQuery('#onpage-post-seo-meta-boxes').on('click','#onpage-post-seo-items li',function(){
	   jQuery('#title').val(jQuery(this).text());
	   jQuery('#title-prompt-text').addClass('screen-reader-text');  
	 jQuery("html, body").animate({ scrollTop: 0 }, "fast");
	 
	});
	
	//CHANGE WORD
	jQuery('#field-wptg').change(
		    function(){
		    	//console.log(wptgDbtemp.length + ' change' ) ;	
		    	wptgDbtemp=Array();

		    }
	);
	
	
});