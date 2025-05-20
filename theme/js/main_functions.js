/*!
* current-device v0.10.1 - https://github.com/matthewhudson/current-device
* MIT Licensed
*/
!function (n, e) {
    "object" == typeof exports && "object" == typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define([], e) : "object" == typeof exports ? exports.device = e() : n.device = e()
}(window, function () {
    return function (n) {
        var e = {};

        function o(t) {
            if (e[t]) return e[t].exports;
            var r = e[t] = {i: t, l: !1, exports: {}};
            return n[t].call(r.exports, r, r.exports, o), r.l = !0, r.exports
        }

        return o.m = n, o.c = e, o.d = function (n, e, t) {
            o.o(n, e) || Object.defineProperty(n, e, {enumerable: !0, get: t})
        }, o.r = function (n) {
            "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(n, Symbol.toStringTag, {value: "Module"}), Object.defineProperty(n, "__esModule", {value: !0})
        }, o.t = function (n, e) {
            if (1 & e && (n = o(n)), 8 & e) return n;
            if (4 & e && "object" == typeof n && n && n.__esModule) return n;
            var t = Object.create(null);
            if (o.r(t), Object.defineProperty(t, "default", {
                enumerable: !0,
                value: n
            }), 2 & e && "string" != typeof n) for (var r in n) o.d(t, r, function (e) {
                return n[e]
            }.bind(null, r));
            return t
        }, o.n = function (n) {
            var e = n && n.__esModule ? function () {
                return n.default
            } : function () {
                return n
            };
            return o.d(e, "a", e), e
        }, o.o = function (n, e) {
            return Object.prototype.hasOwnProperty.call(n, e)
        }, o.p = "", o(o.s = 0)
    }([function (n, e, o) {
        n.exports = o(1)
    }, function (n, e, o) {
        "use strict";
        o.r(e);
        var t = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (n) {
            return typeof n
        } : function (n) {
            return n && "function" == typeof Symbol && n.constructor === Symbol && n !== Symbol.prototype ? "symbol" : typeof n
        }, r = window.device, i = {}, a = [];
        window.device = i;
        var c = window.document.documentElement, d = window.navigator.userAgent.toLowerCase(),
            u = ["googletv", "viera", "smarttv", "internet.tv", "netcast", "nettv", "appletv", "boxee", "kylo", "roku", "dlnadoc", "pov_tv", "hbbtv", "ce-html"];

        function l(n, e) {
            return -1 !== n.indexOf(e)
        }

        function s(n) {
            return l(d, n)
        }

        function f(n) {
            return c.className.match(new RegExp(n, "i"))
        }

        function b(n) {
            var e = null;
            f(n) || (e = c.className.replace(/^\s+|\s+$/g, ""), c.className = e + " " + n)
        }

        function p(n) {
            f(n) && (c.className = c.className.replace(" " + n, ""))
        }

        function w() {
            i.landscape() ? (p("portrait"), b("landscape"), y("landscape")) : (p("landscape"), b("portrait"), y("portrait")), v()
        }

        function y(n) {
            for (var e = 0; e < a.length; e++) a[e](n)
        }

        i.macos = function () {
            return s("mac")
        }, i.ios = function () {
            return i.iphone() || i.ipod() || i.ipad()
        }, i.iphone = function () {
            return !i.windows() && s("iphone")
        }, i.ipod = function () {
            return s("ipod")
        }, i.ipad = function () {
            var n = "MacIntel" === navigator.platform && navigator.maxTouchPoints > 1;
            return s("ipad") || n
        }, i.android = function () {
            return !i.windows() && s("android")
        }, i.androidPhone = function () {
            return i.android() && s("mobile")
        }, i.androidTablet = function () {
            return i.android() && !s("mobile")
        }, i.blackberry = function () {
            return s("blackberry") || s("bb10")
        }, i.blackberryPhone = function () {
            return i.blackberry() && !s("tablet")
        }, i.blackberryTablet = function () {
            return i.blackberry() && s("tablet")
        }, i.windows = function () {
            return s("windows")
        }, i.windowsPhone = function () {
            return i.windows() && s("phone")
        }, i.windowsTablet = function () {
            return i.windows() && s("touch") && !i.windowsPhone()
        }, i.fxos = function () {
            return (s("(mobile") || s("(tablet")) && s(" rv:")
        }, i.fxosPhone = function () {
            return i.fxos() && s("mobile")
        }, i.fxosTablet = function () {
            return i.fxos() && s("tablet")
        }, i.meego = function () {
            return s("meego")
        }, i.cordova = function () {
            return window.cordova && "file:" === location.protocol
        }, i.nodeWebkit = function () {
            return "object" === t(window.process)
        }, i.mobile = function () {
            return i.androidPhone() || i.iphone() || i.ipod() || i.windowsPhone() || i.blackberryPhone() || i.fxosPhone() || i.meego()
        }, i.tablet = function () {
            return i.ipad() || i.androidTablet() || i.blackberryTablet() || i.windowsTablet() || i.fxosTablet()
        }, i.desktop = function () {
            return !i.tablet() && !i.mobile()
        }, i.television = function () {
            for (var n = 0; n < u.length;) {
                if (s(u[n])) return !0;
                n++
            }
            return !1
        }, i.portrait = function () {
            return screen.orientation && Object.prototype.hasOwnProperty.call(window, "onorientationchange") ? l(screen.orientation.type, "portrait") : i.ios() && Object.prototype.hasOwnProperty.call(window, "orientation") ? 90 !== Math.abs(window.orientation) : window.innerHeight / window.innerWidth > 1
        }, i.landscape = function () {
            return screen.orientation && Object.prototype.hasOwnProperty.call(window, "onorientationchange") ? l(screen.orientation.type, "landscape") : i.ios() && Object.prototype.hasOwnProperty.call(window, "orientation") ? 90 === Math.abs(window.orientation) : window.innerHeight / window.innerWidth < 1
        }, i.noConflict = function () {
            return window.device = r, this
        }, i.ios() ? i.ipad() ? b("ios ipad tablet") : i.iphone() ? b("ios iphone mobile") : i.ipod() && b("ios ipod mobile") : i.macos() ? b("macos desktop") : i.android() ? i.androidTablet() ? b("android tablet") : b("android mobile") : i.blackberry() ? i.blackberryTablet() ? b("blackberry tablet") : b("blackberry mobile") : i.windows() ? i.windowsTablet() ? b("windows tablet") : i.windowsPhone() ? b("windows mobile") : b("windows desktop") : i.fxos() ? i.fxosTablet() ? b("fxos tablet") : b("fxos mobile") : i.meego() ? b("meego mobile") : i.nodeWebkit() ? b("node-webkit") : i.television() ? b("television") : i.desktop() && b("desktop"), i.cordova() && b("cordova"), i.onChangeOrientation = function (n) {
            "function" == typeof n && a.push(n)
        };
        var m = "resize";

        function h(n) {
            for (var e = 0; e < n.length; e++) if (i[n[e]]()) return n[e];
            return "unknown"
        }

        function v() {
            i.orientation = h(["portrait", "landscape"])
        }

        Object.prototype.hasOwnProperty.call(window, "onorientationchange") && (m = "orientationchange"), window.addEventListener ? window.addEventListener(m, w, !1) : window.attachEvent ? window.attachEvent(m, w) : window[m] = w, w(), i.type = h(["mobile", "tablet", "desktop"]), i.os = h(["ios", "iphone", "ipad", "ipod", "android", "blackberry", "macos", "windows", "fxos", "meego", "television"]), v(), e.default = i
    }]).default
});
$('#category').on('change', function () {
    var selected = this.value;
    dataString = 'action=get-services&category-id=' + selected;

    // Определяем текущий язык на основе URL
    var currentLang = window.location.pathname.split('/')[1] || 'ru';

    $.ajax({
        type: "POST",
        url: "/requests.php",
        data: dataString,
        cache: false,
        success: function (data) {
            var defaultText = 'Выберите вид накрутки';
            var emptyText = 'Здесь пока ничего нет';

            if (currentLang == 'en') {
                defaultText = 'Select service';
                emptyText = 'Nothing here yet';
            } else if (currentLang == 'ua') {
                defaultText = 'Виберіть вид накрутки';
                emptyText = 'Тут поки нічого немає';
            }

            if (data) {
                $("#service").html('<option disabled selected>' + defaultText + '</option>');
                $("#service").append(data);
            } else {
                $("#service").html('<option selected="true" style="display:none;">' + emptyText + '</option>');
            }
        }
    });
});


