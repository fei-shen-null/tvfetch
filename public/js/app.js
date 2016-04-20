$(document).ready(function () {
    //globals
    loginModal = $('#loginModal');
    loginModalBtn = $('#loginModalSubmit');
    failFunc = function (xhr) {
        toastr.error(xhr.status + '<br>' + xhr.responseJSON.email);
    };
    //
    $('[data-toggle="tooltip"]').tooltip();
    $('body').scrollspy({target: "#weekScrollspy", offset: 0});
    // Add smooth scrolling on all links inside the navbar
    $("#weekNavbar").find("a").on('click', function (event) {
        // Prevent default anchor click behavior
        event.preventDefault();
        // Store hash
        var hash = this.hash;
        // Using jQuery's animate() method to add smooth page scroll
        // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
        $('html, body').animate({
            scrollTop: $(hash).offset().top
        }, 800, function () {
            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
        });
    });
    //csrf
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //logout btn
    if (checkCookie()) {
        $('#logoutBtn').show();
    } else {
        $('#logoutBtn').hide();
    }
});


var email;
function checkCookie() {
    return (document.cookie.indexOf('email=') > -1);
}
function loginModalSubmit() {
    loginModalBtn.prop('disabled', true);
    email = $('#loginModal').find('input[id=email]').val();
    email = $.trim(email);
    $.post('login', {
            email: email
        }, function (data) {
            if (data != 0) {
                toastr.info("Welcome " + email);
                setTimeout(function () {
                    window.location.reload(true)
                }, 300);
            }
        })
        .fail(failFunc)
        .always(function () {
            loginModalBtn.prop('disabled', false);
            loginModal.modal('hide');
        });
}
function unSubTv(tv) {
    if (!checkCookie()) {
        //required input email
        loginModal.modal();
        return
    }
    var btn = $('#sub' + tv).first();
    btn.fadeOut();
    $.post('unsubscribe/' + tv, {
        email: email
    }, function (data) {
        if (data != 0) {
            $('#sub' + tv)
                .attr('onclick', 'subTv(' + tv + ')')
                .addClass('glyphicon-unchecked')
                .removeClass('glyphicon-check')
                .parent().attr('data-original-title', 'Subscribe')
                .parents().eq(2).addClass("panel-default")
                .removeClass("panel-success");
            toastr.info("Subscription Canceled");
        } else {
            toastr.warning("Failed to Cancel Subscription");
        }
    }).fail(failFunc).always(btn.fadeIn());

}
function subTv(tv) {
    if (!checkCookie()) {
        //required input email
        loginModal.modal();
        return
    }
    var btn = $('#sub' + tv).first();
    btn.fadeOut();
    $.post('subscribe/' + tv, {
        email: email
    }, function (data) {
        if (data != 0) {
            btn
                .attr('onclick', 'unSubTv(' + tv + ')')
                .addClass('glyphicon-check')
                .removeClass('glyphicon-unchecked')
                .parent().attr('data-original-title', 'Unsubscribe')
                .parents().eq(2).addClass("panel-success")
                .removeClass("panel-default");
            toastr.success("Subscription Success")
        } else {
            toastr.warning("Failed to Subscribe");
        }

    }).fail(failFunc).always(btn.fadeIn());
}