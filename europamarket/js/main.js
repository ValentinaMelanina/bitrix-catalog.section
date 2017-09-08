var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

function getDeviceWidth() {
    return (window.innerWidth > 0) ? window.innerWidth : screen.width
}

// mobile version without bg image (раздел каталога товаров)
if (getDeviceWidth() < 768) {
    $('.main-wrapper').css('background-image', 'none');
}

// collapsed filters for mobile version (раздел каталога товаров)
if (getDeviceWidth() < 992) {
    $('.filters-sidebar').css('display', 'none');
}

$(document).ready(function() {
    // svg support for old browsers
    svg4everybody({});

    // Mobile menu
    $(function() {
        var posY;
        $('.mobile-menu-button').on('click', function(e) {

            $('.mobile-site-menu-wrap').toggleClass('active');

            if ($('.mobile-site-menu-wrap').hasClass('active')) {
                posY = window.pageYOffset || document.documentElement.scrollTop;
                $('.main-header').css({
                    'position': 'initial'
                });
                $('.main-wrapper, .main-footer').css({
                    'transform': 'translateX(' + $('.mobile-site-menu-wrap').outerWidth() + 'px)'
                });
                $('body').scrollTop(0);

            }
            else {
                $('.main-header').css({
                    'position': 'sticky'
                });
                $('.main-wrapper, .main-footer').css({
                    'transform': 'none'
                });
                $('body').scrollTop(posY);
            }
        });
    });

    //Catalog dropdown menu
    $(function() {
        $('.main-menu .main-link.dropdown').children('a').on('click', function(e) {
            if ($(this).parent().find('.dropdown-content').length != 0) {
                $(this).parent().toggleClass('active');
                if ($(this).parent().hasClass('active')) {
                    $(this).parent().find('.dropdown-content').fadeIn(175);
                }
                else {
                    $(this).parent().find('.dropdown-content').fadeOut(175);
                }
                e.preventDefault();
            }

        });
        var itemsQty;
        $('.main-catalog-list .category').each(function() {
            itemsQty = $(this).children('.sub-categories').children().length;
            if (itemsQty > 4) {
                $(this).children('.sub-categories').css('column-count', '2');
            }
        });
    });

    // Toggle tabs
    $('.toggle-tab').on('click', function(e) { // toggle-tab - кнопки переключения табов. В data-target прописать id блока с контентом
        $(this).addClass('active').siblings().removeClass('active');
        $('#' + $(this).data('target')).addClass('active').siblings().removeClass('active');
        e.preventDefault();
    });

    // Collapse
    $('.services-questions').css('height', $('.services-questions').outerHeight());
    $('.collapse-block').on('click', '.btn-collapse', function(e) {

        $(this).closest('.collapse-item').toggleClass('active').siblings().removeClass('active');

        if ($(this).closest('.collapse-item').hasClass('active')) {
            $(this).closest('.collapse-item').siblings().fadeOut(0);
        }
        else {
            $(this).closest('.collapse-item').siblings().fadeIn(0);
        }

        e.preventDefault();
    });

    if (getDeviceWidth() > 767) {
    //     //buy group btn
    //     $('.button-qty-include-block').on('click', '.btn-to-cart', function(e) {
    //         var target = $(this).closest('.button-qty-include-block');
    //         target.addClass('active').find('.btn-to-cart').html('В корзине');
    //         target.find('.qty-value').val('1');
    //         if (target.data('clicked') !== 'clicked') {
    //             target.find('.btn-minus').on('click', function() {
    //                 setQuantity(target.find('.qty-value'), 'down')
    //             });
    //             target.find('.btn-plus').on('click', function() {
    //                 setQuantity(target.find('.qty-value'), 'up')
    //             });
    //         }
    //         target.attr('data-clicked', 'clicked');
    //         e.preventDefault();
    //     });
    // }
    //
    // function setQuantity(input, type) {
    //     if (type === 'down') {
    //         input.val(+input.val() - 1);
    //         if (+input.val() < 1) {
    //             input.closest('.button-qty-include-block').removeClass('active')
    //         }
    //     }
    //     if (type === 'up') {
    //         input.val(+input.val() + 1);
    //     }

        $('.btn-minus').on('click', function(e) {
            e.preventDefault();
            var $this = $(this);
            var $input = $this.closest('.btn-include-qty').find('input');
            var value = parseInt($input.val());

            if (value > 1) {
                value = value - 1;
            } else {
                value = 0;
            }

            $input.val(value);

        });

        $('.btn-plus').on('click', function(e) {
            e.preventDefault();
            var $this = $(this);
            var $input = $this.closest('.btn-include-qty').find('input');
            var value = parseInt($input.val());

            if (value < 100) {
                value = value + 1;
            } else {
                value =100;
            }

            $input.val(value);
        });

    }





    // Toggle dropdown cart
    $('.btn-toggle-cart').on('click', function(e) {
        var cartContent = $(this).parent().find('.cart-content');
        cartContent.toggleClass('active');
        if (cartContent.hasClass('active')) {
            cartContent.fadeIn(175);
            $(this).css('transform', 'rotate(180deg)')
        }
        else {
            cartContent.fadeOut(175);
            $(this).css('transform', 'none')
        }
    });

    // Sliders
    $(".slider-reviews-list").owlCarousel({
        items: 2,
        margin: 30,
        dots: false,
        loop: true,
        responsive: {
            0: {
                items: 1
            },
            960: {
                items: 2
            }
        }
    });
    $(".brands-slider .brands-list").owlCarousel({
        nav: true,
        dots: false,
        items: 6,
        margin: 35,
        autoWidth: true,
        loop: true,
        autoplay: true,
        autoplayTimeout: 3500,
        navText: ["<div class='btn'><div class='chevron'></div></div>", "<div class='btn'><div class='chevron'></div></div>"]
    });

    if (getDeviceWidth() < 768) {
        $(".ready-solutions-offers-list .catalog-list").addClass('owl-carousel');
        $(".ready-solutions-offers-list .catalog-list").owlCarousel({
            items: 1,
            nav: false,
            dots: true
        });
    }

    if (getDeviceWidth() > 768) {
        $(".similar-products-list .row").removeClass('owl-carousel')
    }

    // Owl arrows
    $('.slider-control').on('click', function() {
        $(this).closest('.row').find('.' + $(this).data('target')).trigger('click');
    });

    // Review videos
    $(function() {
        $(".review-video").each(function() {
            // Зная идентификатор видео на YouTube, легко можно найти его миниатюру
            $(this).css('background-image', 'url(http://i.ytimg.com/vi/' + this.id + '/sddefault.jpg)');

            // Добавляем иконку Play поверх миниатюры, чтобы было похоже на видеоплеер
            $(this).append($('<div/>', {'class': 'play'}));
            $(this).children('.play').append('<svg class="svg-sprite-icon"><use xlink:href="images/sprite.svg#em_play"></use></svg>');

            $(document).delegate('#' + this.id, 'click', function() {
                // создаем iframe со включенной опцией autoplay
                var iframe_url = "https://www.youtube.com/embed/" + this.id + "?autoplay=1&autohide=1";
                if ($(this).data('params')) iframe_url += '&' + $(this).data('params');

                // Высота и ширина iframe должны быть такими же, как и у родительского блока
                var iframe = $('<iframe/>', {
                    'frameborder': '0',
                    'src': iframe_url,
                    'width': $(this).outerWidth(),
                    'height': $(this).outerHeight()
                });

                // Заменяем миниатюру HTML5 плеером с YouTube
                $(this).replaceWith(iframe);
            });
        });
    });

    // secondary-market collapse
    $(function() {
        $('.secondary-market .panel-group').on('hide.bs.collapse', function() {
            $(this).find('.panel-title').css('opacity', '1');
        });
        $('.secondary-market .panel-group').on('show.bs.collapse', function() {
            $(this).find('.panel-title').css('opacity', '0');
        });
    });

    // Modal windows
    // $(function() {
    //     var popupIdPostfix = "callback-modal";
    //     var mainModal = new BX.PopupWindow(
    //       popupIdPostfix,  // постфикс в id обёртки окна, если на странице несколько окон для каждого нужен свой id
    //       null, //объект - возле какого элемента на странице показаться BX("show_here"), null - в центре страницы.
    //       {
    //           content: BX('callback-modal-content'), // контент окна
    //           closeIcon: true, // нужна ли иконка закрытия, её положение
    //           overlay: {
    //               backgroundColor: '#555a63',
    //               opacity: '50'
    //           }
    //           //titleBar: {content: BX.create("span", {html: '<b>Обратная связь</b>', 'props': {'className':
    //           // 'access-title-bar'}})}, zIndex: 0, offsetLeft: 0, // Отступ слева, окно отодвинется вправо offsetTop:
    //           // 0, // Отступ сверх, окно отодвинется вниз draggable: {restrict: false}, // окно можно передвигать по
    //           // странице
    //       }
    //     );
    //
    //     // video modal
    //     var popupIdPostfix4 = "youtube-video-window",
    //       youtubeVideoWindow = new BX.PopupWindow(
    //         popupIdPostfix4,  // постфикс в id обёртки окна, если на странице несколько окон для каждого нужен свой id
    //         null, //объект - возле какого элемента на странице показаться BX("show_here"), null - в центре страницы.
    //         {
    //             content: BX('youtube-video-content'), // контент окна
    //             closeIcon: true,
    //             overlay: { // фон окна
    //                 backgroundColor: 'white',
    //                 opacity: '50'
    //             }
    //         }
    //       );
    //
    //     BX.bindDelegate(
    //       document.body, 'click', {className: 'popup-window-overlay'},
    //       function(e) {
    //           if (!e) {
    //               e = window.event;
    //           }
    //           mainModal.close();
    //           return BX.PreventDefault(e);
    //       }
    //     );
    //     BX.bindDelegate(
    //       document.body, 'click', {className: 'btn-callback'}, // Клик по тегу с классом btn-callback
    //       function(e) {
    //           if (!e) {
    //               e = window.event;
    //           }
    //
    //           BX.ajax.insertToNode('./modals/callback.php', BX('callback-modal-content'));
    //           mainModal.show(); // Показываем модальное окно
    //
    //           return BX.PreventDefault(e);
    //       }
    //     );
    //
    //     $(".youtube").each(function() {
    //         // Зная идентификатор видео на YouTube, легко можно найти его миниатюру
    //         $(this).css('background-image', 'url(http://i.ytimg.com/vi/' + this.id + '/sddefault.jpg)');
    //         //console.log(this.id);
    //         $(this).children('.play-video-btn').on('click', function(e) {
    //
    //             var videoContainer = $(this).closest('.youtube').attr('id');
    //
    //             youtubeVideoWindow.show();// Показываем модальное окно
    //
    //             // создаем iframe со включенной опцией autoplay
    //             var iframe_url = "https://www.youtube.com/embed/" + videoContainer + "?autoplay=1&autohide=1";
    //             if ($("#" + videoContainer).data('params')) iframe_url += '&' + $("#" + videoContainer).data('params');
    //
    //             // Высота и ширина iframe должны быть такими же, как и у родительского блока
    //             var iframe = $('<iframe/>', {
    //                 'frameborder': '0',
    //                 'src': iframe_url
    //             });
    //             iframe.css({
    //                 'display': 'block',
    //                 'width': $('#popup-window-content-youtube-video-window').width(),
    //                 'height': $('#youtube-video-window').outerHeight()
    //             });
    //
    //
    //             // Заменяем миниатюру HTML5 плеером с YouTube
    //             $("#popup-window-content-youtube-video-window").html('');
    //             $("#popup-window-content-youtube-video-window").append(iframe);
    //
    //             $('.popup-window-close-icon').on('click', function() {
    //                 $("#popup-window-content-youtube-video-window").html('');
    //             });
    //         });
    //     });
    // });

    // Modal slider
    $(function() {
        var popupIdPostfix = "slider-modal";
        var slidersWrap = $('.cascade-slider_slides');
        var slideItem;
        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        var mainModal = new BX.PopupWindow(
          popupIdPostfix,  // постфикс в id обёртки окна, если на странице несколько окон для каждого нужен свой id
          null, //объект - возле какого элемента на странице показаться BX("show_here"), null - в центре страницы.
          {
              content: BX('slider-modal-content'), // контент окна
              closeIcon: true, // нужна ли иконка закрытия, её положение
              overlay: {
                  backgroundColor: '#3e444e',
                  opacity: '85'
              },
              offsetTop: 50
          }
        );


        $('.certificate-image').each(function() {
            slideItem = '<div class="cascade-slider_item"><img src="' + $(this).data('src') + '" alt="' + $(this).attr('alt') + '"></div>';
            slidersWrap.append(slideItem);
        });
        $('#cascade-slider').cascadeSlider({
            // arrowClass: 'cascade-slider_item'
        });

        if (width < 768) {
            $('.cascade-slider_container').css('width', width - 30);
        }
        $(window).on('orientationchange resize', function() {
            if (width < 768) {
                width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
                $('.cascade-slider_container').css('width', width - 30);
            }
        });

        $('.cascade-slider_item').on('click', function() {
            if ($(this).hasClass('next')) {
                $('.cascade-slider_arrow[data-action="next"]').trigger('click');
            }
            if ($(this).hasClass('prev')) {
                $('.cascade-slider_arrow[data-action="prev"]').trigger('click');
            }
        });

        BX.bindDelegate(
          document.body, 'click', {className: 'certificate-image'}, // Клик по тегу с классом btn-callback
          function(e) {
              if (!e) {
                  e = window.event;
              }

              $('.cascade-slider_item[data-slide-number="' + $(this).data('index') + '"]').removeClass('now next prev').addClass('now').siblings().removeClass('now next prev');
              if ($('.cascade-slider_item.now').prev().length) {
                  $('.cascade-slider_item.now').prev().addClass('prev');
              }
              else {
                  $('.cascade-slider_item:last-child').addClass('prev');
              }

              if ($('.cascade-slider_item.now').next().length) {
                  $('.cascade-slider_item.now').next().addClass('next');
              }
              else {
                  $('.cascade-slider_item:first-child').addClass('next');
              }

              mainModal.show(); // Показываем модальное окно

              return BX.PreventDefault(e);
          }
        );
        BX.bindDelegate(
          document.body, 'click', {className: 'popup-window-overlay'},
          function(e) {
              if (!e) {
                  e = window.event;
              }
              mainModal.close();
              return BX.PreventDefault(e);
          }
        );
    });

    // catalog-page-list
    $(function() {
        var categories = $('.catalog-page-list-item'),
          moreBtn = categories.find('.see-more-list');

        moreBtn.on('click', function(e) {
            if (!$(this).hasClass('active')) {
                for (var i = 0; i < $(this).parent().find('.subcategory-item').length; i++) {
                    if (i > 9) {
                        $($(this).parent().find('.subcategory-item')[i]).removeClass('hidden')
                    }
                }
                $(this).addClass('active');
            }
            else {
                for (var i = 0; i < $(this).parent().find('.subcategory-item').length; i++) {
                    if (i > 9) {
                        $($(this).parent().find('.subcategory-item')[i]).addClass('hidden')
                    }
                }
                $(this).removeClass('active');
            }

            e.preventDefault();
        })

    });

    // TODO: [mikhail] страница о компании
    // about us page video banner
    $('.video-banner-link').on('click', function(e) {
        $('.close-video').toggle();
        $('.video-replacement').fadeToggle('fast');
        var iframe_url = 'https://www.youtube.com/embed/' + this.id + '?rel=0&amp;controls=1&amp;showinfo=0&amp;autoplay=1&amp;autohide=1';
        var iframe = $('<iframe/>', {
            'frameborder': '0',
            'src': iframe_url
        });
        iframe.css({
            'display': 'block',
            'width': $('.video-replacement').width(),
            'height': $('.video-replacement').outerHeight()
        });
        $('.video-replacement').html('');
        $('.video-replacement').append(iframe);
        e.preventDefault();
    });
    $('.close-video').on('click', function(e) {
        $('.close-video').toggle();
        $('.video-replacement').fadeOut('fast');
        $('.video-replacement').html('');
        e.preventDefault();
    });

    // TODO: [mikhail] страница карточка товара
    // set main quantity
    var detailedCardQuantity = $('.product-card .quantity-control');
    detailedCardQuantity.find('.qty-value').val('1');
    if (detailedCardQuantity.data('clicked') !== 'clicked') {
        detailedCardQuantity.find('.btn-minus').on('click', function() {
            detailedCardSetQuantity(detailedCardQuantity.find('.qty-value'), 'down')
        });
        detailedCardQuantity.find('.btn-plus').on('click', function() {
            detailedCardSetQuantity(detailedCardQuantity.find('.qty-value'), 'up')
        });
    }
    detailedCardQuantity.attr('data-clicked', 'clicked');

    function detailedCardSetQuantity(input, type) {
        if (type === 'down' && +input.val() < 2) {
            detailedCardQuantity.find('.qty-value').val('1');
        }
        if (type === 'down' && +input.val() >= 2) {
            input.val(+input.val() - 1);
        }
        if (type === 'up') {
            input.val(+input.val() + 1);
        }
    }

    // product parameters IE fix
    function adjustMarkupForIE() {
        var isIE11 = !!navigator.userAgent.match(/Trident.*rv\:11\./);
        if (isIE11) {
            $('.product-parameters .product-options-list .name').css('position', 'static');
            console.log('ЖОПА');
        }
    }
    adjustMarkupForIE();

    // toggle tabs
    $('.toggle-prices-tab').on('click', function(e) { // toggle-tab - кнопки переключения табов. В data-target прописать id блока с контентом
        $('#' + $(this).data('target')).addClass('active').siblings().removeClass('active');
        $(this).parent().addClass('active').siblings().removeClass('active');
        e.preventDefault();
    });
    $('.toggle-question-tab').on('click', function(e) { // toggle-tab - кнопки переключения табов. В data-target прописать id блока с контентом
        $('#' + $(this).data('target')).addClass('active').siblings().removeClass('active');
        $(this).parent().addClass('active').siblings().removeClass('active');
        e.preventDefault();
    });

    // add mobile owl-carousel
    if (getDeviceWidth() < 768) {
        $(".product-card-products-list .row").addClass('owl-carousel');
        $(".product-card-products-list .row").owlCarousel({
            items: 1,
            nav: false,
            dots: true
        });
    }



    // toggle question block
    $('.collapse-question-btn').on('click', function(e) {
        $(this).closest('.question-item').find('.answers-list').toggle('fast', function() {
            if ($(this).closest('.answers-list').css('display') === 'none') {
                $(this).closest('.question-item').find('.collapse-question-btn-text').text('Развернуть');
                $(this).closest('.question-item').find('.collapse-question-btn .svg-sprite-icon').css('transform', 'rotate(0deg)');
            } else {
                $(this).closest('.question-item').find('.collapse-question-btn-text').text('Свернуть');
                $(this).closest('.question-item').find('.collapse-question-btn .svg-sprite-icon').css('transform', 'rotate(180deg)');
            }
        });
        e.preventDefault();
        e.stopPropagation();
    });

    // toggle complain window
    $('.complain-btn').on('click', function(e) {
        $(this).closest('.question-content').find('.complain-window').toggle('fast');
        e.preventDefault();
    });
    $('.cancel-complain-btn').on('click', function(e) {
        $(this).closest('.question-content').find('.complain-window').fadeOut('fast');
        e.preventDefault();
    });

    // toggle answer input
    $('.answer-btn').on('click', function(e) {
        $(this).closest('.question-answer-container').find('.write-an-answer-container').toggle('fast');
        e.preventDefault();
    });
    $('.cancel-writing-answer-btn').on('click', function(e) {
        $(this).closest('.question-answer-container').find('.write-an-answer-container').toggle('fast');
        e.preventDefault();
    });

    // toggle ask a question panel
    $('.ask-through-bitrix .ask-a-question-btn').on('click', function(e) {
        $(this).closest('.tab-pane').find('.enter-a-question-panel').toggle('fast');
        $(this).toggle('fast');
        e.preventDefault();
    });

    // TODO: [mikhail] страница раздел каталога товаров
    // mobile filters collapse
    if (getDeviceWidth() < 992) {
        $('.mobile-filters-btn .collapse-filters-btn').on('click', function(e) {
            $(this).toggleClass('active');
            $('.filters-sidebar').toggle('fast');
            if ($('.mobile-search-btn .collapse-search-btn').hasClass('active')) {
                $('.mobile-search-btn .collapse-search-btn').removeClass('active');
                $('.mobile-search').toggle('fast');
            }
            e.preventDefault();
        });

        $('.mobile-search-btn .collapse-search-btn').on('click', function(e) {
            $(this).toggleClass('active');
            $('.mobile-search').toggle('fast');
            if ($('.mobile-filters-btn .collapse-filters-btn').hasClass('active')) {
                $('.mobile-filters-btn .collapse-filters-btn').removeClass('active');
                $('.filters-sidebar').toggle('fast');
            }
            e.preventDefault();
        });
        $('.mobile-search-container .close-search').on('click', function(e) {
            $('.mobile-search-btn .collapse-search-btn').removeClass('active');
            $('.mobile-search').toggle('fast');
            e.preventDefault();
        });
    }

    // collapse sorting menu mobile
    if (getDeviceWidth() < 992) {
        $('.mobile-sorting-menu .dropdown-option .active-value').text($('.mobile-sorting-menu .dropdown-option .dropdown-list li:first-child').text());
        $('#dropdown-sort-btn').on('click', function(e) {
            $('#dropdown-list-sort').toggle();
            $('#dropdown-sort-btn').toggleClass('expanded');
            e.preventDefault();
        });
        $('.mobile-sorting-menu .dropdown-option .dropdown-list li').on('click', function(e) {
            $('.mobile-sorting-menu .dropdown-option .active-value').empty('');
            if ($(this).hasClass('mobile-price-sort-item')) {
                if ($(this).closest('.dropdown-list').find('.price-up').hasClass('hidden')) {
                    $(this).addClass('up').removeClass('down');
                    $(this).clone().appendTo('.mobile-sorting-menu .dropdown-option .active-value');
                    $('.mobile-sorting-menu .dropdown-option .active-value .price-up').removeClass('hidden');
                    $('.mobile-sorting-menu .dropdown-option .active-value .price-down').addClass('hidden');
                    $('.mobile-sorting-menu .dropdown-option .dropdown-list .price-up').removeClass('hidden');
                    $('.mobile-sorting-menu .dropdown-option .dropdown-list .price-down').addClass('hidden');
                } else {
                    $(this).addClass('down').removeClass('up');
                    $(this).clone().appendTo('.mobile-sorting-menu .dropdown-option .active-value');
                    $('.mobile-sorting-menu .dropdown-option .active-value .price-down').removeClass('hidden');
                    $('.mobile-sorting-menu .dropdown-option .active-value .price-up').addClass('hidden');
                    $('.mobile-sorting-menu .dropdown-option .dropdown-list .price-down').removeClass('hidden');
                    $('.mobile-sorting-menu .dropdown-option .dropdown-list .price-up').addClass('hidden');
                }
            } else {
                $(this).clone().appendTo('.mobile-sorting-menu .dropdown-option .active-value');
            }
            $('#dropdown-list-sort').hide();
            $('#dropdown-sort-btn').removeClass('expanded');
            e.stopPropagation();
            e.preventDefault();
        });
    }

    // toggle catalog page banner
    $(function() {
        var catalogBanner = $('.catalog-banner'),
          bannerHeight = catalogBanner.innerHeight();
        if ($(catalogBanner).is(':hidden')) {
            $('body').css('padding-top', '0');
        } else {
            $('body').css('padding-top', bannerHeight);
        }
        $('.close-banner').on('click', function(e) {
            $(catalogBanner).toggle('fast', function() {
                if ($(catalogBanner).is(':hidden')) {
                    $('body').css('padding-top', '0');
                } else {
                    $('body').css('padding-top', bannerHeight);
                }
            });
            e.preventDefault();
        });
    });

    // toggle price sorting up/down icon
    $('.sort-price').on('click', function(e) {
        if ($(this).closest('.sort-items-options').find('.price-up').hasClass('hidden')) {
            $(this).addClass('up').removeClass('down');
            $('.price-up').removeClass('hidden');
            $('.price-down').addClass('hidden');
        } else {
            $(this).addClass('down').removeClass('up');
            $('.price-down').removeClass('hidden');
            $('.price-up').addClass('hidden');
        }
        e.preventDefault();
    });
    // toggle catalog view - list/tile
    $('.list-view').on('click', function(e) {
        $('.products-list').addClass('list');
        $('.products-list').removeClass('tile');
        $('.list-view').addClass('hidden');
        $('.tile-view').removeClass('hidden');
        e.preventDefault();
    });
    $('.tile-view').on('click', function(e) {
        $('.products-list').removeClass('list');
        $('.products-list').addClass('tile');
        $('.tile-view').addClass('hidden');
        $('.list-view').removeClass('hidden');
        e.preventDefault();
    });

    // toggle small crib window (discounted products filter)
    $('.show-discounted-products-crib-btn').on('click', function(e) {
        $('.discounted-products-window').toggle('fast');
    });

    // set height of video slider container
    $('.cycle-slideshow').height('405px');

    // TODO [mikhail]: страница настройки пользователя
    // JQuery Datepicket init
    $( function() {
        $( "#datepicker" ).datepicker({
            dateFormat: "dd-mm-yy"

        });
    } );

    // city dropdown menu
    $('.user-settings .main-user-info-form .active-value').text($('.user-settings .main-user-info-form .dropdown-list li:first-child').text());
    $('#form-dropdown-btn').on('click', function (e) {
        $('#form-dropdown-list').toggle();
        $('.user-settings .main-user-info-form .dropdown-list li').on('click', function () {
            $('.user-settings .main-user-info-form .active-value').text($(this).text());
            $('#form-dropdown-list').hide();
        });
        e.preventDefault();
    });


    //Вызов карт
    if ($('#shipping-areas-map').length) {
        initDeliveryMap();
    }
    if ($('#offices-map').length) {
        initOfficesWrap({lat: 59.904699, lng: 30.325556});
    }

    //TODO [danilsergeevich]: как нас найти, карта
    $(function() {
        var parentBlock = $('.offices-wrap'),
          officeBlock = parentBlock.children('.office-block'),
          tooltip,
          current,
          location;

        officeBlock.on('click', function() {
            if (!$(this).hasClass('active')) {
                location = $(this).data('location').split(',');
                location = {
                    lat: +location[0],
                    lng: +location[1]
                };
                initOfficesWrap(location);
                tooltip = $(this).children('.office-block-tooltip').removeClass('hidden').parent().addClass('active').siblings().removeClass('active').children('.office-block-tooltip').addClass('hidden');
                parentBlock.append(this);
            }

        })
    });
});

