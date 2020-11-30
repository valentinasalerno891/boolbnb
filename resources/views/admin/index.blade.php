@extends('layouts.app')

@section('title', 'Lista appartamenti')
@section('content')

<div class="container apartments-index">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
  <h2>Benvenuto, ecco i tuoi appartamenti</h2>
  @isset($apartments[0])
      <div class="table-responsive">
          <table class="table table-bordered">
              <tbody>
        @foreach ($apartments as $apartment)
            <tr class="desktop-table">
              <td><a class="apartment-title" href="{{route('apartments.show',$apartment->id)}}">{{$apartment->title}}</a></td>
              {{-- <td>{{$apartment->rooms}} stanze in questo appartamento</td> --}}
              <td class="edit-action text-center"><a class="edit" href="{{route('apartments.edit',$apartment->id)}}"><i class="far fa-edit"></i> Modifica</a></td>
              <td class="edit-action text-center"><a class="edit" href="{{route('stats.show', $apartment->id)}}"><i class="far fa-chart-bar"></i> Statistiche</a></td>
              <td class="edit-action text-center"><a class="edit" href="{{route('paymentWithId',$apartment->id)}}"><i class="fas fa-shopping-cart"></i> Sponsorizza</a></td>
              <td class="edit-delete-action text-center"><form action="{{route('apartments.destroy',$apartment->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn bool-btn-pink" type="submit"><i class="far fa-trash-alt"></i> Elimina</button>
              </form></td>
            </tr>

            <tr class="mobile-table">
              <td><a class="apartment-title" href="{{route('apartments.show',$apartment->id)}}">{{$apartment->title}}</a></td>
              {{-- <td>{{$apartment->rooms}} stanze in questo appartamento</td> --}}
              <td class="edit-action text-center"><a class="edit" href="{{route('apartments.edit',$apartment->id)}}"><i class="far fa-edit"></i></a></td>
              <td class="edit-action text-center"><a class="edit" href="{{route('stats.show', $apartment->id)}}"><i class="far fa-chart-bar"></i></a></td>
              <td class="edit-action text-center"><a class="edit" href="{{route('paymentWithId',$apartment->id)}}"><i class="fas fa-shopping-cart"></i></a></td>
              <td class="edit-delete-action text-center"><form action="{{route('apartments.destroy',$apartment->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn bool-btn-pink" type="submit"><i class="far fa-trash-alt"></i></button>
              </form></td>
            </tr>

        @endforeach
          </tbody>
          </table>
      </div>

  @endisset
</div>
@endsection
