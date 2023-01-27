@extends('admin-db.layouts.main')
@section('admin-section')
<title>Tours</title>
    <div id="layoutSidenav_content">
        <main class="main_content" aria-label="content">
            <div class="container-fluid pt-2 pb-4">
                <div class="col-lg-8 col-md-7 col-sm-12">
                    <h4 class="display-6 mt-2">Tours</h4>
                </div>
                <div class=" d-flex justify-content-between">
                    <form action="{{ route('GetTours') }}" method="Post">
                        <div class="d-flex align-items-center">
                            @csrf
                            <input type="text" name="search" class="form-control" placeholder="search">
                            <button type="submit" class="btn btn-primary my-1 px-4">Search</button>
                        </div>
                    </form>
                    <a href="{{ route('CreateToursPage') }}" class="btn btn-primary my-1 px-4" style="float: right"> Add
                        Tour</a>
                </div>
                <!-- Page Title -->
                <div class="row">

                </div>
                <!-- Table -->
                @if ($errors->has('firstname'))
                    <div class="error">{{ $errors->first('firstname') }}</div>
                @endif
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="shadow rounded">
                            <div class="table-responsive">
                                <table class="table" class="mb-0" width="100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="border-bottom py-3">#</th>
                                            <th class="border-bottom py-3">Languages </th>
                                            <th class="border-bottom py-3">Title</th>
                                            <th class="border-bottom py-3">Image</th>
                                            <th class="border-bottom py-3">Duration</th>
                                            <th class="border-bottom py-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($tours as $tour)
                                            <tr>
                                                <td class="py-3">{{ $i++ }}</td>
                                                <td class="py-3"> 
                                                    @if (isset($tour->country->title ))
                                                    {{$tour->country->title }}
                                                    @endif
                                                </td>

                                                <td class="py-3">{{ $tour->title }}</td>
                                                <td class="py-3"><img
                                                        src='{{ url("public/assets/tours/$tour->id/$tour->image") }}'
                                                        height="60" width="60"></td>
                                                <td class="py-3">{{ $tour->duration }}</td>
                                                <td class="py-3 valign-middle">
                                                    <div class="d-flex align-item-center flex-row gap-3">
                                                        <a href="{{ route('EditTourPage', $tour->id) }}"><i
                                                                class="fa-solid fa-pen-to-square t-color-primary"></i></a>
                                                        <a href="{{ route('DeleteTour', $tour->id) }}"><i
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

                    <!-- Pagination -->
                    <div class="col-12 mt-4 d-flex align-item-center justify-content-end">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li>
                                    {{ $tours->links('vendor.pagination.bootstrap-4') }}
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </main>

    </div>

    </div>
@endsection
