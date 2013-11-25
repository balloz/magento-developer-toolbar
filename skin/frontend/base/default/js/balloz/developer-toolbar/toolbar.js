(function($) {
	$(document).ready(function() {
		$('.balloz-toolbar a').click(function() {
			var $this = $(this),
				active = $this.hasClass('active');
			
			$('.balloz-toolbar-panel-label a').removeClass('active');
			$('.balloz-toolbar-panel-content').hide();

			if (!active) {
				$(this).addClass('active');
				$($this.attr('href')).toggle();
			}

			return false;
		});
	});
}());