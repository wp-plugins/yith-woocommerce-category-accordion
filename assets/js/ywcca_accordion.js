jQuery(document).ready( function($){



   var widget = $('.widget.widget_yith_wc_category_accordion'),
       ul_cont  =   widget.find( 'ul.ywcca_category_accordion_widget' ),
       highlight_cat    =   ul_cont.data( 'highlight_curr_cat' )=='on',
       main_ul = widget.find('ul');
    if ( main_ul.length ) {
        var dropdown_widget_nav = function () {

            main_ul.find('> li').each(function () {

                var main = $(this),
                    link = main.find('> a'),
                    ul = main.find('> ul.children');
                if (ul.length) {

                    //init widget

                    if (main.hasClass('closed')) {
                        ul.hide();

                        link.after('<i class="icon-plus"></i>');
                    }
                    else if (main.hasClass('opened')) {
                        link.after('<i class="icon-minus"></i>');
                    }
                    else {
                        main.addClass('opened');
                        link.after('<i class="icon-minus"></i>');
                    }

                    // on click
                    main.find('i').on('click', function () {

                        ul.slideToggle('slow');

                        if (main.hasClass('closed')) {
                            main.removeClass('closed').addClass('opened');
                            main.find('i').removeClass('icon-plus').addClass('icon-minus');
                        }
                        else {
                            main.removeClass('opened').addClass('closed');
                            main.find('i').removeClass('icon-minus').addClass('icon-plus');
                        }
                    });
                }

                if( main.hasClass('current-cat') && highlight_cat ){
                    link.addClass('highlight_cat');
                }
            });
        };
        dropdown_widget_nav();
    }



});
