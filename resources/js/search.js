const { lowerFirst } = require("lodash");
const { ajax } = require("jquery");
const Handlebars = require("handlebars");

// parte la ricerca degli appartamenti se inserisco un url contenente dei parametri
//se condivido la url della ricerca con altro utente si vedrà quello che ho cercato
var url = window.location.href;
if (url.includes('?') && (typeof getUrlParameter('latitude') != 'undefined') && (typeof getUrlParameter('longitude') != 'undefined')){
    
    getApiParams();
    insertValues();
    getApartments();
}

// funzione algolia per l'autocompletamento sulla ricerca
var places = require('places.js');
places({
  appId: 'plZMYMEKV4FH',
  apiKey: '2c7357d3befb569a19e301e5338c9687',
  container: document.querySelector('#city')
});


// parte la ricerca quando si selezionano uno o più servizi e si aggiornano i risultati
$('.service').on('change', function(){
    if ($('#city').val() != ''){
        changeUrlParams();
        getLatLon(getUrlParameter('city'));
    }
});

// parte la ricerca al click del pulsante cerca e si aggiornano i risultati
$('#cerca').on('click', function(){
    if ($('#city').val() != ''){
        changeUrlParams();
        getLatLon(getUrlParameter('city'));
    }
});

// funzioni per la modifica del valore dello slider in diretta
$('#distance').on('mousemove', function(){
    $('#eccolo').text($('#distance').val()+'km');
})
$('#distance').on('change',function(){
    $('#eccolo').text($('#distance').val()+'km');
})

// ottengo latitudine e longitudine della città cercata
function getLatLon(city){
    $.ajax({
        url: 'https://api.tomtom.com/search/2/geocode/'+ city +'.json?key=wBFrGupwgm95n0TA2HmZJULQ5GktiGhQ',
        method: 'GET',
        success: function(data){
            if (data){
                var firstParams = changeUrlParams();
                changeUrlLatLon(firstParams, data.results[0].position);
                getApartments();
            }
        },
        error: function(err){
            console.log(err);
        }
    });
}

// ottendo tutti gli ID dei servizi presenti sul DB
function getServicesIds(){
    var ids = [];
    $('.service').each(function(){
        ids.push($(this).attr('value'));
    })
    return ids;
}

// inserisco nell'URL i valori di latitudine e longitudine
function changeUrlLatLon(params, latLon){
    params['latitude'] = latLon.lat;
    params['longitude'] = latLon.lon;
    var str = jQuery.param(params);
    window.history.pushState("","", '?' + str);
}

// inserisco nell'URL i valori di camere, letti, distanza dal centro, città e servizi
function changeUrlParams(){
    var params = {}
    params['city'] = ($('#city').val() == '') ? '0' : $('#city').val();
    params['rooms'] = ($('#rooms').val() == '') ? '0' : $('#rooms').val();
    params['beds'] = ($('#beds').val() == '') ? '0' : $('#beds').val();
    params['distance'] = $('#distance').val();
    $('.service').each(function(){
        if ($(this).is(':checked')){
            params[$(this).attr('value')] = '1';
        } else {
            params[$(this).attr('value')] = '0';
        }
    })
    var str = jQuery.param(params);
    window.history.pushState("","", '?' + str);
    return params;
}

// ottengo il valori del parametro dell'URL passato alla funzione
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

// ottengo l'oggetto da passare all'API con i dati per la ricerca
function getApiParams(){
    var urlParams = {};
    urlParams['rooms'] = getUrlParameter('rooms') ? getUrlParameter('rooms') : '0';
    urlParams['beds'] = getUrlParameter('beds') ? getUrlParameter('beds') : '0';
    urlParams['distance'] = getUrlParameter('distance') ? getUrlParameter('distance') : '20';
    urlParams['latitude'] = getUrlParameter('latitude');
    urlParams['longitude'] = getUrlParameter('longitude');
    ids = getServicesIds();
    for (var i=0; i<ids.length; i++){
        urlParams[ids[i]] = getUrlParameter(ids[i].toString()) ? getUrlParameter(ids[i].toString()) : '0';
    }
    console.log(urlParams);
    return urlParams;
}

// se ci sono parametri presenti nell'URL popolo i relativi input con essi
function insertValues(){
    if (getUrlParameter('city') != 0){
        $('#city').val(getUrlParameter('city'));
    }
    $('#rooms').val(getUrlParameter('rooms'));
    $('#beds').val(getUrlParameter('beds'));
    var distance = getUrlParameter('distance') ?  getUrlParameter('distance') : '20';
    $('#distance').val((parseInt(distance)>200) ? '200' : distance);
    $('#eccolo').text((parseInt(distance)>200) ? '200km' : distance+'km');
    ids = getServicesIds();
    for (var x=0; x<ids.length; x++){
        if (getUrlParameter(ids[x].toString()) == '1'){
            $('[value='+ids[x]+']').prop('checked', true);
        }
    }
}

// chiamo l'API creata su laravel e ottengo la lista degli appartamenti che soddisfano la ricerca
function getApartments(){
    var source = $("#entry-template").html();
    var template = Handlebars.compile(source);
    $.ajax({
        url: 'http://localhost:8000/api/apartments',
        method: 'GET',
        data: getApiParams(),
        success: function(data){
            $('#results').empty();
            console.log(data);
            if (data.length == 0){
                $('#results').append('Nessun appartamento trovato');
            } else {
                for (var i = 0; i<data.length; i++){
                var context = data[i];
                context['description'] = context['description'].substring(0,30)+'...';
                var html = template(context);
                $('#results').append(html);
            }
            }
        },
        error: function(err){
            console.log(err);
        }
    });
}



// var url_string = window.location.href; //window.location.href
// var url = new URL(url_string);
// var c = url.searchParams.get("city");
// console.log(c);

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
