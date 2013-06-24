(function($){
    $(window).load(function() {
        $('.bwImage img').hoverizr();
    }); 
   
    $('[class*="span"].dotBorderRight, [class*="span"].dotBorderLeft').each(function(){
       $(this).width( $(this).width() - 1 ); 
    });
    
    $(' .da-thumbs > li ').each( function() { $(this).hoverdir(); } );
    
    $('.sub-menu ul>li>a').click(function(e){
        var scrollClass = $(this).attr('href').replace('#','.anchor-');
        
        $('html, body').animate({
            scrollTop:$(scrollClass).offset().top - 45
    	}, 1000, function() {
            parallaxScroll(); // Callback is required for iOS
        });
        
    	return false;
    })
    
    function parallaxScroll(){
	var scrolled = $(window).scrollTop();
	$('#parallax-bg1').css('top',(0-(scrolled*.25))+'px');
	$('#parallax-bg2').css('top',(0-(scrolled*.5))+'px');
	$('#parallax-bg3').css('top',(0-(scrolled*.75))+'px');
    }
		
})(jQuery);

function openGallery ( divClass ){
    jQuery( '.'+divClass ).find( '.prettyphoto:first' ).trigger('click');
}

