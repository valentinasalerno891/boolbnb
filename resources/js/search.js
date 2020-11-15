// const { lowerFirst } = require("lodash");

const { ajax } = require("jquery");


$('.service').on('change', function(){
    changeUrlParams();
});

$('#cerca').on('click', function(){
    changeUrlParams();
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
    // getApiParams();
    insertValues();
    getApartments();
}

// var url_string = window.location.href; //window.location.href
// var url = new URL(url_string);
// var c = url.searchParams.get("city");
// console.log(c);

function getServicesIds(){
    var ids = [];
    $('.service').each(function(){
        ids.push($(this).attr('value'));
    })
    return ids;
}

function changeUrlParams(){
    var params = {}
    params['city'] = ($('#city').val() == '') ? '0' : $('#city').val();
    params['rooms'] = ($('#rooms').val() == '') ? '0' : $('#rooms').val();
    params['beds'] = ($('#beds').val() == '') ? '0' : $('#beds').val();
    $('.service').each(function(){
        if ($(this).is(':checked')){
            params[$(this).attr('value')] = '1';
        } else {
            params[$(this).attr('value')] = '0';
        }
    })
    var str = jQuery.param(params);
    window.history.pushState("","", '?' + str);
    getApartments();
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
    urlParams['beds'] = getUrlParameter('beds');
    ids = getServicesIds();
    for (var i=0; i<ids.length; i++){
        urlParams[ids[i]] = getUrlParameter(ids[i].toString());
    }
    console.log(urlParams);
    return urlParams;
}

function insertValues(){
    if (getUrlParameter('city') != 0){
        $('#city').val(getUrlParameter('city'));
    }
    $('#rooms').val(getUrlParameter('rooms'));
    $('#beds').val(getUrlParameter('beds'));
    ids = getServicesIds();
    for (var x=0; x<ids.length; x++){
        if (getUrlParameter(ids[x].toString()) == '1'){
            $('[value='+ids[x]+']').prop('checked', true);
        }
    }
}

function getApartments(){
    console.log('prova');
    $.ajax({
        url: 'http://localhost:8000/api/apartments',
        method: 'GET',
        data: getApiParams(),
        success: function(data){
            // return data;
            console.log(data);
        },
        error: function(err){
            console.log(err);
        }
    });
}
