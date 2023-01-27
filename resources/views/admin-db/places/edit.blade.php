@extends('admin-db.layouts.main')
@section('admin-section')
<title>Edit Place</title>
<link type="text/css" rel="stylesheet" href="{{ custom_public_url('/admin-assets/css/jquery-te-1.4.0.css') }}">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="row ">
                    <div class="row mt-5">
                        <div class="col col-xs-12">
                            <h4 class="display-6 text-center">
                                Edit Place
                            </h4>
                        </div>
                    </div>  
                    <div class="col-3">
                    </div>
                    <div class="card-body col-6">
                        <form action="{{ route('UpdatePlace', $places) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                                <label class="labels" for="email">Tours</label>
                                <select name="tour_id" class="form-control">
                                    @foreach ($tours as $tour)
                                        <option value="{{ $tour->id }}"  {{($tour->id == $places->tours_id ? 'selected=selected' : '')}} >{{ $tour->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                                <label class="labels">Title</label>
                                <input type="text" class="form-control" name="title" value="{{ $places->title }}">
                            </div>

                            <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                                <label class="labels">Sub Title</label>
                                <input type="text" class="form-control" name="sub_title" value="{{ $places->sub_title }}">
                            </div>

                            <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                                <label class="labels" for="phone">Audio</label>
                                <input type="file" class="form-control" name="audio" class="form-control" accept="audio/mp3">
                            </div>
    
                            <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                                <label class="labels" for="phone">Video</label>
                                <input type="file" class="form-control" name="video" class="form-control" accept="video/mp4">
                            </div>
    
                            <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                                <label class="labels" for="phone">Image</label>
                                <input type="file" class="form-control" name="image" class="form-control"
                                accept="image/*">
                            </div>

                            <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                                <label class="labels" for="phone">Other image</label>
                                <input type="file" class="form-control" name="place_image[]" class="form-control"
                                accept="image/*" multiple>
                            </div>
                            <div class="d-flex flex-column gap-1 column-gap-2 mt-2">
                                <label for="test" class="form-label">Description</label>
                                <textarea style="height:500px" class="form-control" id="test" rows="10" name="description"><?php echo $places->description;?></textarea>
                            </div>
                            <div class="row d-flex align-item-center flex-column gap-3">
                                <div class="d-flex align-item-center justify-content-between gap-3 mt-3">
                                    <button class="btn btn-primary profile-button w-50" type="submit">
                                        Update Place
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="shadow rounded">
                            <div class="table-responsive">
                                <table class="table" class="mb-0" width="100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="border-bottom py-3">#</th>
                                            <th class="border-bottom py-3">Image</th>
                                            <th class="border-bottom py-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($places->placeImages as $place_image)
                                            <tr>
                                                <td class="py-3">{{ $i++ }}</td>
                                                <td class="py-3"><img style="width: 150px; height: auto;" src="<?php echo $place_image->image_url ;?>" alt=""></td>
                                                <td class="py-3 valign-middle">
                                                    <div class="d-flex align-item-center flex-row gap-3">
                                                        <a href="{{route('DeleteplaceImage', [$place_image->id])}}"> <i
                                                                class="fa-solid fa-trash t-color-primary"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                
                </div>
            </div>
        </main>
    </div>
    </div>
    <script
		src="https://code.jquery.com/jquery-3.5.1.min.js"
		integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
		crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ custom_public_url('/admin-assets/css/jquery-te-1.4.0.min.js') }}" charset="utf-8"></script>
    <script>
        // jQuery(document).ready(function () {
        //     $('#test').jqte();

        // });
    </script>
@endsection
