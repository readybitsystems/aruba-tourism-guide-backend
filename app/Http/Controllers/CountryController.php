<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 10;

        $countries = Country::when($request->search, function ($query) use ($request) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        })->when($request->active, function ($query) {
            $query->whereRaw('flags & ?', [Country::FLAG_ACTIVE]);
        })->paginate($per_page);
        
        return view('admin-db.countries.index',['countries' => $countries]);


        // $countries = Country::orderBy('created_at', 'desc')->paginate($per_page);
        // return view('admin-db.countries.index', ["countries" => $countries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('admin-db.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCountryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCountryRequest $request)
    {
        if (!is_dir(public_path("assets/countries/"))) {
            mkdir(public_path("assets/countries/"), 0777, true);
        }
        $country        = new Country();
        $country->title = $request->title;
        if (!$country->save())
            return response('Country not added', 500);
        if (!is_dir(public_path("assets/countries/" . $country->id))) {
            mkdir(public_path("assets/countries/" . $country->id), 0777, true);
        }
        $image = addFile($request->file('image'), public_path("assets/countries/" . $country->id));
        $country->image = $image;
        if ($country->save())
            return redirect()
                ->route('GetCountries');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        if ($country)
            return $country;
        return response('Country not found', 400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('admin-db.countries.edit', ['country' => $country]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCountryRequest  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        $country->title = $request->input('title', $country->title);
        if (!$country->save())
            return response('Country not added', 500);
        if (!is_dir(public_path("assets/countries/" . $country->id))) {
            mkdir(public_path("assets/countries/" . $country->id), 0777, true);
        }
        
        if ($request->has('image')) {
            $image = addFile($request->file('image'), public_path("assets/countries/" . $country->id));
            $country->image = $image;
        }

        if ($country->save()) {

            return redirect()
                ->route('GetCountries')->
                with('success', 'country has been Updated successfully.');
        
        }
        
        response('Country not updated', 500);
    }

    public function countryImage(Country $country)
    {
        return Storage::download($country->image);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country )
    {
        // dd($country->id);
        if ($country->delete()) 

        return redirect()
            ->route('GetCountries')
            ->with('success', 'country has been delete successfully.');

        return response('something went wrong. try later!');
    }
}
