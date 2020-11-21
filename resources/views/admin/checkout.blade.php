
<html>
<head>
    <title>Braintree Payment Demo</title>
    <script src="https://static.opentok.com/v2/js/opentok.js"></script>
</head>
<body>
    <div class="content">
        @if (session('success_message'))
            <div class="alert alert-success">
                {{ session('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" id="payment-form" action="{{ url('admin/checkout') }}">
            @csrf
            <section>
                @isset ($apartment)
                    <h1>Metti l'appartamento {{$apartment->title}} in evidenza</h1>
                    <input hidden type="text" name="apartment" value="{{$apartment->id}}">
                @else
                    <label for="apartment">
                        Appartamento
                        <select name="apartment" id="apartment">
                            @foreach ($apartments as $apartment)
                                <option value="{{$apartment->id}}">{{$apartment->title}}</option>
                            @endforeach
                        </select>   
                     </label>
                @endisset
                <label for="amount">
                    Durata sponsorizzazione
                    <select name="amount" id="amount">
                        @foreach ($sponsors as $sponsor)
                            <option  price="{{$sponsor->price}}" value="{{$sponsor->id}}">{{$sponsor->name}}</option>
                        @endforeach
                    </select>   
                </label>
                <p>Prezzo: <span id="price">{{$sponsors[0]->price.'€'}}</span></p>
                <div class="bt-drop-in-wrapper">
                    <div id="bt-dropin"></div>
                </div>
            </section>

            <input id="nonce" name="payment_method_nonce" type="hidden" />
            <button class="button" type="submit"><span>Test Transaction</span></button>
        </form>
    </div>
    <script src="https://js.braintreegateway.com/web/dropin/1.13.0/js/dropin.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){

            $("#amount").val($("#amount option:first").val());
            $('#amount').on('change', function(){
                $('#price').text($('#amount option:selected').attr('price')+'€');
            })

        });
        
          
        var form = document.querySelector('#payment-form');
        
        var client_token = "{{ $token }}";
        braintree.dropin.create({
          authorization: client_token,
          selector: '#bt-dropin',
          paypal: {
            flow: 'vault'
          }
        }, function (createErr, instance) {
          if (createErr) {
            console.log('Create Error', createErr);
            return;
          }
          form.addEventListener('submit', function (event) {
            event.preventDefault();
            instance.requestPaymentMethod(function (err, payload) {
              if (err) {
                console.log('Request Payment Method Error', err);
                return;
              }
              // Add the nonce to the form and submit
              document.querySelector('#nonce').value = payload.nonce;
              form.submit();
            });
          });
        });
    </script>
</body>
</html>​