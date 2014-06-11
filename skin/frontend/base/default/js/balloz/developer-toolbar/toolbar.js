(function($) {
	$(document).ready(function() {
		$('.balloz-toolbar .balloz-toolbar-panel-label a').click(function() {
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
		
		$('.balloz-toolbar-panel-content-blocks a').click(function(e){
			var $this = $(this),
				blockName = $this.data('layout-name');
			
			e.preventDefault();
			
			if(!blockName){
				return;
			}
			
			$('.developertoolbar-overlay').remove();
			
			var $startBlock = $("." + blockName + "-start-viewer");
			var $endBlock = $("." + blockName + "-end-viewer");
			
			if(!$startBlock.length |! $endBlock.length){
				return;
			}
			
			$startBlock.css('display', 'block');
			$endBlock.css('display', 'block');
			
			var height = $endBlock.offset().top - $startBlock.offset().top;
			var overlay = $('<div class="developertoolbar-overlay"></div>');
			
			if(!height){
				height = $startBlock.parent().height();
			}
			
			overlay.css({
				'position':'absolute',
				'background':'red',
				'left':$startBlock.offset().left,
				'top':$startBlock.offset().top,
				'width':$startBlock.outerWidth(),
				'height':height,
				'opacity':0.3
			});
			
			$startBlock.css('display', 'none');
			$endBlock.css('display', 'none');
			
			$('body').append(overlay);
				
		});
	});
})(jQuery);