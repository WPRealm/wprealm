/*
* stickyFloor - jQuery plugin for moving a widget to the bottom of its stack and then keep stuck to the bottom of the screen (till it hits the floor). Built for WP-Realm as an extension of
* 
* Example: jQuery('#author-widget').stickyFloor({floor: '.post'});
* parameters:
* 		floor - the element to which the sticky box should align itself too (i.e. the post content)
* $version: 0.1
* $license: GPL
* Copyright (c) 2012 Noel Tock
* http://www.noeltock.com - hello@noeltock.com
*/

(function($) {

    $.fn.stickyFloor = function(options) {

        var defaults = {
            floor: '.post'
        }

        var settings = $.extend({}, defaults, options);

        // Object
        var $sticky = this;
        var $clone = $sticky.clone();
        var $parent = $sticky.parent();
        $parent.css('position','relative');

        // Sticky Coordinates
        var stickyOffset = $parent.offset().top;
        var stickyHeight = $sticky.outerHeight(true) + parseInt($sticky.css('padding-top')) + parseInt($sticky.css('padding-bottom'));
        var stickyBoundary = stickyHeight + stickyOffset;

        // Parent Coordinates
        var parentOffset = $parent.offset().top;
        var parentHeight = $parent.outerHeight(true) + parseInt($parent.css('padding-top')) + parseInt($parent.css('padding-bottom'));
        var parentBoundary = parentHeight + parentOffset;

        // Floor Coordinates
        var floorOffset = $(settings.floor).offset().top;
        var floorHeight = $(settings.floor).outerHeight(true) + parseInt($(settings.floor).css('padding-top')) + parseInt($(settings.floor).css('padding-bottom'));
        var floorBoundary = floorOffset + floorHeight;

        // Pixels from floor relative to parent
        var marginMax = ( floorBoundary - parentBoundary ) - stickyHeight;

        $(window).scroll(function() {

            var browserTop = $(document).scrollTop();
            var browserBottom = browserTop + $(window).height();


            // Add Clone to bottom once it's out of sight (a clone)

            if ( browserTop > stickyBoundary ) {

                $clone.appendTo($parent);
                var cloneOffset = $clone.offset().top;

            } else {

                $clone.remove();

            }

            // Check if Clone needs to stick

            if ( browserBottom > parentBoundary ) {

                var n = (browserBottom - parentBoundary) - stickyHeight;
                var marginTop = null;

                switch (true) {

                    case ( n < 0 ): marginTop = 0; break;
                    case ( n > marginMax ): marginTop = marginMax; break;
                    default: marginTop = n;

                }

                $clone.css({
                    'margin-top': marginTop + 'px'
                });

            };

        });

    };

})(jQuery);

// Fire off

jQuery(document).ready(function($) {
    $('aside#article-meta').stickyFloor({floor: 'footer .post-meta'});
});