function get_cha(value) {
    var selected = value;
    dataString = 'action=get-services&category-id=' + selected;

    // Определяем текущий язык на основе URL
    var currentLang = window.location.pathname.split('/')[1] || 'ru';

    $.ajax({
        type: "POST",
        url: "/requests.php",
        data: dataString,
        cache: false,
        success: function (data) {
            var defaultText = 'Выберите вид накрутки';
            var emptyText = 'Здесь пока ничего нет';

            if (currentLang == 'en') {
                defaultText = 'Select service';
                emptyText = 'Nothing here yet';
            } else if (currentLang == 'ua') {
                defaultText = 'Виберіть вид накрутки';
                emptyText = 'Тут поки нічого немає';
            }

            if (data) {
                $("#service").html('<option disabled selected>' + defaultText + '</option>');
                $("#service").append(data);
            } else {
                $("#service").html('<option selected="true" style="display:none;">' + emptyText + '</option>');
            }
        }
    });
}



function getBalance() {
    dataString = 'action=get-user-balance';
    $.ajax({
        type: "POST", url: "/requests.php", data: dataString, cache: false, success: function (data) {
            if (data) {
                $("#user-balance").html(data);
                $("#current-balance").html(data);
            }
        }
    });
}

function generateNewAPI() {
    dataString = 'action=generate-new-api';
    $.ajax({
        type: "POST",
        url: "requests.php",
        data: dataString,
        cache: false,
        beforeSend: function () {
            $("#user-api").val('Создание нового ключа API..');
        },
        success: function (data) {
            if (data) {
                $("#user-api").val(data);
            }
        }
    });
}

