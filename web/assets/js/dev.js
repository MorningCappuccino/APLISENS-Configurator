
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
            }, 300)
        })
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
            }, 300, 'easeInOutBounce')
        })
    }
};

