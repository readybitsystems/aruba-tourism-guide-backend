<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Models\Country;
use App\Models\PlaceImage;
use App\Models\Tour;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $per_page = $request->per_page ?? 10;
        
        $places = Place::when($request->search, function ($query) use ($request) {
            $query->where('title', 'LIKE', '%' . $request->search . '%')
                  ->orWhere(function ($countryQuery) use ($request) {
                    $countryQuery->whereHas(
                        'tour',
                        function ($query) use ($request) {
                                $query->Where('title', 'LIKE',  '%' . $request->search . '%');
                    }
                    );
                });
            })->when($request->active, function ($query) {
            
                $query->whereRaw('flags & ?', [Place::FLAG_ACTIVE]);
            
            })
            ->with('tour')
            ->paginate($per_page);
                
        // $places = Place::orderBy('created_at', 'desc')->with('country', 'placeImages')->paginate($per_page);
        return view('admin-db.places.index',['places' => $places]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tours = Tour::all();
        return view('admin-db.places.create',['tours' => $tours]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePlaceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlaceRequest $request)
    {
        // return $request->place_image;
        if (!is_dir(public_path("assets/places/"))) {
            mkdir(public_path("assets/places/"), 0777, true);
        }
        if (!is_dir(public_path("assets/placeAudio/"))) {
            mkdir(public_path("assets/placeAudio/"), 0777, true);
        }
        if (!is_dir(public_path("assets/placeVideos/"))) {
            mkdir(public_path("assets/placeVideos/"), 0777, true);
        }
        $place              = new Place();
        $place->tour_id     = $request->tour_id;
        $place->title       = $request->title;
        $place->sub_title   = $request->sub_title;
        $place->description = $request->description;
        if (!$place->save())
            return response('Place not added', 500);
        
                if (!is_dir(public_path("assets/places/" . $place->id))) {
                    mkdir(public_path("assets/places/" . $place->id), 0777, true);
                }

                if ($request->hasFile('image')) {
                    $image = addFile($request->file('image'), public_path("assets/places/" . $place->id));
                    $place->image = $image;
                }

                if ($request->hasFile('audio')) {
                    $audio = addFile($request->file('audio'), public_path("assets/places/" . $place->id));
                    $place->audio = $audio;
                }
                
                if ($request->hasFile('video')) {
                    $video = addFile($request->file('video'), public_path("assets/places/" . $place->id));
                    $place->video = $video;
                }
       
        if ($place->save()) {
            if ($request->has('place_image')) {
                foreach ($request->place_image as $image_val) {
                    $placeImage = new PlaceImage();
                    $placeImage->place_id  = $place->id;
                    $file_name = addFile($image_val, public_path("assets/placeImages/" . $placeImage->place_id));
                    $placeImage->place_image = $file_name;
                    $placeImage->save();
                }
            }
            return redirect()
            ->route('GetPlaces')
            ->with('success', 'Place has been added successfully.');
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        if ($place)
            return $place;
        return response('Place not found', 400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        $tours = Tour::withTrashed()->get();
        $places = Place::where('id',$place->id)->with('placeImages')->first();
        return view('admin-db.places.edit', ['tours' => $tours,'places'=>$places]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePlaceRequest  $request
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlaceRequest $request, Place $place)
    {
        $place->title       = $request->input('title', $place->title);
        $place->sub_title   = $request->input('sub_title', $place->sub_title);
        $place->description = $request->input('description', $place->description);
        
        if (!$place->save())
        return response('Place not added', 500);
    
            if (!is_dir(public_path("assets/places/" . $place->id))) {
                mkdir(public_path("assets/places/" . $place->id), 0777, true);
            }

            if (!is_dir(public_path("assets/placeAudio/"))) {
                mkdir(public_path("assets/placeAudio/"), 0777, true);
            }

            if (!is_dir(public_path("assets/placeVideos/" . $place->id))) {
                mkdir(public_path("assets/placeVideos/" . $place->id), 0777, true);
            }
            if ($request->hasFile('image')) {
                $image = addFile($request->file('image'), public_path("assets/places/" . $place->id));
                $place->image = $image;
            }

            if ($request->hasFile('audio')) {
                $audio = addFile($request->file('audio'), public_path("assets/places/" . $place->id));
                $place->audio = $audio;
            }
            
            if ($request->hasFile('video')) {
                $video = addFile($request->file('video'), public_path("assets/placeVideos/" . $place->id));
                $place->video = $video;
            }

            if ($place->save()) {
                if ($request->has('place_image')) {
                    foreach ($request->place_image as $image_val) {
                        $placeImage = new PlaceImage();
                        $placeImage->place_id  = $place->id;
                        $file_name = addFile($image_val, public_path("assets/placeImages/" . $placeImage->place_id));
                        $placeImage->place_image = $file_name;
                        $placeImage->save();
                    }
                }
                return redirect()
                ->route('GetPlaces')
                ->with('success', 'Place has been updated successfully.');
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        if ($place->delete())
        return redirect()
            ->route('GetPlaces')
            ->with('success', 'Place has been delete successfully.');
        return response('something went wrong. try later!');
    }

    public function destroy_image ($place_image_id)
    {
        $image = PlaceImage::where('id', $place_image_id)->first();
        if ($image) {
            unlink(public_path().'/assets/placeImages/' . $image->place_id . '/' .$image->place_image);
        }
        $image->delete();
        return redirect()->back();
    }
}
