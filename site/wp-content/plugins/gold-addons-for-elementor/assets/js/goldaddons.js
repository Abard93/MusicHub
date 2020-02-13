(function($) {
    "use strict";
    
    /**
     * Initialize Owl Carousel
     *
     * @since 1.0.0
     */
    var GoldAddonsCarousel = function($scope, $) {
        var ImageCarousel = $scope.find('.goldaddons-carousel:not(.owl-loaded)').each(function(i){
            var defaults = { 'navText': false },
                data = $(this).data('owl-carousel');
            
            // Portfolio Data Setup
            if( ! data ) {
               var data = {
                   items: 1,
                   margin: 20,
                   autoplay: true,
                   autoplayTimeout: 3000,
                   loop: true
               };
            }
            
            $.extend( data, defaults );
          
            $(this).owlCarousel(data);
        });
    };
    
    /**
     * Initialize Team Widget
     *
     * @since 1.0.1
     */
    var GoldAddonsTeam = function($scope, $) {
        var Button = $scope.find('.ga-social-button');
        Button.tooltip();
    };
    
    /**
     * Initialize Infinite Scroll
     *
     * @since 1.0.3
     */
    var GoldAddonsInfinite = function($scope, $) {
        var InfiniteScroll = $scope.find('.gold-addons-blog').each(function(i){
            var defaults = {
                path: '.ga-infinite a.next',
                append: '.ga-blog-entry',
                status: '.ga-posts-load-status'
            }, data = {};
            
            // If infinite scroll via button click enabled.
            if( $('#ga-infinite-load-more-btn').hasClass('ga-infinite-load-more-btn') ) {
                var data = { 
                    button: '.ga-infinite-load-more-btn', // Load posts on button click.
                    scrollThreshold: false // Disable loading on scroll.
                }; 
            }
            
            $.extend( data, defaults );
            
            if( $('#goldaddons-pagination').hasClass('ga-infinite') ) {
                $('.ga-infinite-wrapper').infiniteScroll(data);
            }
        });
    };
    
    //Elementor JS Hooks
    $( window ).on('elementor/frontend/init', function () {
        
        elementorFrontend.hooks.addAction('frontend/element_ready/global', GoldAddonsCarousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/gold-addons-team.default', GoldAddonsTeam);
        elementorFrontend.hooks.addAction('frontend/element_ready/gold-addons-blog.default', GoldAddonsInfinite);
        
    });
    
}(jQuery));
