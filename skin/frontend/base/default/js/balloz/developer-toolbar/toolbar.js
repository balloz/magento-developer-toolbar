(function($) {
	function getStartMarkerClass(name){
		return name + "-start-viewer";
	}
	
	function getEndMarkerClass(name){
		return name + "-end-viewer";
	}
	
	function isVisible($el){
		// Forms appear invisible, but the contents most likely aren't!
		if($el.get(0).nodeName == 'FORM'){
			return true;
		}
		
		return $el.is(":visible");
	}
	
	function getDimensionsBetweenMarker(name){
		var startClass = getStartMarkerClass(name),
			endClass   = getEndMarkerClass(name),
			dims;	
		
		$('.' + startClass).nextAll().each(function(){
			var $this = $(this);
			
			if($this.hasClass(endClass)){
				return false;
			}
			
			if(!isVisible($this)){
				return true;
			}
					
			dims = mergeDimensions(dims, getTraversedDimensions($this));
		});
			
		return dims;
	}
	
	/* Merges two dimension objects, taking the min left and top, max right and bottom */
	function mergeDimensions(dims, dims2){
		if(!dims){
			return dims2;
		}
		
		if(!dims2){
			return dims;
		}
		
		return {
			'left':Math.min(dims.left, dims2.left),
			'right':Math.max(dims.right, dims2.right),
			'top':Math.min(dims.top, dims2.top),
			'bottom':Math.max(dims.bottom, dims2.bottom)
		};
	}
	
	function getDimensionObject($el){
		return{
			'left':$el.offset().left,
			'right':$el.offset().left + $el.outerWidth(),
			'top':$el.offset().top,
			'bottom':$el.offset().top + $el.outerHeight()
		};
	}
	
	/* Gets the full dimensions of the element, calculated by its children */
	function getTraversedDimensions(el){
		var $element = $(el);

		var resDims = getDimensionObject($element);
		
		$element.find('*').each(function(){
			var $this = $(this);
			var obDims = getDimensionObject($this);
			
			// Don't include elements which have been included off screen to the left
			// E.g. Magento's menu does this giving an odd false height for the header
			if(isVisible($this) && obDims.right > 0){
				resDims = mergeDimensions(resDims, obDims);
			}			
		});
		
		return resDims;
	}
	
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
			
			$('.balloz-toolbar-panel-content-blocks a').removeClass('active');
			
			if(!blockName){
				return;
			}
			
			var $startBlock = $('.' + getStartMarkerClass(blockName));
			var $endBlock = $('.' + getEndMarkerClass(blockName));
			var dims = getDimensionsBetweenMarker(blockName);
			var overlay = $('.developer-toolbar-overlay');
			
			if(!$startBlock.length |! $endBlock.length |! dims){
				return;
			}
			
			$this.addClass('active');
			
			if(!overlay.length){
				overlay = $('<div class="developer-toolbar-overlay"></div>');
				$('body').append(overlay);
			}
			
			overlay.show().css({
				'left':dims.left,
				'top':dims.top,
				'width':dims.right - dims.left,
				'height':dims.bottom - dims.top
			});
						
			jQuery('body').animate({scrollTop:dims.top - 25}, 500);
		});
	});
})(jQuery);