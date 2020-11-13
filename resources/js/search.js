const { lowerFirst } = require("lodash");



var url = window.location.href;

$('.service').on('change', function(){
    change();
});

$('#cerca').on('click', function(){
    change();
});





function change(){
    var service = '';
    var city = ($('#city').val() == '') ? '?city=0' : '?city='+$('#city').val();
    var rooms = ($('#rooms').val() == '') ? '&room=0' : '&room='+$('#rooms').val();
    $('.service').each(function(){
        if ($(this).is(':checked')){
            service = service + '&' + $(this).attr('value') + '=' + '1';
        } else {
            service = service + '&' + $(this).attr('value') + '=' + '0';
        }
    })
    window.history.pushState("","", city+rooms+service);
}


