/**
 * Denisty Loop
 */
function onpage_post_seo_tool_timedCount() {

    // read content
    var content = jQuery('#content_ifr').contents().find('.mceContentBody')
        .text().toLowerCase();
    contWords = content.split(' ');
    contLength = contWords.length;

    // read keywords to watch
    jQuery(
        '#onpage_post_seo_tool_keywords_density .onpage_post_seo_tool_itm  .onpage_post_seo_tool_keyword')
        .each(
            function () {

                var word = jQuery(this).text();
                count = content.match(RegExp(word, 'g'));
                var match = 0;

                if (count == null) {

                } else {
                    match = count.length;
                }

                // calculating string words
                temp = word.split(' ');
                length = temp.length;

                // calculating percentage = wordcount * 100 / totl words
                percent = match * length * 100 / contLength;
                percent = percent.toFixed(2);
                jQuery(this).parent().find('.onpage_post_seo_tool_volume')
                    .html(percent + '%');

            });

    t = setTimeout("onpage_post_seo_tool_timedCount()", 5000);
}
onpage_post_seo_tool_timedCount();

/**
 * Doc Ready
 */
jQuery(document)
    .ready(
        function () {

            // Search button
            jQuery('#onpage_post_seo_tool_search_btn')
                .click(
                    function () {
                        var keyword = jQuery(
                            '#onpage_post_seo_tool_search_txt')
                            .val();

                        if (keyword == '') {
                            alert('Write Keyword First');
                            return false;
                        }

                        jQuery
                            .ajax({
                                url: jQuery(
                                    '#onpage_post_seo_tool_ajax_src')
                                    .val() + '&key=' + encodeURIComponent(keyword),
                                context: document.body,
                                success: function (data) {

                                    jQuery(
                                        '#onpage_post_seo_tool_ajax-loading')
                                        .addClass(
                                            'ajax-loading');
                                    jQuery(
                                        '#onpage_post_seo_tool_search_btn')
                                        .removeAttr(
                                            'disabled');
                                    jQuery(
                                        '#onpage_post_seo_tool_search_btn')
                                        .removeClass(
                                            'disabled');

                                    var res = jQuery
                                        .parseJSON(data);
                                    console.log(res);
                                    if (res['status'] == 'success') {

                                        var words = res['words'];
                                        var volume = res['volume'];

                                        for (var i = 0; i < words.length; i++) {
                                            jQuery(
                                                '#onpage_post_seo_tool_keywords')
                                                .append(
                                                    '<div class="onpage_post_seo_tool_itm "><input type="checkbox" value="' + words[i] + '"><div class="onpage_post_seo_tool_keyword">' + words[i] + '</div><div class="onpage_post_seo_tool_volume">' + volume[i] + '</div><div class="clear"></div></div>');
                                        }

                                        jQuery(
                                            '#onpage_post_seo_tool_body')
                                            .slideDown();

                                    } else if (res['status'] == 'Error') {
                                        var error = res['error'];
                                        jQuery(
                                            '#suggestionContain')
                                            .prepend(
                                                '<a href="#" title="error" class="box errors corners" style="margin-top: 0pt ! important;"><span class="close">&nbsp;</span>' + error + ' .</a>');
                                        activate_close();

                                    }

                                },
                                beforeSend: function () {
                                    jQuery(
                                        '#onpage_post_seo_tool_ajax-loading')
                                        .removeClass(
                                            'ajax-loading');
                                    jQuery(
                                        '#onpage_post_seo_tool_search_btn')
                                        .addClass(
                                            'disabled');
                                    jQuery(
                                        '#onpage_post_seo_tool_search_btn')
                                        .attr(
                                            'disabled',
                                            'disabled');

                                }

                            });

                        return false;

                    });

            // Clean Button
            jQuery('#onpage_post_seo_tool_clean').click(function () {
                jQuery('#onpage_post_seo_tool_body').slideUp();
                jQuery('#onpage_post_seo_tool_keywords').slideUp();
                jQuery('#onpage_post_seo_tool_keywords').empty();
                jQuery('#onpage_post_seo_tool_keywords').slideDown();

                return false;
            });

            var currentIndex = 0;
            var currentKeyword = '';
            var currentLetter = 'a';
            var currentSearch = '';
            // load more button
            jQuery('#onpage_post_seo_tool_more')
                .click(
                    function () {
                        currentIndex = 0;
                        var newKeyword = jQuery('#onpage_post_seo_tool_search_txt').val();
                        currentKeyword = newKeyword;
                        jQuery('#onpage_post_seo_tool_body').show();

                        letters=onpage_post_seo_tool_letters;
                       
                        for (currentIndex; currentIndex < letters.length; currentIndex++) {
                            currentLetter = letters[currentIndex];

                            //now let's google 
                            currentSearch = currentKeyword + ' ' + currentLetter;
                            console.log('New search:' + currentSearch);
                            
                            var gurl='http://clients1.'+ onpage_post_seo_tool_google +'/complete/search';
                            if (location.protocol === 'https:') {
            				    // page is secure
            					gurl='https://clients1.'+ onpage_post_seo_tool_google +'/complete/search';
            				}

                            jQuery.get(
                                gurl,
                                'output=json&q=' + currentSearch + '&client=firefox',
                                function (data) {
                                    var list = data[1];

                                    if (list.length == 0) {
                                        console.log('no suggestions');
                                    } else {

                                        jQuery('.onpage_post_seo_tool_keyword_status').html(jQuery('#onpage_post_seo_tool_search_txt').val());

                                        for (var i = 0; i < list.length; i++) {

                                            console.log(list[i]);

                                            jQuery('#onpage_post_seo_tool_keywords').append('<label class="onpage_post_seo_tool_itm "><input type="checkbox" value="' + list[i] + '">' + list[i] + '</label><br>');

                                            jQuery('.onpage_post_seo_tool_count').html(jQuery('label.onpage_post_seo_tool_itm').length);
                                        }
                                        //jQuery('#onpage_post_seo_tool_keywords').scrollTop(jQuery('#onpage_post_seo_tool_keywords').prop('scrollHeight')) ;
                                    }

                                },
                                'jsonp'
                            );




                        }




                    });

            // add tags button
            jQuery('#onpage_post_seo_tool_tag_btn')
                .click(
                    function () {

                        jQuery(
                            '.onpage_post_seo_tool_itm input:checked')
                            .each(
                                function () {
                                    jQuery(
                                        '#new-tag-post_tag')
                                        .val(
                                            jQuery(
                                                '#new-tag-post_tag')
                                            .val() + ',' + jQuery(
                                                this)
                                            .val());
                                    jQuery(this).attr(
                                        'checked',
                                        false);
                                });
                        
                       

                        
                        jQuery('#post_tag input.tagadd')
                            .trigger('click');
                        return false;
                    });

            // Watch Keywords btn
            jQuery('#onpage_post_seo_tool_density_btn')
                .click(
                    function () {
                    	
                    	var newKeys='';

                        jQuery(
                            '.onpage_post_seo_tool_itm input:checked')
                            .each(
                                function () {
                                    jQuery(
                                        '#onpage_post_seo_tool_density_head')
                                        .show();
                                   
                                    newKeys = newKeys + ',' + jQuery(this).val();
                                    
                                    jQuery(
                                        '#onpage_post_seo_tool_keywords_density')
                                        .append(
                                            '<div class="onpage_post_seo_tool_itm tagchecklist"><span><a   class="ntdelbutton">X</a></span><div class="onpage_post_seo_tool_keyword">' + jQuery(
                                                this)
                                            .val() + '</div><div class="onpage_post_seo_tool_volume">%</div><div class="clear"></div></div>');
                                    
                                    
                                    	
                                    
                                });
                        
                        removeBtn();
                        
                        
                        //send save request
                        jQuery
                        .ajax({
                            url: jQuery(
                                '#onpage_post_seo_tool_ajax_src')
                                .val() + '&action=tag_add&data=' + encodeURIComponent(newKeys),
                            context: document.body,
                            success: function (data) {

                            	console.log(data);

                            },
                            beforeSend: function () {
                                

                            }

                        });

                        return false;
                    });
            
            //list button
        	jQuery('#onpage-post-seo-list-wrap').dialog({
                autoOpen: false,
                dialogClass : 'wp-dialog',
                position: 'center',
                draggable: false,
                width: 400,
                title: 'Keyword List'
            });

            jQuery('#onpage_post_seo_tool_list_btn').click(function(){
            	var txtList='';
            	jQuery('#onpage-post-seo-list').text('');
            	
            	jQuery('#onpage_post_seo_tool_keywords input[type="checkbox"]:checked').each(function(){
            		
            		console.log( jQuery(this).val() );
            		
            		txtList = txtList  + jQuery(this).val() + '\n'; 
            	});
            	
            	jQuery('#onpage-post-seo-list').text(txtList);
            
            	jQuery('#onpage-post-seo-list-wrap').dialog('open');
            	
            	
            });

            // gcomplete
            jQuery("#onpage_post_seo_tool_search_txt").gcomplete({
                style: "default",
                effect: false,
                pan: '#onpage_post_seo_tool_search_txt'
            });

            /**
             * Check all and de select all check onpage_post_seo_tool_check
             */
            jQuery('#onpage_post_seo_tool_check')
                .click(
                    function () {
                        if (jQuery(this).attr('checked') == 'checked') {
                            jQuery(
                                '#onpage_post_seo_tool_keywords input:checkbox')
                                .attr('checked', 'true');
                        } else {
                            jQuery(
                                '#onpage_post_seo_tool_keywords input:checkbox')
                                .removeAttr('checked');
                        }
                    });

            /**
             * what density btn
             */
            jQuery('#onpage_post_seo_tool_density_info').click(
                function () {

                    if (jQuery('#onpage_post_seo_tool_density_info_box')
                        .css('display') == 'none') {

                        jQuery('#onpage_post_seo_tool_density_info_box')
                            .show();
                    } else {
                        jQuery('#onpage_post_seo_tool_density_info_box')
                            .hide();

                    }

                    return false;

                });
            
            
            function removeBtn(){
            //remove density keyword
            jQuery('.onpage_post_seo_tool_itm .ntdelbutton').click(function(){
                
            	//remove class
            	
            	var removeWord = (jQuery(this).parent().parent().find('.onpage_post_seo_tool_keyword').html());
                
                //remove call
                jQuery
                .ajax({
                    url: jQuery(
                        '#onpage_post_seo_tool_ajax_src')
                        .val() + '&action=tag_remove&data=' + encodeURIComponent(removeWord),
                    context: document.body,
                    success: function (data) {

                    	console.log(data);

                    },
                    beforeSend: function () {
                        

                    }

                });
                
                
                jQuery(this).parent().parent().fadeOut('fast').remove();

            });
            
            //remove selector class
            jQuery('.onpage_post_seo_tool_itm .ntdelbutton').removeClass('ntdelbutton');
            
            }//end function remove btn
            
            removeBtn();
            

        });