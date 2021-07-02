(function ($) {
    "use strict";
    var wow = new WOW(
        {
            boxClass: 'wow',      // default
            animateClass: 'animated', // default
            offset: 0,          // default
            mobile: true,       // default
            live: true        // default
        }
    )
    wow.init();
    // Header fix js
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 1) {
            $(".site_header").addClass("shrink-header");
        } else {
            $(".site_header").removeClass("shrink-header");
        }

        if (scroll >= 450) {
            $(".product_main_tab_wrapper").addClass("shrink-tab-content");
        } else {
            $(".product_main_tab_wrapper").removeClass("shrink-tab-content");
        }

//         if (scroll + $(window).height() > $('.footer_content_wrapper').offset().top) {
//             $(".product_main_tab_wrapper").removeClass("shrink-tab-content");
//         }
    });

    // Search Toggle
    $("body").on("click", ".search_trigger img", function () {
        $(this).parents("li").addClass("clicked");
        $(this).addClass("search_close");
    });

    $("body").on("click", ".search_trigger .search_close", function () {
        $(this).parents("li").removeClass("clicked");
        $(this).removeClass("search_close");
    });

    $("body").on("click", ".changelog", function () {
        var changelog_position = $(".product_main_tab_wrapper .nav-item #changelog-tab").offset();
        console.log(changelog_position);
        $("html, body").animate({scrollTop: changelog_position.top});

        $(".product_main_tab_wrapper .nav-item a").removeClass("active show");
        $(".product_main_tab_wrapper .nav-item #changelog-tab").addClass("active show");
        $(".product_main_tab_wrapper .tab-pane").removeClass("active show");
        $(".product_main_tab_wrapper .tab-pane#changelog").addClass("active show");
        //$(".product_main_tab_wrapper .tab-pane#changelog .changelog_timeline_wrapper").css("margin-top", "125px");
    });

    $("body").on("click", "#product_subscription_tab a", function () {
        var hash = $(this).attr("href");
        var href = hash.replace(/^#/, "");
        if (href === "yearly") {
            $(this).parents(".product_subscription_tab_wrapper").find(".offer-icon .yearly").removeClass("hide");
            $(this).parents(".product_subscription_tab_wrapper").find(".offer-icon .lifetime").addClass("hide");
        } else {
            $(this).parents(".product_subscription_tab_wrapper").find(".offer-icon .yearly").addClass("hide");
            $(this).parents(".product_subscription_tab_wrapper").find(".offer-icon .lifetime").removeClass("hide");
        }
    });

    // $('body').on('click', '.upgrade_url', function () {
    //     $('.tab-pane').removeClass('active show');
    //     $('#upgrade').addClass('active show');
    // });
    $.urlParam = function (name) {
        var results = new RegExp("[?&]" + name + "=([^&#]*)").exec(
            window.location.href
        );
        if (results == null) {
            return null;
        }
        return decodeURI(results[1]) || 0;
    };
    var url = window.location.href;
    var view_param = $.urlParam("view");
    var action_param = $.urlParam("action");
    if (view_param == "upgrades" || action_param == "manage_licenses") {
        $(".nav-link").removeClass("active");
        $("#manage-tab").addClass("active");
        $(".tab-pane").removeClass("active show");
        $("#manage").addClass("active show");
    }
    //console.log(view_param);
    $("body").on("click", ".site_cta.back_button", function (e) {
        e.preventDefault();
        console.log('clicked');
        var url = $(".site_cta.back_button").attr("href");
        Cookies.remove('tab');
        Cookies.set('tab', 'manage');
        window.location = url;
        // $(".nav-link").removeClass("active");
        // $("#manage-tab").addClass("active");
        // $(".tab-pane").removeClass("active show");
        // $("#manage").addClass("active show");
    });
    $('.profile_content_wrapper .nav-link').click(function (e) {
        var tab_name = $(this).attr("href").substring(1);
        Cookies.remove('tab');
        Cookies.set('tab', tab_name);
    });

    // var url_parts = url.split("/")[3];
    // if(Cookies.get('tab') === 'manage') {
    //     $(".profile_content_wrapper .nav-link").removeClass("active");
    //     $(".profile_content_wrapper #manage-tab").addClass("active");
    //     $(".profile_content_wrapper .tab-pane").removeClass("active show");
    //     $(".profile_content_wrapper #manage").addClass("active show");
    // }

    $("body").on("click", ".changelog_load_more", function (e) {
        e.preventDefault();
        $(this).addClass("hide");
        $("body").find(".loading").removeClass("hide");

        var current_page = $("body").find(".changelog_timeline_loadmore .changelog-load-more").data("current-page");
        var total_items = $("body").find(".changelog_timeline_loadmore .changelog-load-more").data("total-items");
        var logs_per_page = $("body").find(".changelog_timeline_loadmore .changelog-load-more").data("posts-per-page");
        var download_id = $("body").find(".changelog_timeline_loadmore .changelog-load-more").data("post_id");
        var total_pages = Math.round(total_items / logs_per_page);
        //console.log(total_pages);

        var data = {
            action: "load_more_logs",
            current_page: current_page,
            total_items: total_items,
            total_pages: total_pages,
            logs_per_click: logs_per_page,
            download_id: download_id,
        };

        $.post(changelog_object.ajax_url, data, function (response) {
            var new_page = current_page + 1;
            var get_total_items = new_page * logs_per_page;
            console.log(get_total_items);
            $(".changelog-load-more").data("current-page", new_page);
            $("body").find(".loading").addClass("hide");
            $("body").find(".change_log_response").append(response);
            if (get_total_items >= total_items) {
                $("body").find(".changelog_load_more").addClass("hide");
            } else {
                $("body").find(".changelog_load_more").removeClass("hide");
            }
        });
    });

    //comment load more
    $("body").on("click", ".review_load_more", function (e) {
        e.preventDefault();
        $(this).addClass("hide");
        $("body").find(".loading").removeClass("hide");

        var current_page = $("body").find(".reviews_loadmore .review-load-more").data("current-page") + 1;
        var total_items = $("body").find(".reviews_loadmore .review-load-more").data("total-items");
        var comments_per_page = $("body").find(".reviews_loadmore .review-load-more").data("comments-per-page");
        var parent_post_id = $("body").find(".reviews_loadmore .review-load-more").data("parent-post_id");
        var total_pages = $("body").find(".reviews_loadmore .review-load-more").data("total-pages");

        //console.log(total_pages);

        var data = {
            action: "load_more_reviews",
            current_page: current_page,
            total_items: total_items,
            comments_per_page: comments_per_page,
            parent_post_id: parent_post_id,
        };

        $.post(changelog_object.ajax_url, data, function (response) {
            //console.log(response);
            // var new_page = current_page + 1;
            // var get_total_items = new_page * logs_per_page;
            // console.log(get_total_items);
            $(".review-load-more").data("current-page", current_page);
            $("body").find(".loading").addClass("hide");
            $("body").find(".edd-review-list").append(response);
            if (current_page >= total_pages) {
                $("body").find(".review_load_more").addClass("hide");
            } else {
                $("body").find(".review_load_more").removeClass("hide");
            }
        });
    });


    $(".prev.page-numbers").text("Previous");
    $(".next.page-numbers").text("Next");

    //Testimonial JS
    $(".product_screenshots").owlCarousel({
        margin: 0,
        loop: true,
        autoplay: true,
        touchDrag: true,
        autoplayTimeout: 7000,
        autoplaySpeed: 3000,
        autoplayHoverPause: true,
        fluidSpeed: true,
        navSpeed: 3000,
        dragEndSpeed: 3000,
        nav: true,
        autoHeight: true,
        responsive: {
            0: {
                items: 1,
            },
            1000: {
                items: 1,
            },
        },
    });
    $(".owl-prev").html('<i class="fa fa-chevron-left"></i>');
    $(".owl-next").html('<i class="fa fa-chevron-right"></i>');

    //$('.pgwSlider').pgwSlider();

    $("body").on("click", ".popup-btn", function () {
        var target = $(this).data("target");
        var id = target.substring(1);
        var href = $(this).attr("href");
        $(".ss_modal").attr("id", id);
        $(".ss_modal .modal-body .ss_modal_img").attr("src", href);
    });

    $("body").on("click", ".edd_sl_show_key", function () {
        var plugin_name = $(this).parents('.view-key-wrapper').find(".edd_plugin_name").val();
        var validation = $(this).parents('.view-key-wrapper').find(".edd_plugin_validation").val();
        var license_key = $(this).parents(".view-key-wrapper").find(".edd_sl_license_key").val();
        var renewal_date = $(this).parents(".view-key-wrapper").find(".edd_sl_renewal_date").val();
        var target = $(this).data("target");
        var id = target.substring(1);
        console.log(id);

        $(".lk_modal").attr("id", id);
        $(".lk_modal .modal-body .plugin_name span").html(plugin_name);
        $(".lk_modal .modal-body .license_validation span").html(validation);
        $(".lk_modal .modal-body .key span").html(license_key);
        $(".lk_modal .modal-body .renewal_date span").html(renewal_date);
    });

    $(".testimonial_carousel").owlCarousel({
        items: 1,
        margin: 0,
        loop: true,
        autoplay: true,
        touchDrag: true,
        autoplayTimeout: 7000,
        autoplaySpeed: 5000,
        autoplayHoverPause: true,
        fluidSpeed: true,
        navSpeed: 3000,
        dragEndSpeed: 3000,
        autoHeight: true,
        nav: false,
    });

    // Counter JS
    $(".counter").counterUp({
        delay: 10,
        time: 2000,
    });

    //tabbed price
    var tabbed_price_count = $("#product_subscription_tab_content .tab-pane.active .tabbed-prices .input_grp").length;

    if (tabbed_price_count % 3 === 0) {
        $("body").find(".edd_download_purchase_form").addClass("static_button");
    } else {
        if ($("body").find(".edd_download_purchase_form").hasClass("static_button")) {
            $("body").find(".edd_download_purchase_form").removeClass("static_button");
        }
    }

    $("body").on("click", "#lifetime-tab", function (e) {
        $(this).parents(".product_subscription_tab_wrapper").find(".edd_download_purchase_form").addClass("lifetime_active");

        var tabbed_price_count = $(this).parents(".product_subscription_tab_wrapper").find("#product_subscription_tab_content #lifetime .input_grp").length;

        if (tabbed_price_count % 3 === 0) {
            $(this).parents(".product_subscription_tab_wrapper").find(".edd_download_purchase_form").addClass("static_button");
        } else {
            $(this).parents(".product_subscription_tab_wrapper").find(".edd_download_purchase_form").removeClass("static_button");
        }
    });
    $("body").on("click", "#yearly-tab", function (e) {
        if ($(this).parents(".product_subscription_tab_wrapper").find(".edd_download_purchase_form").hasClass("lifetime_active")) {
            $(this).parents(".product_subscription_tab_wrapper").find(".edd_download_purchase_form").removeClass("lifetime_active");
        }

        var tabbed_price_count = $(this).parents(".product_subscription_tab_wrapper").find("#product_subscription_tab_content #yearly .input_grp").length;

        if (tabbed_price_count % 3 === 0) {
            $(this).parents(".product_subscription_tab_wrapper").find(".edd_download_purchase_form").addClass("static_button");
        } else {
            $(this).parents(".product_subscription_tab_wrapper").find(".edd_download_purchase_form").removeClass("static_button");
        }
    });

    $("body").on("click", ".input_grp input[type=radio]", function (e) {
        $(this).parents(".tabbed-prices").find(".input_grp").removeClass("active");
        $(this).parents(".input_grp").addClass("active");
    });

    if ($(".blog_posts_content article").length == 0) {
        $(".blog_posts_content").addClass("hide");
    }

    if ($(".documentations_content article").length == 0) {
        $(".documentations_content").addClass("hide");
    }

    if ($(".plugins_content article").length == 0) {
        $(".plugins_content").addClass("hide");
    }

    $("body").on("click", ".desktop_menu .search_submit", function (e) {
        var search = $("body").find(".desktop_menu #searchform #s").val();
        if (search == "") {
            $(".desktop_menu .search_trigger").removeClass("clicked");
            return false;
        }
    });

    $("body").on("click", ".mobile_navbar .search_submit", function (e) {
        var search = $("body").find(".mobile_navbar #searchform #s").val();
        if (search == "") {
            $(".mobile_navbar .search_trigger").removeClass("clicked");
            return false;
        }
    });

    $("p:empty").remove();

    $("body").on("click", "main", function (e) {
        if ($(".search_trigger").hasClass("clicked")) {
            $(".search_trigger").removeClass("clicked");
            $(".search_trigger img").removeClass("search_close");
        }
    });

    $(".comment-form-comment label").html(
        'Add a new comment <span class="required">*</span>'
    );
    //console.log($("#livedemo .product_tab_inner_content_wrapper .demo_content_box").height());
    // if($(".demo_content_box").height() == 0) {
    //     $(".demo_content_box").addClass('hide');
    // }

    //change email html
    var input = $('.es_subscription_form label input.es_txt_email');
    //console.log(input);
    $(".es_subscription_form label").contents().first().remove();
    $(".es_subscription_form label br").remove();
    //$(".es_subscription_form label").contents().second().remove();
    //$(".es_subscription_form label").append(input);
    $('.es_subscription_form').addClass('subscribe_form');
    $('.es_subscription_form .es_subscription_form_submit.es_submit_button').addClass('site_cta');
    $('.es_subscription_form .es_txt_email').addClass('form-control');
    //console.log(directory_uri.style_uri);
    var spinner_url = directory_uri.style_uri + '/assets/img/subscription_loader.gif';
    $('.es_subscription_form .es_spinner_image img').attr('src', spinner_url)

    $('body').on('click', '.edd_discount_remove', function (e) {
        $('.edd_cart_discount').css('display', 'none');
        $('.edd-cart-adjustment.inp_grp').css('display', 'none');
    });

    $('body').on('click', '.edd-cancel-discount', function (e) {
        e.preventDefault();
        $('.edd-cart-adjustment.inp_grp').css('display', 'none');
    });

    $('body').on('click', '.social_share_btn.print_btn', function (e) {
        e.preventDefault();
        window.print();
        return false;
    });

    $('body').on('submit', '.documentation_search_form', function (e) {
        e.preventDefault();
        var search_value = $('.documentation_search_form input[type=text]').val();
        var data = {
            action: "search_plugin_docs",
            search_value: search_value
        };
        $("body").find(".loading").removeClass("hide");
        $.post(docs_object.ajax_url, data, function (response) {
            $('.plugin_section').html('');
            $('.plugin_section').css('display', 'none');
            $('.docs-pagination').html('');
            $('.docs-pagination').css('display', 'none');
            $("body").find(".loading").addClass("hide");
            $("body").find(".plugin_search .search_result").html(response);
            //console.log(response);
            // var new_page = current_page + 1;
            // var get_total_items = new_page * logs_per_page;
            // console.log(get_total_items);
            // $(".review-load-more").data("current-page", current_page);
            // $("body").find(".loading").addClass("hide");
            // $("body").find(".edd-review-list").append(response);
            // if (current_page >= total_pages) {
            //     $("body").find(".review_load_more").addClass("hide");
            // } else {
            //     $("body").find(".review_load_more").removeClass("hide");
            // }
        });
    });

})(window.jQuery);