function selectService(ServiceID) {
    dataString = 'action=select-service&service-id=' + ServiceID;
    $.ajax({
        type: "POST", url: "/requests.php", data: dataString, cache: false, success: function (data) {
            if (data) {
                if (data == 'hashtag') {
                    $("#additional").html('<div class="form-group"><div class="form-tip">Хэштег</div><input type="text" name="hashtag" class="input-md round form-control def-text" placeholder="Хэштег" required></div>');
                } else if (data == 'comments') {
                    $("#additional").html('<div class="form-group"><div class="form-tip">Комментарии</div><textarea name="comments" class="input-md round form-control def-text" style="resize: none;" rows="8" placeholder="Комментарии (по одному в строке)" required></textarea></div>');
                } else if (data == 'mentions') {
                    $("#additional").html('<div class="form-group"><div class="form-tip">Имя пользователя</div><input type="text" name="mentions_username" class="input-md round form-control def-text" placeholder="Упоминаемый пользователь" required></div>');
                } else {
                    $("#additional").html('');
                    $("#order_quantity").prop("readonly", false);
                }
            } else {
                $("#additional").html('');
                $("#order_quantity").prop("readonly", false);
            }
        }
    });
    var autoModeAllowedForServices = [3, 4, 5, 6, 7, 8, 11, 12, 14, 25, 30, 31, 32, 33, 36, 40, 41, 43, 44, 48, 49, 52, 64, 66, 92, 94];
    var iServiceId = parseInt(ServiceID);
    var $form = $('form#new-order');
    if (autoModeAllowedForServices.indexOf(iServiceId) !== -1) {
        $form.find('.form-group[data-name=order-mode]').show();
    } else {
        $form.find('.form-group[data-name=order-mode]').find('select[name=mode]').val('link').change();
        $form.find('.form-group[data-name=order-mode]').hide();
    }
}

function reloadService() {
    // $("#service").html('<option disabled checked>Выберите вид накрутки.</option><option style="display:none;">Выберите категорию.</option>');
    // $("#sel").remove();
    // $("#category").prepend('<option disabled selected id="sel">Выберите категорию.</option>');
}

function nullQuantity() {
    $("#quantity").val(0);
}

function orderModeUpdated(el, ServiceID) {
    var $form = $(el).parents('form');
    if ($(el).val() === 'auto') {
        $form.find('.form-group[data-name=link]').find('.form-tip').html('Ссылка на аккаунт');
        $form.find('.form-group[data-name=link]').find('input[name=link]').attr('placeholder', 'Ссылка на аккаунт');
        $form.find('.form-group[data-name=posts-count]').show();
        $form.find('.form-group[data-name=quantity]').find('.form-tip').html('Количество накрутки на одну');
        $form.find('.form-group[data-name=quantity]').find('input[name=quantity]').attr('placeholder', 'Сколько крутить на одну');
        $form.find('.form-group[data-name=dispersion]').show();
        $form.find('.form-group[data-name=posts-exists-count]').show();
    } else {
        $form.find('.form-group[data-name=link]').find('.form-tip').html('Ссылка');
        $form.find('.form-group[data-name=link]').find('input[name=link]').attr('placeholder', 'Ссылка');
        $form.find('.form-group[data-name=posts-count]').hide();
        $form.find('.form-group[data-name=quantity]').find('.form-tip').html('Количество');
        $form.find('.form-group[data-name=quantity]').find('input[name=quantity]').attr('placeholder', 'Сколько крутить');
        $form.find('.form-group[data-name=dispersion]').hide();
        $form.find('.form-group[data-name=posts-exists-count]').hide();
    }
}

