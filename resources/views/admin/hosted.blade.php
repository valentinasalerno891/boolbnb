 @extends('layouts.app')
 
 <style>
    body {
        margin: 24px 0;
    }
    .spacer {
        margin-bottom: 24px;
    }
    #card-number, #cvv, #expiration-date {
        background: white;
        height: 38px;
        border: 1px solid #CED4DA;
        padding: .375rem .75rem;
        border-radius: .25rem;
    }
</style>

@section('content')
    <div class="container">
            <div class="col-md-6 offset-md-3">
                <div class="spacer"></div>
                <h1>Pagamento sponsorizzazione</h1>
                <div class="spacer"></div>

                @if (session()->has('success_message'))
                    <div class="alert alert-success">
                        {{ session()->get('success_message') }}
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
                <form action="{{ route('checkout') }}" method="POST" id="payment-form">
                    @csrf
                    @isset ($apartment)
                        <h3>Metti l'appartamento "{{$apartment->title}}" in evidenza</h3>
                        <input hidden type="text" name="apartment" value="{{$apartment->id}}">
                    @else
                    <div class="spacer"></div>
                    <div class="form-group">
                        <label for="apartment">Appartamento</label>
                        <select class="form-control" name="apartment" id="apartment">
                            @foreach ($apartments as $apartment)
                                <option value="{{$apartment->id}}">{{$apartment->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endisset
                    <div class="form-group">
                        <label for="amount">Durata sponsorizzazione</label>
                        <select class="form-control" name="amount" id="amount">
                            @foreach ($sponsors as $sponsor)
                                <option  price="{{$sponsor->price}}" value="{{$sponsor->id}}">{{$sponsor->name}} - {{$sponsor->price}}€</option>
                            @endforeach
                        </select> 
                    </div>
                    {{-- <div class="bt-drop-in-wrapper">
                        <div id="bt-dropin"></div>
                    </div> --}}
                    <div class="row">
                        <div class="col-md-6">
                            <label for="card_number">Numero carta</label>

                            <div class="form-group" id="card-number">

                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="expiration-date">Scadenza</label>

                            <div class="form-group" id="expiration-date">

                            </div>
                        </div>
                    </div>
                    <div class="spacer"></div>
                    <p>Totale: <span id="price">{{$sponsors[0]->price.'€'}}</span></p>
                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                    <button type="submit" class="btn btn-success">Checkout</button>
                </form>
            </div>
        </div>
@endsection
        

@section('script')
    <script src="https://js.braintreegateway.com/web/3.38.1/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.38.1/js/hosted-fields.min.js"></script>

    <script>
    $(document).ready(function(){

            $("#amount").val($("#amount option:first").val());
            $('#amount').on('change', function(){
                $('#price').text($('#amount option:selected').attr('price')+'€');
            })

    });
      var form = document.querySelector('#payment-form');
      var submit = document.querySelector('input[type="submit"]');
      braintree.client.create({
        authorization: '{{ $token }}'
      }, function (clientErr, clientInstance) {
        if (clientErr) {
          console.error(clientErr);
          return;
        }
        // This example shows Hosted Fields, but you can also use this
        // client instance to create additional components here, such as
        // PayPal or Data Collector.
        braintree.hostedFields.create({
          client: clientInstance,
          styles: {
            'input': {
              'font-size': '14px'
            },
            'input.invalid': {
              'color': 'red'
            },
            'input.valid': {
              'color': 'green'
            }
          },
          fields: {
            number: {
              selector: '#card-number',
              placeholder: '4111 1111 1111 1111'
            },
            // cvv: {
            //   selector: '#cvv',
            //   placeholder: '123'
            // },
            expirationDate: {
              selector: '#expiration-date',
              placeholder: '12/2020'
            }
          }
        }, function (hostedFieldsErr, hostedFieldsInstance) {
          if (hostedFieldsErr) {
            console.error(hostedFieldsErr);
            return;
          }
          // submit.removeAttribute('disabled');
          form.addEventListener('submit', function (event) {
            event.preventDefault();
            hostedFieldsInstance.tokenize(function (tokenizeErr, payload) {
              if (tokenizeErr) {
                console.error(tokenizeErr);
                return;
              }
              // If this was a real integration, this is where you would
              // send the nonce to your server.
              // console.log('Got a nonce: ' + payload.nonce);
              document.querySelector('#nonce').value = payload.nonce;
              form.submit();
            });
          }, false);
        });
      });
    </script>

@endsection