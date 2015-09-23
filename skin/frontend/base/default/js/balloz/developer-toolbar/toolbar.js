(function() {
	function getJQuery(callback) {
		if (typeof jQuery === "undefined") {
			var scriptTag = document.createElement('script');
			scriptTag.setAttribute("type", "text/javascript");
			scriptTag.setAttribute("src", "http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js");
			scriptTag.onload = function() {
				jQuery.noConflict();
				callback(jQuery);
			};
			scriptTag.onreadystatechange = function() {
				if (this.readyState == 'complete' || this.readyState == 'loaded') {
					jQuery.noConflict();
					callback(jQuery);
				}
			};

			document.getElementsByTagName("head")[0].appendChild(scriptTag);
		} else {
			callback(jQuery);
		}
	}

	getJQuery(function($) {
		$(document).ready(function() {
			$('.balloz-toolbar-panels-container a').click(function(e) {
				e.preventDefault();

				var $this = $(this),
					active = $this.hasClass('active');
				
				$('.balloz-toolbar-panel-label a').removeClass('active');
				$('.balloz-toolbar-panel-content').hide();

				if (!active) {
					$(this).addClass('active');
					$($this.attr('href')).toggle();
				}
			});

			var $toolbar = $('.balloz-toolbar');

			$('.balloz-toolbar .balloz-toolbar-min').click(function(e) {
				e.preventDefault();

				var $this = $(this);

				if ($toolbar.hasClass('balloz-toolbar-hidden-left')) {
					$toolbar.removeClass('balloz-toolbar-hidden-left');
				} else if ($toolbar.hasClass('balloz-toolbar-hidden-right')) {
					$toolbar.removeClass('balloz-toolbar-hidden-right');
				} else {
					if ($this.hasClass('balloz-toolbar-min-left')) {
						$toolbar.addClass('balloz-toolbar-hidden-left');
					} else if ($this.hasClass('balloz-toolbar-min-right')) {
						$toolbar.addClass('balloz-toolbar-hidden-right');
					}
				}
			});
		});
	});
}());
