<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tour;
use App\Panorama;

class TourController extends Controller
{
  public function __construct(){
    $this->middleware('auth:admin');
  }

  public function index(){
    $tours = Tour::orderBy('id')->paginate(8);
    return view('home.tour.index', compact('tours'));
  }

  public function create(){
    return view('home.tour.create');
  }

  public function store(Request $request){
    $this->validate($request, [
      'description' => 'required',
      'image' => 'image|mimes:jpeg,jpg,png|max:2048',
      'panorama.*' => 'image|mimes:jpeg,jpg,png|max:2048'
    ]);
      $image = $request->file('image')->store('pictures');
      $tour =  Tour::create([
      'name' => $request->name,
      'address' => $request->address,
      'category' => $request->category,
      'region' => $request->region,
      'price' => "Rp. ".$request->price,
      'description' => $request->description,
      'image' => $image,
      'longitude' => $request->long,
      'latitude' => $request->lat
    ]);

    foreach ($request->file('panorama') as $panorama) {
      $path = $panorama->store('panorama');
      Panorama::create([
        'path' => $path,
        'tour_id' => $tour->id
      ]);
    }

    return redirect()->route('tour')->with('success','Wisata berhasil ditambahkan');

  }

  public function show(Tour $tour){
    return view('home.tour.detail', compact('tour'));
  }

}
