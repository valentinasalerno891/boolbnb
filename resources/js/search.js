// const { lowerFirst } = require("lodash");


$('.service').on('change', function(){
    change();
});

$('#cerca').on('click', function(){
    change();
});

// function change(){
//     var service = '';
//     var city = ($('#city').val() == '') ? '?city=0' : '?city='+$('#city').val();
//     var rooms = ($('#rooms').val() == '') ? '&room=0' : '&room='+$('#rooms').val();
//     $('.service').each(function(){
//         if ($(this).is(':checked')){
//             service = service + '&' + $(this).attr('value') + '=' + '1';
//         } else {
//             service = service + '&' + $(this).attr('value') + '=' + '0';
//         }
//     })
//     window.history.pushState("","", city+rooms+service);
// }

var url = window.location.href;
if (url.includes('?')){
    getApiParams();
    insertValues();
}

// var url_string = window.location.href; //window.location.href
// var url = new URL(url_string);
// var c = url.searchParams.get("city");
// console.log(c);

function change(){
    var params = {}
    params['city'] = ($('#city').val() == '') ? '0' : $('#city').val();
    params['rooms'] = ($('#rooms').val() == '') ? '0' : $('#rooms').val();
    $('.service').each(function(){
        if ($(this).is(':checked')){
            params[$(this).attr('value')] = '1';
        } else {
            params[$(this).attr('value')] = '0';
        }
    })
    var str = jQuery.param(params);
    window.history.pushState("","", '?' + str);
    getApiParams()
}

function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

function getApiParams(){
    var urlParams = {};
    urlParams['city'] = getUrlParameter('city');
    urlParams['rooms'] = getUrlParameter('rooms');
    for (var i=1; i<=$('.service').length; i++){
        urlParams[i] = getUrlParameter(i.toString());
    }
    console.log(urlParams);
}

function insertValues(){
    if (getUrlParameter('city') != 0){
        $('#city').val(getUrlParameter('city'));
    }
    $('#rooms').val(getUrlParameter('rooms'));
    for (var x=1; x<=$('.service').length; x++){
        if (getUrlParameter(x.toString()) == '1'){
            $('[value='+x+']').prop('checked', true);
        }
    }
}
