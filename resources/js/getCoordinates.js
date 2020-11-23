


var places = require('places.js');
places({
  appId: 'plZMYMEKV4FH',
  apiKey: '2c7357d3befb569a19e301e5338c9687',
  container: document.querySelector('#city')
});

$('#myButton').on('click', function(){
    getLatLon($('#city').val());
})

function getLatLon(city){
    $.ajax({
        url: 'https://api.tomtom.com/search/2/geocode/'+ city +'.json?key=wBFrGupwgm95n0TA2HmZJULQ5GktiGhQ',
        method: 'GET',
        success: function(data){
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