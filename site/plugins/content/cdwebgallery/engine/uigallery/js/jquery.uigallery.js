/**
 * Application - UI Gallery
 */

(function($) {

	// function $(something).uigallery();
	$.fn.uigallery = function(opt) {

		// Default values
		var defaults = {
			theme: 'smoothness'
		};
		var settings = $.extend(defaults, opt);

		var image = $(this);

		return image.each(function(n, el) {

			// set prev and next links
			var nextlink = image[(n + 1)];
			var prevlink = image[(n - 1)];

			var rel_attr = $(el).attr('rel').split('x');

			var width = rel_attr[0] * 1 + 50;
			var height = rel_attr[1] * 1 + 50;

			$(el).click( function (e) {
				e.preventDefault();

				el = $(this);

				var img = el.children('img');

				// preload prev image
				if (prevlink != undefined) {
					prevImage = new Image();
					prevImage.src = $(prevlink).attr('href');
				}

				// preload next image
				if (nextlink != undefined) {
					nextImage = new Image();
					nextImage.src = $(nextlink).attr('href');
				}

				// prevent category and section blog preview
				var enableDialog = $('body > .' + settings.theme + '');
				if (enableDialog.length) return false;

				$('<div id="uigallery"></div>').appendTo('body');
				var uigallery = $('#uigallery');

				uigallery.dialog({
					title: img.attr('title'),
					height: height,
					width: width,
					draggable: false,
					resizable: false,
					stack: false,
					buttons: {
						'»': function() {
							$(this).dialog('close');
							$(nextlink).click();
						},
						'«': function() {
							$(this).dialog('close');
							$(prevlink).click();
						}
					},
					open: function() {

						uigallery = $(this);
						
						theme($(this)); // add theme
						
						// disable next button if image is last one
						var link_next = image[(n + 1)];
						if (link_next == undefined) {
							$(this).next('div.ui-dialog-buttonpane').children('button:eq(0)').attr('disabled', true).addClass('ui-state-disabled');
						}

						// disable prev button if image is last one
						var link_prev = image[(n - 1)];
						if (link_prev == undefined) {
							$(this).next('div.ui-dialog-buttonpane').children('button:eq(1)').attr('disabled', true).addClass('ui-state-disabled');
						}

						var counter = '<div class="counter">' + (n + 1) + '/' + image.length + '</div>';

						$(this).next('div.ui-dialog-buttonpane').prepend(counter);

						var imgtag = '<img src="' + el.attr('href') + '" title="' + img.attr('title') + '" alt="' + img.attr('alt') + '" height="' + (height - 50) + '" width="' + (width - 50) + '" />';
						$(this).append(imgtag).hide().fadeIn('3000');

						// key navigation, left, right, ESC
						$(document).one('keyup', function(e) {
							keyCode = e.keyCode;
							switch(keyCode) {
								case 37:
									uigallery.next('div.ui-dialog-buttonpane').children('button:eq(1)').click();
									break;
								case 39:
									uigallery.next('div.ui-dialog-buttonpane').children('button:eq(0)').click();
									break;
								case 27:
									uigallery.dialog('close');
									break;
								default:
									break;
							}
						});

					},
					close: function() {
						removeDialog($(this));
					}
				});
			});

			// Wrapper dialog with related theme
			theme = function(container) {
				var wrapper = '<div class="' + settings.theme + '" style="position: absolute; top: 0; left: 0;"></div>';
				container.parent('.ui-dialog').wrap(wrapper);
				$('.ui-widget-overlay').wrap(wrapper); // if overlay
				container.dialog('option', 'position', 'center');
			};

			// Destroy dialog
			removeDialog = function(container) {
				container.closest('.' + settings.theme).prev('.' + settings.theme).remove();
				container.closest('.' + settings.theme + '').remove();
				$('#uigallery').remove();
			};

		});
	};

})(jQuery);