function changeImageSrc(target) {
    var laptopWidth = 992,
      tabletWidth = 768,
      laptopSrc = target.attr('data-image-lg'),
      tabletSrc = target.attr('data-image-sm'),
      mobileSrc = target.attr('data-image-xs'),
      currentWidth = $(window).width(),
      src;

    if (currentWidth >= laptopWidth) {
        src = laptopSrc;
    }
    else if (currentWidth >= tabletWidth && currentWidth < laptopWidth) {
        src = tabletSrc;
    }
    else {
        src = mobileSrc;
    }
    // console.log('target', target);
    // console.log('src', src);
    return src;
}

// shipping areas map
function initDeliveryMap() {
    var zoom = 12;
    if (getDeviceWidth() < 768) {
        zoom = 11;
    }
    var map = new google.maps.Map(document.getElementById('shipping-areas-map'), {
        zoom: zoom,
        center: {lat: 59.9111771, lng: 30.3214254},
        mapTypeId: 'roadmap',
        scrollwheel: false
    });
    // Define the LatLng coordinates for the polygon's path.
    var area1 = [
        {lat: 59.921356, lng: 30.275950},
        {lat: 59.921164, lng: 30.311911},
        {lat: 59.932622, lng: 30.343520},
        {lat: 59.932791, lng: 30.348732},
        {lat: 59.928831, lng: 30.375970},
        {lat: 59.915686, lng: 30.386226},
        {lat: 59.909280, lng: 30.384713},
        {lat: 59.907341, lng: 30.391775},
        {lat: 59.905149, lng: 30.400181},
        {lat: 59.894525, lng: 30.400518},
        {lat: 59.881113, lng: 30.364369},
        {lat: 59.877883, lng: 30.343110},
        {lat: 59.878417, lng: 30.318476},
        {lat: 59.890166, lng: 30.286240},
        {lat: 59.895277, lng: 30.254308}
    ];
    var area2 = [
        {lat: 59.929847, lng: 30.277308},
        {lat: 59.936383, lng: 30.314387},
        {lat: 59.948764, lng: 30.342539},
        {lat: 59.937587, lng: 30.411204},
        {lat: 59.923174, lng: 30.491948},
        {lat: 59.893746, lng: 30.487512},
        {lat: 59.863092, lng: 30.478639},
        {lat: 59.824302, lng: 30.377396},
        {lat: 59.842542, lng: 30.295213},
        {lat: 59.836348, lng: 30.235287},
        {lat: 59.836348, lng: 30.235287},
        {lat: 59.895142, lng: 30.239739},
        {lat: 59.905102, lng: 30.261312}
    ];

    // Construct the polygon.
    var areasParams = {
        area1: {
            paths: area1,
            strokeColor: '#98e43e',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#98e43e',
            fillOpacity: 0.4
        },
        area2: {
            paths: area2,
            strokeColor: '#e8bc29',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#e8bc29',
            fillOpacity: 0.4
        }
    };


    var areasActive = {};
    $('.shipping-areas-nav .toggle-area').each(function() {
        setActive(this)
    });
    $('.shipping-areas-nav .toggle-area').on('change', function() {
        setActive(this);
        if (!this.checked) {
            areasActive[this.getAttribute('id')].setMap(null)
        }
    });

    function setActive(elem) {
        if (elem.checked) {
            areasActive[elem.getAttribute('id')] = new google.maps.Polygon(
              areasParams[elem.getAttribute('id')]
            );
            areasActive[elem.getAttribute('id')].setMap(map);
        }
    }
}

function initOfficesWrap(pos) {
    var map = new google.maps.Map(document.getElementById('offices-map'), {
        zoom: 16,
        center: pos
    });

    var flightPlanCoordinates = [
        {lat: 59.906167, lng: 30.317692},
        {lat: 59.906259, lng: 30.318657},
        {lat: 59.903676, lng: 30.318808},
        {lat: 59.904526, lng: 30.325620},
        {lat: 59.904699, lng: 30.325556}
    ];
    var way_1 = new google.maps.Polyline({
        path: flightPlanCoordinates,
        geodesic: true,
        strokeColor: '#9f4fcc',
        strokeOpacity: 0.7,
        strokeWeight: 4
    });

    way_1.setMap(map);

    var markerIcon = {
        url: 'http://image.flaticon.com/icons/svg/252/252025.svg',
        scaledSize: new google.maps.Size(80, 80),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(32, 65),
        labelOrigin: new google.maps.Point(40, 33)
    };

    var marker = new google.maps.Marker({
        map: map,
        animation: google.maps.Animation.DROP,
        position: {lat: 59.904699, lng: 30.325556},
    });
}