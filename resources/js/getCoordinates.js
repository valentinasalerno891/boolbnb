
//dati per autocompletamento ricerca
var places = require('places.js');
places({
  appId: 'plZMYMEKV4FH',
  apiKey: '2c7357d3befb569a19e301e5338c9687',
  container: document.querySelector('#city')
});

//al click richiama la funzione
$('#myButton').on('click', function(){
    getLatLon($('#city').val());
});

//funzione per calcolare latitudine e longitudine e inviare il form alla fine del calcolo
function getLatLon(city){
    $.ajax({
        url: 'https://api.tomtom.com/search/2/geocode/'+ city +'.json?key=wBFrGupwgm95n0TA2HmZJULQ5GktiGhQ',
        method: 'GET',
        success: function(data){
            console.log(data);
            if (data.results.length != 0){
                $('#latitude').val(data.results[0].position.lat);
                $('#longitude').val(data.results[0].position.lon);

                $('#myForm').submit();
            } else {
                $('#error').show();
            }
        },
        error: function(err){
            console.log(err);
        }
    });
}