function removeQuantity() {
    $("#min_quantity").html("0");
    $("#max_quantity").html("0");
    $("#service-description").html("");
    $('.order_desc_block').hide();
    $("#new_order_price_usd").val(0);
    $(".new_order_price_rub").html(0);
    $("#order_quantity").val(0);
    $("#order_link").val("");
    $("#description").fadeOut();
}

function updateMinQuantity(ServiceID) {
    dataString = 'action=get-min-quantity&service-id=' + ServiceID;
    $.ajax({
        type: "POST", url: "/requests.php", data: dataString, cache: false, success: function (data) {
            if (data) {
                $("#min_quantity").html(data);
            }
        }
    });
}

function eAjax(el, action) {
    if ($(el).hasClass('disable'))
        return false;
    $(el).addClass('disable');
    var params = JSON.parse($(el).attr('data-params') || '{}');
    var data = $.extend(params, {action: action});
    $.ajax({
        type: "POST", url: "/requests.php", data: data, cache: false, success: function (html) {
            $('#m_service').html(html);
            $(el).removeClass('disable');
        }
    });
    return false;
}

function updatePrice(ServiceID, Quantity, PostsCount) {
    var dataString = 'action=get-price&service-id=' + ServiceID + '&quantity=' + Quantity + '&postsCount=' + PostsCount;
    if (Quantity > 0) {
        $.ajax({
            type: "POST", url: "/requests.php", data: dataString, cache: false, success: function (data) {
                if (data) {
                    var price_usd = data.substring(1);
                    var price_rub = price_usd * window.usd;
                    $("#new_order_price_usd").val(price_usd);
                    $("#new_order_price_usd").trigger('change');
                    $("#order_amount").val(data).trigger('change');
                    ;
                }
            }
        });
    } else {
        $("#new_order_price_usd").val(0);
        $(".new_order_price_rub").html(0);
        $("#order_amount").val(0).trigger('change');
        ;
    }
}

function updateMaxQuantity(ServiceID) {
    dataString = 'action=get-max-quantity&service-id=' + ServiceID;
    $.ajax({
        type: "POST", url: "/requests.php", data: dataString, cache: false, success: function (data) {
            if (data) {
                $("#max_quantity").html(data);
            }
        }
    });
}

function updateLinkMaxQuantity(ServiceID, Link) {
    dataString = 'action=get-link-quantity&service-id=' + ServiceID + '&link=' + Link;
    $.ajax({
        type: "POST", url: "/requests.php", data: dataString, cache: false, success: function (data) {
            if (data) {
                $("#max_quantity").html(data);
            }
        }
    });
}

function updateDescription(ServiceID) {
    $.ajax({
        type: "POST",
        url: "/requests.php",
        data: 'action=get-description&service-id=' + ServiceID,
        cache: false,
        success: function (data) {
            if (data) {
                $('.order_desc_block').show();
                $("#description").fadeIn();
                $("#service-description").html(data);
            } else {
                $('.order_right_block').hide();
            }
            $('.number1').html(Number($('.number1').html()) + 1 + Math.floor(Math.random() * 20));
            $('.number2').html(Number($('.number2').html()) + 1 + Math.floor(Math.random() * 20));
			$('.number3').html(Number($('.number3').html()) + 1 + Math.floor(Math.random() * 20));
			$('.number4').html(Number($('.number4').html()) + 1 + Math.floor(Math.random() * 20));

        }
    });
}

$("#show-order-example").click(function () {
    if ($("#example-create-order").is(':visible')) {
        $("#show-order-example").html('Показать пример.');
        $("#example-create-order").hide("slow");
    } else {
        $("#show-order-example").html('Скрыть пример.');
        $("#example-create-order").show("slow");
    }
});
$("#show-referral-url").click(function () {
    if ($("#referral-url").is(':visible')) {
        $("#show-referral-url").html('Показать партнерскую ссылку.');
        $("#referral-url").hide("slow");
    } else {
        $("#show-referral-url").html('Скрыть партнерскую ссылку.');
        $("#referral-url").show("slow");
    }
});

function captcha_reload(_this) {
    $(_this).parent().find(".captcha_img").attr('src', 'https://wiq.by/captcha.php?' + Math.random());
    $(_this).parent().find('.captcha_code').val('');
}

function getRandomInRange(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (24 * 60 * 60 * 1000 * days));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

