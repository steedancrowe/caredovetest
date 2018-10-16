(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */	  

	 	$(document).ready(function(){

	 		//  var modal = document.querySelector(".caredove-modal");
			// var trigger = document.querySelector(".caredove-iframe-button");
			// var closeButton = document.querySelector(".caredove-modal-close");

			// //Load the URL of the first button once the page loads
			// var lazyURL = $(".caredove-iframe-button").first().attr("data-url");
			// $('#caredove-iframe').attr('src', lazyURL + '?embed=1');

			// function toggleModal() {
			//     modal.classList.toggle("caredove-modal-show");
			// }

			// function windowOnClick(event) {
			//     if (event.target === modal) {
			//         toggleModal();
			//     }
			// }

			// $(".caredove-iframe-button").on("click", function() {		
			// 	// var url = $(this).attr("data-url");
			// 	var modal_title = $(this).attr("data-modal-title");
			// // 	$('#caredove-iframe').attr('src', url + '?embed=1');
			// // 	toggleModal();
			// });
			// closeButton.addEventListener("click", toggleModal);
			// window.addEventListener("click", windowOnClick);

	 		$(".caredove-iframe-button").modaal({
				loading_content: 'Loading content, please wait.',
    		type: 'iframe',
    		iframe_title: 'Search for Services',
    		iframe_footer: 'Powered by <a href="https://caredove.com">Caredove.com</a>'
			});

	
		});

})( jQuery );
