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
			
			if($this.hasClass('active')){
				$('.developer-toolbar-overlay').hide();
				$this.removeClass('active');
				return;
			}
			
			if(!blockName){
				return;
			}
			
			
			var $startBlock = $("." + blockName + "-start-viewer");
			var $endBlock = $("." + blockName + "-end-viewer");
			
			if(!$startBlock.length |! $endBlock.length){
				return;
			}
			
			$('.balloz-toolbar-panel-content-blocks a').removeClass('active');
			$this.addClass('active');
			
			$startBlock.addClass('active');
			$endBlock.addClass('active');
			
			var startY 	= $startBlock.offset().top
			var height 	= $endBlock.offset().top - startY;
			var overlay = $('.developer-toolbar-overlay');
			
			if(!overlay.length){
				overlay = $('<div class="developer-toolbar-overlay"></div>');
				$('body').append(overlay);
			}
			
			// Getting the height won't be perfect because of floats / absolutes.
			// We do what we can, jeff.  Use the parent height if we don't have one.
			if(!height){
				height = $startBlock.parent().height();
			}
			
			
			overlay.show().css({
				'position':'absolute',
				'background':'red',
				'left':$startBlock.offset().left,
				'top':$startBlock.offset().top,
				'width':$startBlock.outerWidth(),
				'height':height,
				'opacity':0.3
			});
			
			$startBlock.removeClass('active');
			$endBlock.removeClass('active');
			
			jQuery('body').animate({scrollTop:startY - 25}, 500);
			
			
				
		});
	});
})(jQuery);