(function( $ ) {
	'use strict';
	
    		$(document).ready(function(){
            $('#insert-caredove-search-page').on('click', function() {
            	 var ed = tinyMCE.activeEditor;
            	 //format:: ed.execCommand('tinyMceCommand', 'image values', 'shortcode_code');
            	 ed.execCommand('editImage', '', 'caredove_search');
          	});
          	$('#insert-caredove-button').on('click', function() {
            	 var ed = tinyMCE.activeEditor;
							 //format:: ed.execCommand('tinyMceCommand', 'image values', 'shortcode_code');
            	 ed.execCommand('editImage', '', 'caredove_button');
          	});
          	$('#insert-caredove-listings').on('click', function() {
            	 var ed = tinyMCE.activeEditor;
            	 //format:: ed.execCommand('tinyMceCommand', 'image values', 'shortcode_code');
            	 ed.execCommand('editImage', '', 'caredove_listings');
          	});

        });

})( jQuery );