$(document).ready(function () {
    var timer;
    var timer_view;
    var check_attempts = {};
    $(document).on('click', '.task_start', function () {
        $(document).find(".task_start").attr("disabled", true).addClass("disabled");
        var btn = $(this).button('loading');
        var btn_check = $(this).parent().find(".task_check");
        var btn_declined = $(this).parent().find(".task_declined");
        var task_ava_declined = $(this).parent().find(".task_ava_declined");
        var hash = $(this).data("task-secret");
        var task_type = $(this).data("task-type");
        var url = window.base_url + 'tasks/api.php?action=task_start&hash=' + hash;
        var win = window.open(url, '_blank', 'width=921, height=726, top=' + ((screen.height - 726) / 2) + ',left=' + ((screen.width - 921) / 2) + ', resizable=1, scrollbars=1, status=0, menubar=0, toolbar=0');
        btn.button('reset').removeClass("show").addClass("hidden");
        btn_check.removeClass("hidden");
        btn_declined.removeClass("show").addClass("hidden");
        task_ava_declined.removeClass("show").addClass("hidden");
        if (task_type == 'view_video') {
            btn_check.addClass("disabled");
            var timer_view_left = 30;
            var timer_view = setInterval(function () {
                if (timer_view_left <= 0 || win.closed) {
                    btn_check.text("Проверить").removeClass("disabled");
                    clearInterval(timer_view);
                    $('title').text("Заработок на выполнении заданий");
                    return;
                } else {
                    btn_check.text(timer_view_left + " сек");
                    $('title').text("[" + timer_view_left + "]" + " сек");
                }
                timer_view_left -= 1;
            }, 1000);
        }
        return false;
    });
    $(document).on('click', '.task_check', function () {
        var hash = $(this).attr("data-task-secret");
        task_check(hash);
    });

    function task_check(hash) {
        var btns = $("body").find("#task_btns" + hash);
        var btn_start = btns.find(".task_start");
        var btn_check = btns.find(".task_check").button('loading');
        var btn_accepted = btns.find(".task_accepted");
        var btn_declined = btns.find(".task_declined");
        var task_ava_declined = btns.find(".task_ava_declined");
        btn_declined.removeClass("show").addClass("hidden");
        task_ava_declined.removeClass("show").addClass("hidden");
        $("#refresh").attr("disabled", true).addClass("disabled");
        if (typeof check_attempts[hash] == "undefined") {
            check_attempts[hash] = 1;
        } else {
            check_attempts[hash]++;
        }
        $.ajax({
            type: "GET",
            url: window.base_url + 'tasks/api.php?action=task_check&hash=' + hash,
            success: function (data) {
                var result = JSON.parse(data);
                if (result.status && result.data && result.data.error == 'busy') {
                    btn_check.button('reset');
                    btn_check.removeClass("show").addClass("hidden");
                    btn_declined.find('span').text(result.data.error_title);
                    btn_declined.removeClass("hidden").addClass("show");
                    btn_start.removeClass("hidden").addClass("show");
                    $(document).find('.task_start').each(function (i) {
                        $(this).attr("disabled", false).removeClass("disabled");
                    });
                    $("#refresh").attr("disabled", false).removeClass("disabled");
                    return false;
                } else {
                    setTimeout(function () {
                        btn_check.button('reset');
                        btn_check.removeClass("show").addClass("hidden");
                        if (result.status && result.data && result.data.status) {
                            btn_accepted.removeClass("hidden").addClass("show");
                            balance_update();
                        } else {
                            btn_start.removeClass("hidden").addClass("show").addClass("task_started").attr("disabled", true).addClass("disabled");
                            if (result.data.error == 'ava_not_found' || result.data.error == 'eng_name') {
                                task_ava_declined.find('span').text(result.data.error_title);
                                task_ava_declined.removeClass("hidden").addClass("show");
                            } else {
                                btn_declined.find('span').text(result.data.error_title);
                                btn_declined.removeClass("hidden").addClass("show");
                            }
                        }
                        $(document).find('.task_start').each(function (i) {
                            if (!$(this).hasClass("task_started")) {
                                $(this).attr("disabled", false).removeClass("disabled");
                            }
                        });
                        $("#refresh").attr("disabled", false).removeClass("disabled");
                    }, getRandomInRange(500, 1000));
                }
            }
        });
    }

    function balance_update() {
        $.ajax({
            type: "GET", url: window.base_url + 'tasks/api.php?action=balance_get', success: function (data) {
                var result = JSON.parse(data);
                if (result.status == true) {
                    $("#user_balance").text(result.data);
                    $("#user_balance2").text(result.data);
                }
            }
        });
    }

    var tasks_filter_type = "";
    var tasks_filter_service = "";

    function readCookie(name) {
        var name_cook = name + "=";
        var spl = document.cookie.split(";");
        for (var i = 0; i < spl.length; i++) {
            var c = spl[i];
            while (c.charAt(0) == " ") {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(name_cook) == 0) {
                return c.substring(name_cook.length, c.length);
            }
        }
        return null;
    }

    if (window.location.toString().indexOf('tasks_web') > 0) {
        getlist();
    }

    function getlist() {
        $.ajax({
            type: "GET",
            url: window.base_url + 'tasks/api.php?action=getlist&filter_type=' + tasks_filter_type + '&filter_service=' + tasks_filter_service,
            beforeSend: function () {
                $('#test1').html('<div class="col-md-12 text-center pt-20"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i><span class="sr-only">Загрузка...</span><br>Загрузка</div>');
            },
            success: function (data) {
                if (data.charAt(0) == '{') {
                    var result = JSON.parse(data);
                    if (result.data.timer) {
                        $("#test1").html("<div style='text-align: center; margin-top: 20px'>" + result.data.timer + "</div>");
                        $("#refresh").attr("disabled", true).addClass("disabled");
                        $("#refresh1").attr("disabled", true).addClass("disabled");
                        $("#refresh2").attr("disabled", true).addClass("disabled");
                        $("#refresh3").attr("disabled", true).addClass("disabled");
                        $("#refresh4").attr("disabled", true).addClass("disabled");
                        var timer_remains = $('.get_list_timer').text();
                        var timer = setInterval(function () {
                            timer_remains--;
                            if (timer_remains < 1) {
                                clearInterval(timer);
                                $("#test1").html();
                                getlist();
                                $("#refresh").attr("disabled", false).removeClass("disabled");
                                $("#refresh1").attr("disabled", false).removeClass("disabled");
                                $("#refresh2").attr("disabled", false).removeClass("disabled");
                                $("#refresh3").attr("disabled", false).removeClass("disabled");
                                $("#refresh4").attr("disabled", false).removeClass("disabled");
                                return;
                            } else {
                                $('.get_list_timer').text(timer_remains);
                            }
                        }, 1000);
                    }
                } else {
                    $("#test1").html(data);
                }
            }
        });
    }

    $(document).on('click', '#refresh', function () {
        getlist();
    });
    $(document).on('click', '#refresh4', function () {
        $('#TubeModal').modal('show');
    });
    $(document).on('click', '#butns button', function () {
        if (window.location.href.indexOf("referals") > -1) {
            window.location = window.base_url + 'tasks.php';
        }
        tasks_filter_type = $(this).attr("data-type");
        tasks_filter_service = $(this).attr("data-service");
        $("#refresh").data("type", tasks_filter_type ? tasks_filter_type : '').data("service", tasks_filter_service ? tasks_filter_service : '');
        $(this).parent().find("button").removeClass("active");
        $(this).addClass("active");
        getlist();
    });
    $('[data-toggle="popover"]').popover();
    $(document).on('click', '.outdraw_cancel', function () {
        var _this = this;
        var id = $(this).data('id');
        dataString = 'action=outdraw-cancel&id=' + id;
        $.ajax({
            type: "POST", url: "/requests.php", data: dataString, success: function (data) {
                var result = JSON.parse(data);
                if (result.status == true) {
                    $(_this).closest("td").find(".outdraw_status").text('Cancel');
                    $(_this).closest("td").find(".outdraw_cancel_start").remove();
                    $(_this).closest(".popover").popover('hide');
                    location.reload();
                }
            }
        });
        return false;
    });
    $(document).on('click', '.outdraw_cancel_popover_close', function () {
        $(this).closest(".popover").popover('hide');
        return false;
    });
    $('#outpay_form input#ourbalance').click();
    $(document).on('click', '#outpay_form input.form-check-input', function () {
        if ($(this).val() == 'UserBalance') {
            $(this).closest("form").find('input#data').attr('required', false);
            $(this).closest("form").find('input#data').closest(".form-group").hide();
        } else {
            $(this).closest("form").find('input#data').attr('required', true);
            $(this).closest("form").find('input#data').closest(".form-group").show();
        }
    });
    $(document).on('submit', '#outpay_ref_form', function () {
        var _this = this;
        var type = $(this).find('input[name=exampleRadios]:checked').val();
        var amount = $(this).find('input[name=amount]').val();
        var data = $(this).find('input[name=data]').val();
        dataString = 'action=outdraw-ref&type=' + type + '&amount=' + amount + '&data=' + data;
        $.ajax({
            type: "POST", url: "/requests.php", data: dataString, success: function (data) {
                var result = JSON.parse(data);
                console.log(result);
                if (result.status == true) {
                    location.reload();
                } else {
                    $(_this).find('.out_ref_error').show();
                    $(_this).find('.out_ref_error div div').html(result.data);
                }
            }
        });
        return false;
    });
    $(document).on('click', '#outpay_ref_form input.form-check-input', function () {
        if ($(this).val() == 'UserBalance') {
            $(this).closest("form").find('input#data').attr('required', false);
            $(this).closest("form").find('input#data').closest(".form-group").hide();
        } else {
            $(this).closest("form").find('input#data').attr('required', true);
            $(this).closest("form").find('input#data').closest(".form-group").show();
        }
    });
    $(document).on('click', '.modal_received_but', function () {
        var id = $(this).data('modal-id');
        dataString = 'action=modal-received&id=' + id;
        $.ajax({
            type: "POST", url: "/requests.php", data: dataString, success: function (data) {
                var result = JSON.parse(data);
                if (result.status == true) {
                    $("#myModal_" + id).modal('hide');
                } else {
                    console.log(result);
                }
            }
        });
    });
    $('.payment_system').on('click', function () {
        var system = $(this).find('input').val();
        $(document).find('.payment_system_tab').each(function (i) {
            if ($(this).attr('id') == 'tab' + system) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        $('.payment_system_tab input[name=amount]').val('0 $');
        $('.payment_system_tab .amount_rub').text(0);
        $('.payment_error').hide();
    });
    $('.payment_system_tab input[name=amount]').on('change paste input focusout', function () {
        var amount_usd = this.value.replace(/,/, '.');
        var amount_rub = 0;
        if (!isNaN(parseFloat(amount_usd)) && amount_usd != 0 && amount_usd != '' && amount_usd != false) {
            amount_rub = (parseFloat(amount_usd) * window.usd).toFixed(2);
        }
        $('.amount_rub').text(amount_rub);
        $('.payment_system_tab input[name=amount_rub]').val(amount_rub);
    });

    $('.form_amount1').on('focusin', function () {
        var val = $(this).val();
        var val_clear = parseFloat(val.replace(/,/, '.'));
        if (val_clear == 0) {
            val_clear = '';
        }
        $(this).val(val_clear);
    });

    $('.form_amount1').on('focusout', function () {
        var val = $(this).val();
        var val_clear = parseFloat(val.replace(/,/, '.'));
        if (val == 0) {
            val_clear = '0';
        }
        $(this).val(val_clear + ' $');
    });





    $(document).on('click', '.language_select', function (e) {
        e.preventDefault();
        setCookie('lang', $(this).data('id'), 30);
        var url = window.location.href;
        var host = url.split('?');
        window.location.replace(host + '?force_redirect=1');
    });
    // $('#btn_discount_check').click(function () {
    //     $.ajax({
    //         type: 'POST', 
    //         url: 'requests.php?action=discount-check',
    //         dataType: 'json', 
    //         success: function (data, status) {
    //             if (typeof data.error !== 'undefined') {
    //                 alert(data.error);
    //                 console.log(data)
    //                 console.log(status)
    //                 $('#answ').html(data); 
    //             } else {
    //                 alert('Нет ошибки');
    //                 console.log(data)
    //                 console.log(status)
    //                 $('#answ').html(data); 
    //             } 
    //         }
    //     });
    // });
    $('#acc_change_but').click(function () {
        var but = $(this);
        var input_login = but.parent().find('#acc_change_login');
        tasks_change_acc(but, input_login);
    });
    $('#acc_change_login').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            var input_login = $(this);
            var but = input_login.parent().parent().find("#acc_change_but");
            console.log(input_login);
            console.log(but);
            tasks_change_acc(but, input_login);
        }
        event.stopPropagation();
    });

    function tasks_change_acc(but, input_login) {
        var acc_login = input_login.val();
        var error = but.parent().find('#acc_change_error');
        if (!acc_login) {
            error.html('Укажите логин аккаунта').show();
            return;
        }
        input_login.attr("disabled", true).addClass("disabled");
        but.attr("disabled", true).addClass("disabled");
        $('#acc_change_error_public').removeClass('task_acc_warning').removeClass('task_acc_success').find('span').html('&mdash;');
        $('#acc_change_error_ava').removeClass('task_acc_warning').removeClass('task_acc_success').find('span').html('&mdash;');
        $('#acc_change_error_cyrillic').removeClass('task_acc_warning').removeClass('task_acc_success').find('span').html('&mdash;');
        $('#acc_change_error_followed').removeClass('task_acc_warning').removeClass('task_acc_success').find('span').html('&mdash;');
        $('#acc_change_error_follow').removeClass('task_acc_warning').removeClass('task_acc_success').find('span').html('&mdash;');
        $('#acc_change_error_posts').removeClass('task_acc_warning').removeClass('task_acc_success').find('span').html('&mdash;');
        var recaptcha = grecaptcha.getResponse();
        $.ajax({
            type: "POST",
            url: window.base_url + 'tasks/api.php?action=acc_change',
            data: 'login=' + acc_login + '&g-recaptcha-response=' + recaptcha,
            beforeSend: function () {
                error.hide();
                but.find('i').show();
            },
            success: function (data) {
                var result = JSON.parse(data);
                if (result.status == true) {
                    location.reload();
                } else {
                    error.html(result.data.error_title).show();
                    window.grecaptcha.reset();
                    if (result.data.data.public == 1) {
                        $('#acc_change_error_public').addClass('task_acc_warning').find('span').html('&#10006;');
                    } else if (result.data.data.public == 2) {
                        $('#acc_change_error_public').addClass('task_acc_success').find('span').html('&#10004;');
                    }
                    if (result.data.data.ava == 1) {
                        $('#acc_change_error_ava').addClass('task_acc_warning').find('span').html('&#10006;');
                    } else if (result.data.data.ava == 2) {
                        $('#acc_change_error_ava').addClass('task_acc_success').find('span').html('&#10004;');
                    }
                    if (result.data.data.followed == 1) {
                        $('#acc_change_error_followed').addClass('task_acc_warning').find('span').html('&#10006;');
                    } else if (result.data.data.followed == 2) {
                        $('#acc_change_error_followed').addClass('task_acc_success').find('span').html('&#10004;');
                    }
                    if (result.data.data.follow == 1) {
                        $('#acc_change_error_follow').addClass('task_acc_warning').find('span').html('&#10006;');
                    } else if (result.data.data.follow == 2) {
                        $('#acc_change_error_follow').addClass('task_acc_success').find('span').html('&#10004;');
                    }
                    if (result.data.data.posts == 1) {
                        $('#acc_change_error_posts').addClass('task_acc_warning').find('span').html('&#10006;');
                    } else if (result.data.data.posts == 2) {
                        $('#acc_change_error_posts').addClass('task_acc_success').find('span').html('&#10004;');
                    }
                    if (result.data.data.cyrillic == 1) {
                        $('#acc_change_error_cyrillic').addClass('task_acc_warning').find('span').html('&#10006;');
                    } else if (result.data.data.cyrillic == 2) {
                        $('#acc_change_error_cyrillic').addClass('task_acc_success').find('span').html('&#10004;');
                    }
                }
                input_login.attr("disabled", false).removeClass("disabled");
                but.attr("disabled", false).removeClass("disabled");
                but.find('i').hide();
            }
        });
    }

    $(document).on('click', '.hold_disput', function (e) {
        e.preventDefault();
        var _this = $(this);
        var acc_id = _this.data("id");
        var loader = _this.parent().find('i');
        _this.attr("disabled", true).addClass("disabled");
        $.ajax({
            type: "POST",
            url: window.base_url + "requests.php?action=hold-decline-dispute",
            data: 'acc_id=' + acc_id,
            beforeSend: function () {
                loader.show();
            },
            success: function (data) {
                var result = JSON.parse(data);
                if (result.status == true) {
                    _this.parent().addClass('task_acc_success').html('Штраф отменен');
                    balance_update();
                } else {
                    _this.parent().addClass('task_acc_warning').html(result.data.data);
                }
                _this.attr("disabled", false).removeClass("disabled");
                loader.hide();
            }
        });
    });
    $('.invoice_pay_but').click(function () {
        var but = $(this);
        var invoice_id = but.data('id');
        var error = but.parent().parent().parent().find('#invoice_pay_error');
        but.attr("disabled", true).addClass("disabled");
        $.ajax({
            type: "POST",
            url: window.base_url + 'requests.php?action=invoice-pay',
            data: 'id=' + invoice_id,
            beforeSend: function () {
                error.hide();
                but.find('i').show();
            },
            success: function (data) {
                var result = JSON.parse(data);
                if (result.status == true) {
                    location.reload();
                } else {
                    error.html(result.data.data).show();
                }
                but.attr("disabled", false).removeClass("disabled");
                but.find('i').hide();
            }
        });
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});