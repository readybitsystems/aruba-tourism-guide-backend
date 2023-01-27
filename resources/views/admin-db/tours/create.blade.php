@extends('admin-db.layouts.main')
@section('admin-section')
<title>Create Tours</title>
    <!-- CONTENT -->
    <main class="main_content" aria-label="content">
        <div class="container-fluid pt-2 pb-4">
            <div class="row mt-2 justify-content-center">
                <div style="max-width: 500px;">
                    <!-- Page Title -->
                    <div class="row mt-2">
                        <div class="col col-xs-12">
                            <h4 class="display-6 text-center">
                                Add New Tour
                            </h4>
                        </div>
                    </div>

                    <!-- Add Form -->
                    <form action="{{ route('AddTour') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex flex-column gap-1 column-gap-2">
                            <label class="labels" for="first_name">Title</label>
                            <input type="text" class="form-control" placeholder="John" name="title"
                                class="form-control" value="{{ old('title') }}">
                        </div>
                        @if ($errors->has('title'))
                            <div class="error" style="color: red">{{ $errors->first('title') }}</div>
                        @endif
                        <div class="d-flex flex-column gap-1 column-gap-2">
                            <label class="labels" for="email">Country</label>
                            <select name="country_id" class="form-control">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('country_id'))
                            <div class="error" style="color: red">{{ $errors->first('country_id') }}</div>
                        @endif
                        <div class="d-flex flex-column gap-1 column-gap-2">
                            <label class="labels" for="phone">Image</label>
                            <input type="file" class="form-control" name="image" value="{{ old('image') }}">
                        </div>
                        @if ($errors->has('image'))
                            <div class="error" style="color: red">{{ $errors->first('image') }}</div>
                        @endif
                        <div class="d-flex flex-column gap-1 column-gap-2">
                            <label class="labels" for="confirm_password">Duration</label>
                            <input type="text" class="form-control" name="duration" value="{{ old('duration') }}">
                        </div>
                        @if ($errors->has('duration'))
                            <div class="error" style="color: red">{{ $errors->first('duration') }}</div>
                        @endif
                        <div class="row d-flex align-item-center flex-column gap-3">
                            <div class="d-flex align-item-center justify-content-between gap-3 mt-3">
                                <button class="btn btn-primary profile-button w-50" type="submit">
                                    Add User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    {{-- </div> --}}
    </main>
    <!-- CONTENT END -->
    </div>
@endsection
