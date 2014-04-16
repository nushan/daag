jQuery(document).ready(function() {
    var offset = 220;
    var duration = 500;
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.back-to-top').fadeIn(duration);
        } else {
            jQuery('.back-to-top').fadeOut(duration);
        }
    });
    
    jQuery('.back-to-top').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, duration);
        return false;
    })

    $('a[href*=#]').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
        && location.hostname == this.hostname) {
            var $target = $(this.hash);
            $target = $target.length && $target
            || $('[name=' + this.hash.slice(1) +']');
            if ($target.length) {
                var targetOffset = $target.offset().top;
                $('html,body')
                .animate({scrollTop: targetOffset}, 1000);

                $('a[href*=#]').removeClass('active');
                $(this).addClass('active');
                return false;
            }
        }
    });

    jQuery('#send_email').submit(function(e) {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize(),
            url: form.attr('action'),
            success: function(data) {
                var res = jQuery.parseJSON( data );
                if (res.status==true) {
                    $('#send_email').find('.alert').addClass('alert-success').html(res.msg).removeClass('hide');
                    form[0].reset();
                } else {
                    $('#send_email').find('.alert').addClass('alert-danger').html(res.msg).removeClass('hide');
                };
                
                console.log(data);
                console.log(res);
            }
        });
    });
});
