
var wtbSeoRecheck;
var wtbSeoAutoRefresh;
var activeAccordion;

/* set to true, to debug */
var wtbSeoDebug = false;

jQuery(document).ready(function () {
	
	wtb_seo_add_accordion();
	
	jQuery('body').on('keypress', '#add-keyword', function(e) {
		if (e.keyCode == 13) {
			if (jQuery(this).val().length > 0) {
				wtb_seo_add_keyword(jQuery(this).val());
				jQuery(this).val('');
			} else {
				jQuery(this).focus();
			}
			return false;
		}
	});

	jQuery('body').on('click', '#add-keyword-trigger', function() {
		if (jQuery('#add-keyword').val().length > 0) {
			wtb_seo_add_keyword(jQuery('#add-keyword').val());
			jQuery('#add-keyword').val('');
		} else {
			jQuery('#add-keyword').focus();
		}
	});
	
	jQuery('body').on('click', '#wp-seo-refresh', function() {
		if (jQuery('#add-keyword').length > 0 && jQuery('#add-keyword').val().length > 0) {
			if (wtb_seo_add_keyword(jQuery('#add-keyword').val())) {
				jQuery('#add-keyword').val('');
				return ;
			}
		}
		
		callApi([]);
		if (wtbSeoDebug) {
			console.log('call API on refresh');
		}
	});
	
	callApi([]);
	if (wtbSeoDebug) {
		console.log('call initial API');
	}
	
	jQuery('body').on('click', '.remove-keyword-trigger', function() {
		var remove = '.section-no-' + jQuery(this).data('remove');
		jQuery(remove).remove();
		callApi([]);
		if (wtbSeoDebug) {
			console.log('call API on remove keyword');
		}
	});
});

function wtb_seo_add_accordion()
{
	jQuery('#wtb-seo-accordion').accordion({
		collapsible: true,
		heightStyle: "content",
		active: (activeAccordion !== undefined ? activeAccordion : 0),
		beforeActivate: function() {
			wtb_seo_auto_refresh('call API 15 sec after accordion activation');
		}
	});
	
	jQuery('.tipsy').remove();
	
	jQuery('.right-info, .left-info').tipsy({fade: true, gravity: 's'});
	jQuery('.wtb-seo-results .wtb-seo-results-faq span').tipsy({fade: true, gravity: 'se'});
}

function wtb_seo_auto_refresh(message)
{
	var autoRefreshTime = 15;
	if (jQuery('#auto-refresh-time').length === 1) {
		autoRefreshTime = parseInt(jQuery('#auto-refresh-time').val());
		if (autoRefreshTime < 1) {
			autoRefreshTime = 1;
		}
	}
	
	clearCounter();
	wtbSeoRecheck = window.setTimeout(function(){
		callApi([]);
		if (wtbSeoDebug) {
			console.log(message);
		}
	}, autoRefreshTime * 1000);
	addCounter(autoRefreshTime);
}

function wtb_seo_remove_accordion(addNew)
{
	if (addNew === true) {
//		activeAccordion = jQuery('#wtb-seo-accordion h3').length;
		activeAccordion = 0;
		return true;
	}
	
	activeAccordion = jQuery("#wtb-seo-accordion").accordion('option', 'active');
	jQuery('#wtb-seo-accordion').accordion('destroy');
	
	if (activeAccordion) {
		if (jQuery('#wtb-seo-accordion h3').length > 0 && jQuery('#wtb-seo-accordion h3').length < activeAccordion+1) {
			activeAccordion = jQuery('#wtb-seo-accordion h3').length - 1;
		}
	}
}

function callApi(keywords)
{
	clearCounter();
	
	var content = '';
	if (jQuery("#woo_check_short_description").length === 1) {
		if (jQuery("#wp-excerpt-wrap").hasClass('html-active')) {
			content = jQuery("#excerpt").val();
		} else {
			content = jQuery("#excerpt_ifr").contents().find('#tinymce').html()            
			if (content === undefined || content.length === 0) {
				content = jQuery("#excerpt").val();
			}
		}
	} else {
		if (jQuery("#wp-content-wrap").hasClass('html-active')) {
			content = jQuery("#content").val();
		} else {
			content = jQuery("#content_ifr").contents().find('#tinymce').html()            
			if (content === undefined || content.length === 0) {
				content = jQuery("#content").val();
			}
		}
	}
	
	var title = jQuery('#title').val();
	var addNew = keywords.length > 0;
	
	jQuery('#wtb-seo-accordion h3.section-header').each(function() {
		keywords.push(jQuery(this).text());
	});

	jQuery('#wtb-seo-box').css('opacity', '0.4');

	// for title
	jQuery('input#wp-preview').val('dopreview');
	var post = {};
	jQuery(jQuery('form#post').serializeArray()).each(function(x,kv) {
		if (post.hasOwnProperty(kv.name)) {
			post[kv.name] = jQuery.makeArray(post[kv.name]);
			post[kv.name].push(kv.value);
		} else {
			post[kv.name] = kv.value;
		}
	});
	jQuery('input#wp-preview').val('');
	// end of title

	jQuery.post(ajaxurl, {
			action: 'wtb_seo_api',
			id: jQuery('#post_ID').val(),
			title: title,
			content: content,
			keywords: keywords,
			post: post
		},
		function(data) {
			if (data !== null) {
				wtb_seo_remove_accordion(addNew);
				jQuery('#wtb-seo-box').after(data.box).remove();
				wtb_seo_add_accordion();
				
				wtb_seo_auto_refresh('call API 15 sec after last call');
			}
		},
		'json'
	);
}

function addCounter(i)
{
	if (jQuery('#disable-auto-refresh').length === 1 && jQuery('#disable-auto-refresh').val() > 0) {
		clearCounter();
		return;
	}
	
	jQuery('#wp-seo-refresh i').text(i);
	
	if (jQuery('#add-keyword:focus').length > 0) {
		i++;
		window.clearTimeout(wtbSeoRecheck);
		wtbSeoRecheck = window.setTimeout(function(){
			callApi([]);
			if (wtbSeoDebug) {
				console.log('call API ' + i + ' sec after addCounter()');
			}
		}, i*1000);
	}
	
	window.clearTimeout(wtbSeoAutoRefresh);
	wtbSeoAutoRefresh = window.setTimeout(function(){addCounter(i-1);}, 1000);
}

function clearCounter()
{
	window.clearTimeout(wtbSeoRecheck);
	window.clearTimeout(wtbSeoAutoRefresh);
	jQuery('#wp-seo-refresh i').text('');
}

function wtb_seo_add_keyword(keyword)
{
	if (jQuery('#wtb-seo-accordion h3.section-header').length < 3) {
		callApi([keyword]);
		if (wtbSeoDebug) {
			console.log('call API on new keyword ['+keyword+']');
		}
		return true;
	} else {
		return false;
	}
}