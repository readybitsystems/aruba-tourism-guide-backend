@extends('admin-db.layouts.main')
@section('admin-section')
<title>Create Places</title>
    <!-- CONTENT -->
    <main class="main_content" aria-label="content">
        <div class="container-fluid pt-2 pb-4">
            <div class="row mt-2 justify-content-center">
                <div style="max-width: 500px;">
                    <!-- Page Title -->
                    <div class="row mt-2">
                        <div class="col col-xs-12">
                            <h4 class="display-6 text-center">
                                Add New Places
                            </h4>
                        </div>
                    </div>
                    {{-- @if ($errors->has('user_name'))
                    <div class="error">{{ $errors->first('user_name') }}</div>
                    @endif --}}
                    <!-- Add Form -->
                    <form action="{{ route('Addplace') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                            <label class="labels" for="email">Tours</label>
                            <select name="tour_id" class="form-control">
                                @foreach ($tours as $tour)
                                    <option value="{{ $tour->id }}">{{ $tour->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                            <label class="labels" >Title</label>
                            <input type="text" class="form-control" placeholder="John" name="title"
                                 value="{{ old('title') }}">
                        </div>

                        @if ($errors->has('title'))
                        <div class="error" style="color: red">{{ $errors->first('title') }}</div>
                        @endif

                        <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                            <label class="labels" >Sub Title</label>
                            <input type="text" class="form-control" placeholder="Sub title" name="sub_title"
                                 value="{{ old('sub_title') }}">
                        </div>

                        

                        <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                            <label class="labels" for="phone">Audio</label>
                            <input type="file" class="form-control" name="audio" class="form-control" accept="audio/mp3">
                        </div>

                        @if ($errors->has('audio'))
                        <div class="error" style="color: red">{{ $errors->first('audio') }}</div>
                        @endif

                        <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                            <label class="labels" for="phone">Video</label>
                            <input type="file" class="form-control" name="video" class="form-control" accept="video/mp4">
                        </div>

                        @if ($errors->has('video'))
                        <div class="error" style="color: red">{{ $errors->first('video') }}</div>
                        @endif

                        <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                            <label class="labels" for="phone">Image</label>
                            <input type="file" class="form-control" accept="image/*" required name="image" class="form-control">
                        </div>

                        @if ($errors->has('image'))
                        <div class="error" style="color: red">{{ $errors->first('image') }}</div>
                        @endif

                        <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                            <label class="labels" for="phone">Other image</label>
                            <input type="file" class="form-control" name="place_image[]" class="form-control" accept="image/*" multiple>
                        </div>

                        <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
                        </div>

                        @if ($errors->has('description'))
                        <div class="error" style="color: red">{{ $errors->first('description') }}</div>
                        @endif
                        
                        <div class="row d-flex align-item-center flex-column gap-3">
                            <div class="d-flex align-item-center justify-content-between gap-3 mt-3">
                                <button class="btn btn-primary profile-button w-50" type="submit">
                                    Add Place
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
