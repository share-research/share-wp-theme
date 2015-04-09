jQuery(document).ready(function($) {
   share.utility.init();

   $(window).resize(function(){ share.utility.resize(); });
   $(window).scroll(function(){ share.utility.onScroll(); });
});









/*
=============================================================================
	FUNCTION DECLARATIONS
=============================================================================
*/

var share = (function($) {

	/*
		Utility
		
		Various utility functions that load/unload/route data,
		call other functions, etc.
	*/

	var utility = (function() {

		var debug = false;

		var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );

		var init = function() { // Called on page load, calls all other functions that should occur on page load
			
			// PLUGINS CALLS / DEVICE FIXES
			conditionizr({ // http://conditionizr.com/docs.html
				debug      : false,
				scriptSrc  : 'js/conditionizr/',
				styleSrc   : 'css/conditionizr/',
				ieLessThan : {
					active: true,
					version: '9',
					scripts: false,
					styles: false,
					classes: true,
					customScript: // Separate polyfills with commas
						'//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js, //cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js'
					},
				chrome     : { scripts: false, styles: false, classes: true, customScript: false },
				safari     : { scripts: false, styles: false, classes: true, customScript: false },
				opera      : { scripts: false, styles: false, classes: true, customScript: false },
				firefox    : { scripts: false, styles: false, classes: true, customScript: false },
				ie10       : { scripts: false, styles: false, classes: true, customScript: false },
				ie9        : { scripts: false, styles: false, classes: true, customScript: false },
				ie8        : { scripts: false, styles: false, classes: true, customScript: false },
				ie7        : { scripts: false, styles: false, classes: true, customScript: false },
				ie6        : { scripts: false, styles: false, classes: true, customScript: false },
				retina     : { scripts: false, styles: false, classes: true, customScript: false },
				touch      : { scripts: false, styles: false, classes: true, customScript: false },
				mac        : true,
				win        : true,
				x11        : true,
				linux      : true
			});

			if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) { // Disable scaling until user begins a gesture (prevents zooming when user rotates to landscape mode)
				var viewportmeta = document.querySelector('meta[name="viewport"]');
				if (viewportmeta) {
					viewportmeta.content = 'width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0';
					document.body.addEventListener('gesturestart', function () {
						viewportmeta.content = 'width=device-width, minimum-scale=0.25, maximum-scale=1.6';
					}, false);
				}
			}

			$("div.twitter-feed .tweet").tweet({ // Load a single tweet into any single tweet holder.
				modpath: 'http://www.share-research.org/wp-content/themes/share/js/vendor/twitter/',
				join_text: "auto",
				username: "SHARE_research",
				avatar_size: 0,
				count: 1,
				auto_join_text_default: " SHARE said, ",
				auto_join_text_ed: " SHARE ",
				auto_join_text_ing: " SHARE was ",
				auto_join_text_reply: " SHARE replied ",
				auto_join_text_url: " SHARE was checking out ",
				loading_text: "Loading Tweets",
				template: "{text}<div class='clear'></div>{time} <div class='actions'>{reply_action} {retweet_action} {favorite_action}</div><div class='clear'></div>"
			});

			// INIT FUNCTIONS
			uiMod.twitterWidgetClassAddition(); // Add a class to the Twitter widget in sidebars so it can be hidden @ mobile dimensions
			uiMod.wrapVideoEmbeds(); // Wrap embedded videos in a div so we can correctly resize them

			
			// REPEATING FUNCTIONS
			// var example = setInterval(function(){
			// 	// do stuff
			// }, 200);


			/*
				USER INTERACTION
			*/
			$('#main-nav .handle, #main-nav .fill').click(function(){
				userInput.toggleMainNavigation();
			});
			
		};

		var onScroll = function() { // Called when the browser window is scrolled
			// Functions
		};

		var resize = function() { // Called when the browser window is resized
			// Functions
		};

		var responsiveState = function(req) { // Returns what responsive state we're at. Values based on CSS media queries.
			// Below is an idiotic bug fix.
			// Chrome & Safari exclude scrollbars from window width for CSS media queries.
			// Firefox, Opera and IE include scrollbars in window width for CSS media queries, but not in JS.
			// So we have to add some px to the window width for Firefox, Opera and IE so that breakpoints
			// match up between CSS and JS. What a world.
			if ($('html').hasClass('chrome') || $('html').hasClass('safari')) {
				var winWidth = $(window).width();
			}
			else {
				var winWidth = $(window).width() + 17;
			}

			if (typeof req === 'undefined' || req === 'state') {
				// MODIFY THESE IF STATEMENTS TO MATCH YOUR RESPONSIVE WIDTHS
				if (winWidth >= 1025) {
					return 'full';
				}
				if (winWidth >= 768 && winWidth <= 1024) {
					return 'compressed';
				}
				if (winWidth <= 767) {
					return 'oneCol';
				}
				// STOP MODIFYING HERE.
			}
			else {
				return winWidth;
			}
		};

		return  {
			init: init,
			onScroll: onScroll,
			resize: resize,
			responsiveState: responsiveState
		}
	})();


	/* 
		UI Modifications 

		Various functions which operate on elements to achieve visual
		effects that are impossible to create with CSS alone.
	*/

	var uiMod = (function() {

		var twitterWidgetClassAddition = function() { // Add a class to the Twitter widget in sidebars so it can be hidden @ mobile dimensions
			$('.widget-title:contains("@SHARE_research")').closest('.widget-container').addClass('mobile-hide');
		};
		
		var wrapVideoEmbeds = function() { // Wrap embedded videos in a div so we can correctly resize them
			$('iframe').each(function(){
				// 1. Get the src
				if ($(this).attr('src')) {
					var src = $(this).attr('src');
				}
				else { return; } // iframe has no src, it's something other than a video. Kill the function
				
				// 2. If the src matches Youtube or Vimeo, wrap a div around the iframe
				if (src.match(/(vimeo)/g) || src.match(/(youtube)/g)) {
					$(this).wrap('<div class="video-container"></div>');
				}
			});
		};

		// public
		return {
			twitterWidgetClassAddition: twitterWidgetClassAddition,
			wrapVideoEmbeds: wrapVideoEmbeds
		};
	})(); // var uiMod = (function() {



	/* 
		User interaction 

		Various functions which are called when the user intearcts
		with a piece of the site (eg. clicking, scrolling, etc)
	*/
	var userInput = (function() {

		var toggleMainNavigation = function() { // Toggles the main navigation open and closed @ mobile dimensions
			if (!$('#main-nav').hasClass('open')) { // Main nav is closed
				$('#main-nav').addClass('open');
				$('#branding').addClass('hidden');
			}
			else { // Main nav is open
				$('#main-nav').removeClass('open');
				$('#branding').removeClass('hidden');
			}
		};

		// public
		return {
			toggleMainNavigation: toggleMainNavigation
		};

	})(); // var uiMod = (function() {

	

	// public
	return {
		utility: utility,
		uiMod: uiMod,
		userInput: userInput
	};
})(jQuery); // var share = (function() {