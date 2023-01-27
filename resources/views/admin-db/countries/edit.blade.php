@extends('admin-db.layouts.main')
@section('admin-section')
<title>Edit Language</title>
    <!-- CONTENT -->
    <main class="main_content" aria-label="content">
        <div class="container-fluid pt-2 pb-4">
            <div class="row mt-2 justify-content-center">
                <div style="max-width: 500px;">
                    <!-- Page Title -->
                    <div class="row mt-2">
                        <div class="col col-xs-12">
                            <h4 class="display-6 text-center">
                                Edit Language
                            </h4>
                        </div>
                    </div>
                    <!-- Add Form -->
                    <form action="{{ route('UpdateCountry', $country->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex flex-column gap-1 column-gap-2">
                            <label class="labels" for="first_name">Title</label>
                            <input type="text" class="form-control" id="first_name" name="title"
                                value="{{ $country->title }}" class="form-control" value="{{ old('title') }}">
                        </div>
                        @if ($errors->has('title'))
                        <div class="error" style="color: red">{{ $errors->first('title') }}</div>
                        @endif
                        <div class="d-flex flex-column gap-1 mt-4 mt-md-0">
                            <label class="labels" for="last_name">Image</label>
                            <input type="file" class="form-control"  name="image" accept="image/*"  >
                        </div>
                        @if ($errors->has('image'))
                        <div class="error" style="color: red">{{ $errors->first('image') }}</div>
                        @endif
                        <div class="row d-flex align-item-center flex-column gap-3">
                            <div class="d-flex align-item-center justify-content-between gap-3 mt-3">
                                <button class="btn btn-primary profile-button w-50" type="submit">
                                    Update
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
