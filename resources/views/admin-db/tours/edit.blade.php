@extends('admin-db.layouts.main')
@section('admin-section')
<title>Edit Tour</title>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="row ">

                    <div class="row mt-5">
                        <div class="col col-xs-12">
                            <h4 class="display-6 text-center">
                                Edit Tour
                            </h4>
                        </div>
                    </div>
                    <div class="col-3">
                    </div>
                    <div class="card-body col-6">
                        <form action="{{ route('UpdateTour', $tour) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex flex-column gap-1 column-gap-2">
                                <label class="labels" for="first_name">Title</label>
                                <input type="text" class="form-control" name="title" class="form-control"
                                    value="{{ $tour->title }}">
                            </div>
                            @if ($errors->has('title'))
                                <div class="error" style="color: red">{{ $errors->first('title') }}</div>
                            @endif
                            <div class="d-flex flex-column gap-1 column-gap-2">
                                <label class="labels" for="email">Country</label>
                                <select name="country_id" class="form-control">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $country->id == $tour->country_id ? 'selected=selected' : '' }}>
                                            {{ $country->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('country_id'))
                                <div class="error" style="color: red">{{ $errors->first('country_id') }}</div>
                            @endif
                            <div class="d-flex flex-column gap-1 column-gap-2">
                                <label class="labels" for="phone">Image</label>
                                <input type="file" class="form-control" name="image" class="form-control"
                                    value="">
                            </div>
                            @if ($errors->has('image'))
                                <div class="error" style="color: red">{{ $errors->first('image') }}</div>
                            @endif
                            <div class="d-flex flex-column gap-1 column-gap-2">
                                <label class="labels" for="confirm_password">Duration</label>
                                <input type="text" class="form-control" name="duration" class="form-control"
                                    value="{{ $tour->duration }}">
                            </div>
                            @if ($errors->has('duration'))
                                <div class="error" style="color: red">{{ $errors->first('duration') }}</div>
                            @endif
                            <div class="row d-flex align-item-center flex-column gap-3">
                                <div class="d-flex align-item-center justify-content-between gap-3 mt-3">
                                    <button class="btn btn-primary profile-button w-50" type="submit">
                                        Edit User
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3">
                    </div>
                </div>
            </div>
        </main>
    </div>
    </div>
@endsection
