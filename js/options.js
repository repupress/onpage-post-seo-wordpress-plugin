jQuery(document).ready(
    function () {
         
        jQuery('#field1zz').change(function () {
            jQuery('#field-onpage_post_seo_tool_alphabets').text(alllangs[jQuery(this).val()]);
        });
    }
);