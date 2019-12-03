(function( $ ) {
	'use strict';

    /**
     * FAQs Toggles
     */
    $(function() {
        $('.ms-toggle-title').click(function () {
            var parent_toggle = $(this).closest('.ms-faq-toggle');
            if ( parent_toggle.hasClass( 'active' ) ) {
                $(this).find('i.fa').removeClass( 'fa-minus-circle' ).addClass( 'fa-plus-circle' );
                parent_toggle.removeClass( 'active' ).find( '.ms-toggle-content' ).slideUp( 'fast' );
            } else {
                $(this).find('i.fa').removeClass( 'fa-plus-circle' ).addClass( 'fa-minus-circle' );
                parent_toggle.addClass( 'active' ).find( '.ms-toggle-content' ).slideDown( 'fast' );
            }
        });
    });

    /**
     * FAQs Filter
     */
    $(function() {
        $('.ms-faqs-filter').click( function ( event ) {
            event.preventDefault();
            $(this).parents('li').addClass('active').siblings().removeClass('active');
            var filterSelector = $(this).attr( 'data-filter' );
            var allFAQs = $( '.ms-faq-toggle' );
            if ( filterSelector == '*' ) {
                allFAQs.show();
            } else {
                allFAQs.not( filterSelector ).hide().end().filter( filterSelector ).show();
            }
        });
    });

})( jQuery );
