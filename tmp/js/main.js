$(function () {

    // Detect mouse/touch events
    window.addEventListener('mousemove', function mouseMoveDetector() {
        $('html').removeClass('touchevents');
        $('html').addClass('no-touchevents');
        window.removeEventListener('mousemove', mouseMoveDetector);
    });


    // Sidebar show/hide
    $('.toggle').on('click', function () {
        var $body = $('body'),
                $window = $(window);

        if ($window.width() >= 1025) {
            $body.toggleClass('without-sidebar');
        } else {
            $body.toggleClass('with-sidebar');
        }
    });

    $('.overlay').on('click', function () {
        $('body').removeClass('with-sidebar');
    });


    // Dropdown
    $('.dropdown__toggle').on('click', function () {
        var $holder = $(this).parents('.dropdown');

        if ($holder.is('.dropdown_active')) {
            $holder.removeClass('dropdown_active');
        } else {
            $('.dropdown_active').removeClass('dropdown_active');
            $holder.addClass('dropdown_active');
        }

        return false;
    });

    $(document).on('click', function (e) {
        var $ddHolder = $(e.target).parents('.dropdown');

        if (!$ddHolder.length) {
            $('.dropdown_active').removeClass('dropdown_active');
        }
    });

    /*
     // Remove item form cart in header
     $('.minicart .remove').on('click', function(){
     var $item = $(this).parents('.minicart__group');

     $item.slideUp(200, function(){
     $item.remove();
     });
     return false;
     });

     $('.order .remove').on('click', function(){
     var $item = $(this).parents('.order__item');

     $item.slideUp(200, function(){
     $item.remove();
     });
     return false;
     });
     */

    // Popups
    $('.popup-link').magnificPopup({
        type: 'inline',
        showCloseBtn: false,
        removalDelay: 200
    });

    $('#send-message').on('click', function () {
        $.magnificPopup.open({
            items: {
                src: thanks,
                type: 'inline',
                showCloseBtn: false,
                removalDelay: 200
            }
        });
        return false;
    });

    $('.popup__close').on('click', function () {
        $.magnificPopup.close();
    });


    // Spinne
    /*
     $('.spinner').spinner({
     min: 0,
     step: 25,
     create: function(event, ui) {
     $('.ui-spinner-down').html('—');
     $('.ui-spinner-up').html('+');
     }
     });
     */

    // Sort init
    sortInit();

    // Add to cart
    $('.product__btn').on('click', function () {
        var $btn = $(this),
                $alert = $('.cart-alert');

        if (!$btn.is('.product__btn_active')) {
            showCartAlert($btn);
        } else {
            hideCartAlert();
        }

        $btn.toggleClass('product__btn_active');
        return false;
    });

    $(document).on('click', function (e) {
        if ($(e.target) != $('.product__btn')) {
            hideCartAlert();
        }
    });

    function showCartAlert(target) {
        var $alert = $('.cart-alert'),
                styles = {
                    'top': target.offset().top + target.outerHeight() + 15,
                    'right': $(window).width() - target.offset().left - target.outerWidth() - 20
                };

        if ($alert.is('.cart-alert_visible')) {
            $alert.css(styles);
        } else {
            $alert.css(styles);
            $alert.css('display', 'block');
            setTimeout(function () {
                $alert.addClass('cart-alert_visible');
            }, 0);
        }
    }

    function hideCartAlert() {
        $alert = $('.cart-alert');

        $alert.removeClass('cart-alert_visible');
        setTimeout(function () {
            $alert.css('display', 'none');
        }, 200);
    }

});

// Sort
function sortInit() {
    var $sort = $('.sort'),
            $toggle = $sort.children('.sort__toggle'),
            $value = $toggle.children('.sort__value'),
            $menu = $sort.children('.sort__dd');

    $toggle.on('click', function () {
        if ($sort.is('.sort_open')) {
            hideMenu();
        } else {
            showMenu();
        }
    });

    $menu.find('.sort__item').on('click', function () {
        changeValue(this);
    });

    $(document).on('click', function (e) {
        if (!$(e.target).parents('.sort').length && $sort.is('.sort_open')) {
            hideMenu();
        }
    });

    function hideMenu() {
        $sort.removeClass('sort_open');
    }

    function showMenu() {
        $sort.addClass('sort_open');
    }

    function changeValue(el) {
        var $item = $(el),
                newValue = $item.data('value');

        if (newValue != $value.data('current-value')) {
            $value.data('current-value', newValue);
            $value.text($item.text());
            $item.siblings('.sort__item_active').removeClass('sort__item_active');
            $item.addClass('sort__item_active');
        }
        hideMenu();
    }
}
