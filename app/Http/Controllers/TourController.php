<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Country;
use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 10;

        $tours = Tour::when($request->search, function ($query) use ($request) {
            $query->where('title', 'LIKE', '%' . $request->search . '%')
                    // ->orwhere('title', 'LIKE', '%' . $request->search . '%');
                ->orWhere(function ($countryQuery) use ($request) {
                    $countryQuery->whereHas(
                        'country',
                        function ($query) use ($request) {
                                $query->Where('title', 'LIKE',  '%' . $request->search . '%');
                    }
                    );
                });
        })->when($request->active, function ($query) {

            $query->whereRaw('flags & ?', [Country::FLAG_ACTIVE]);

        })
        ->with('country')
        ->paginate($per_page);

        return view('admin-db.tours.index', ["tours" => $tours]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country = country::all();
        return view('admin-db.tours.create', ["countries" => $country]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTourRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTourRequest $request)
    {
        if (!is_dir(public_path("assets/tours/"))) {
            mkdir(public_path("assets/tours/"), 0777, true);
        }
        $tour              = new Tour();
        $tour->country_id  = $request->country_id;
        $tour->title       = $request->title;
        $tour->duration    = $request->duration;
        if (!$tour->save())
            return redirect()->back()->with('error', 'there is an error.');
        if (!is_dir(public_path("assets/tours/" . $tour->id))) {
            mkdir(public_path("assets/tours/" . $tour->id), 0777, true);
        }
        $image = addFile($request->file('image'), public_path("assets/tours/" . $tour->id));
        $tour->image = $image;

        if ($tour->save()) 
        return redirect()->route('GetTours')->with('success', 'tour has been Updated successfully.');
        
    }

    public function edit(Tour $tour)
    {
        $countries = Country::withTrashed()->get();
        return view('admin-db.tours.edit', ['countries' => $countries,'tour'=>$tour]);
    }

    public function update(UpdateTourRequest $request, Tour $tour)
    {
        if (!is_dir(public_path("assets/tours/"))) {
            mkdir(public_path("assets/tours/"), 0777, true);
        }
        
        $tour->title       = $request->input('title', $tour->title);
        $tour->country_id   = $request->input('country_id', $tour->sub_title);
        $tour->duration = $request->input('duration', $tour->description);
        if (!$tour->save())
        return response('Tour not added', 500);
        if (!is_dir(public_path("assets/tours/" . $tour->id))) {
            mkdir(public_path("assets/tours/" . $tour->id), 0777, true);
        }
        if ($request->has('image')) {
            $image = addFile($request->file('image'), public_path("assets/tours/" . $tour->id));
            $tour->image = $image;
            $tour->save();
        }
        return redirect()
            ->route('GetTours')
            ->with('success', 'tour has been Updated successfully.');
        return response('Place not updated', 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tour $tour)
    {
        if ($tour->delete())
        return redirect()
            ->route('GetTours')
            ->with('success', 'User has been delete successfully.');
        return response('something went wrong. try later!');
    }
}
