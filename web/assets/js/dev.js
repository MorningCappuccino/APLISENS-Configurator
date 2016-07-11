
window.log = function(){
    return console.log.apply(console, arguments);
};

var Dev = {
    Colors: {
        mainColor: '#337ab7',
        btnTextColor: '#fff',
        btnBorderColor: '#2e6da4',
        btnHoverColor: '#286090',
        btnHoverBorderColor: '#204d74'
    },
    devstyle:  function(){
        var head = $('.page-header h1');
        $.when(head.slideUp()).done(function(){ head.html('<small>logo</small>').slideDown() });
        $('.list-group-item.active').animate({
            'color': '#fff',
            'background-color': '#337ab7',
            'border-color': '#337ab7'
        }, 500, 'easeInOutBounce', function(){
            $('.btn-primary').animate({
                'color': '#fff',
                'background-color': '#337ab7',
                'border-color': '#2e6da4'
            }, 300, function(){
                $('.code-again').animate({
                    'color': '#fff',
                    'background-color': 'rgba(51, 122, 183, .9)'
                }, 300)
            })
        });

        $('.more-spec-ver').css({'color': '#337ab7'});

        $('.form-control').on('focus', function(){
            $( this ).css({
                'border-color': '#66afe9',
                'box-shadow': 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6)'
            });
        });
        $('.form-control').on('blur', function(){
            $( this ).css({
                'border-color': '',
                'box-shadow': ''
            });
        });
    },
    prodstyle:  function(){
        var head = $('.page-header h1');
        $.when(head.slideUp()).done( function(){ head.html('Configurator<img src="/assets/img/logo.png">').slideDown() });
        $('.list-group-item.active').animate({
            'color': '#2e2e2e',
            'background-color': '#ffd300',
            'border-color': '#ffd300'
        }, 500, 'easeInOutBounce', function(){
            $('.btn-primary').animate({
                'color': '#2e2e2e',
                'background-color': '#ffd300',
                'border-color': '#ebc300'
            }, 300, 'easeInOutBounce', function(){
                $('.code-again').animate({
                    'color': '#2e2e2e',
                    'background-color': 'rgba(255, 211, 0, .7))'
                }, 300)
            })
        });

        $('.more-spec-ver').css({'color': '#ffd300'});
        $('.form-control').unbind('focus');
        $('.form-control').unbind('blur');
    }
};

