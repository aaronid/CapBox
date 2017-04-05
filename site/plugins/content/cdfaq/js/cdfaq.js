/**
 * Core Design FAQ plugin for Joomla! 1.5
 */

(function($) {
	
	$.cdfaq = {
		
		/**
		 * Init application
		 * 
		 * @return void
		 */
		initiator: function() {
		
			var container = $('div.cdfaq'),
			navigation = $('div.cdfaq_navigation');
		
			// no faq container
			if (container.length === 0) return false;
			
			// show more toggle
			$.cdfaq.toggleShowMoreRoutine();
			
			// filter
			$.cdfaq.filter();
			
			// go to top element
			$.cdfaq.themeElement(container.find('div.cdfaq_list').find('div.goToTop'));
			
			// scrolling
			if ($.cdfaq.settings.scrollSpeed) {
				
				// navigation
				navigation.find('a').click(function(e) {
					e.preventDefault();
					
					// change hash in URL
					var link = $(this);
					var change_hash = function() {
						window.location.hash = link.attr('href');
					};
					
					$.cdfaq.scrollToElement(container.find('a[name="' + $.cdfaq.substr($(this).attr('href'), 1) + '"]'), $.cdfaq.settings.scrollSpeed, change_hash);
					
				});
				
				// go to top element
				container.find('div.cdfaq_list').find('div.goToTop').children('a').click(function(e) {
					e.preventDefault();
					
					// change hash in URL
					var link = $(this);
					var change_hash = function() {
						window.location.hash = link.attr('href');
					};
					
					$.cdfaq.scrollToElement(navigation, $.cdfaq.settings.scrollSpeed, change_hash);
					
					
					/* I don't know
					// close opened accordion
					//container.find('.header').filter('.ui-state-active').click();
					*/

				});
					
			}
		},
		
		/**
		 * Toggle "Show more" routine
		 * 
		 * @return void
		 */
		toggleShowMoreRoutine: function() {
			
			if ($('div.show_less_more').length === 0) return false;
			
			$('div.show_less_more a').click(function(e) {
				e.preventDefault();
				var link = $(this);
				
				var fulltext_container = $(this).parent('div').find('div.fulltext');
				fulltext_container.toggle(0, 
						function() {
							if (fulltext_container.is(':visible')) {
								link.attr('title', $.cdfaq.language.CDFAQ_LESS_INFO).text($.cdfaq.language.CDFAQ_LESS_INFO);
							} else {
								link.attr('title', $.cdfaq.language.CDFAQ_MORE_INFO).text($.cdfaq.language.CDFAQ_MORE_INFO);
							}
						}
					);
			});
		},
		
		/**
		 * Filter
		 * 
		 * @return void
		 */
		filter: function() {
			
			var filter = $('div.cdfaq_filter input[name="filter"]');
			
			if (filter.length === 0) return false;
			
			filter.keyup(function(e) {
				e.preventDefault();
				
				var accordion_instance = $('div.ui-accordion');
				
				var val = ($(this).val() + '').toLowerCase();
				
				accordion_instance.find('h3.ui-accordion-header a').each(function(n, el) {
					
					var accordion_header = $(el).closest('h3.ui-accordion-header');
					
					var headertext = ($(el).text() + '').toLowerCase();
					
					if ($.cdfaq.strpos(headertext, val) === false) {
						
						accordion_header.hide($.cdfaq.settings.filterSlideSpeed);
						accordion_header.closest('div.ui-accordion').children('div.cdfaq_list').children('h3').each(function(n, el) {
							if ($(el).is(':animated') && $(el).hasClass('ui-state-active')) {
								$(el).closest('div.ui-accordion').accordion('activate', n);
								filter.focus();
							}
						});
							
					} else {
						accordion_header.show($.cdfaq.settings.filterSlideSpeed);
					}
					
				});
				
			});
			
		},
		
		/**
		 * Scroll element
		 * 
		 * @param element
		 * @param speed
		 * @return boolean
		 */
		scrollToElement: function(element, speed, func) {
			
	        if (speed === 0) return false;
	        if (element.length === 0) return false;
	        
	        if (typeof(func) !== 'function') func = function() {};
	        
	        ($.browser.safari) ? $('body') : $('html').animate({
	            scrollTop: element.offset().top,
	            scrollLeft: element.offset().left
	        }, speed, func);
	        
	        return true;
	        
	    },
	    
	    /**
	     * Theme elements
	     * 
	     * @param elements
	     * @return void
	     */
	    themeElement: function(elements) {
	    	elements.each(function() {
				$(this)
					.hover(
						function() {
							$(this).addClass('ui-state-hover');
						},
						function() {
							$(this).removeClass('ui-state-hover');
						}
					);
			});
	    },
	    
	    /**
	     * Check if browser is Opera
	     * 
	     * @param browser
	     * @return boolean
	     */
	    isBrowser: function(browser) {
	    	if (typeof(browser) === 'undefined') return false;
	    	return eval('(typeof(jQuery.browser.' + browser + ') === \'boolean\' ? true : false)');
	    },
	    
	    /**
		 * PHP strpos function
		 * Finds position of first occurrence of a string within another.
		 * 
		 * @param haystack
		 * @param needle
		 * @param offset
		 * @return mixed		int|boolean
		 */
		strpos: function(haystack, needle, offset) {
		    var i = (haystack+'').indexOf(needle, (offset ? offset : 0));
		    return i === -1 ? false : i;
		},
		
		/**
		 * PHP substr function
		 * Returns part of a string 
		 *  
		 * @param str
		 * @param start
		 * @param len
		 * 
		 * @return string
		 */
		substr: function(str, start, len) {
		 
		    str += '';
		    var end = str.length;
		    if (start < 0) {        start += end;
		    }
		    end = typeof len === 'undefined' ? end : (len < 0 ? len + end : len + start);
		    // PHP returns false if start does not fall within the string.
		    // PHP returns false if the calculated end comes before the calculated start.    // PHP returns an empty string if start and end are the same.
		    // Otherwise, PHP returns the portion of the string from start to end.
		    return start >= str.length || start < 0 || start > end ? !1 : str.slice(start, end);
		}
	
	};
})(jQuery);