<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Apartment;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::where('user_id', Auth::id())->get();
        return view('admin.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'title' =>  'required',
            'rooms' =>  'required|numeric',
            'beds' =>  'required|numeric',
            'bathrooms' =>  'required|numeric',
            'square_meters' =>  'required|numeric',
            // 'image' =>  'required',
            'description' =>  'required',
        ]);
        
        $data['user_id'] = Auth::id();
        if(!empty($data['img'])){
            $data['img'] = Storage::disk('public')->put('images', $data['img']);
        }
        if(array_key_exists('available', $data)){
            $data['available'] = 1;
        }
        $apartment = new Apartment();
        $apartment->fill($data);
        $apartment->save();
        return redirect()->route('apartments.index')->with('status', 'Appartamento "'.$apartment->title.'" aggiunto correttamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        return view('admin.show',compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        return view('admin.edit', compact('apartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        $data = $request->all();
        $request->validate([
            'title' =>  'required',
            'rooms' =>  'required|numeric',
            'beds' =>  'required|numeric',
            'bathrooms' =>  'required|numeric',
            'square_meters' =>  'required|numeric',
            // 'image' =>  'required',
            'description' =>  'required',
        ]);
        if(!empty($data['img'])){
            $data['img'] = Storage::disk('public')->put('images', $data['img']);
        }
        if(array_key_exists('available', $data)){
            $data['available'] = 1;
        } else {
            $data['available'] = 0;
        }
        $apartment->update($data);
        return redirect()->route('apartments.index')->with('status', 'Appartamento "'.$apartment->title.'" modificato correttamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->route('apartments.index')->with('status', 'Appartamento "'.$apartment->title.'" eliminato correttamente.');
    }
}
