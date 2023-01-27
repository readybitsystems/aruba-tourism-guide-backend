@extends('admin-db.layouts.main')
@section('admin-section')
<title>Users</title>
    <div id="layoutSidenav_content">
        <main class="main_content" aria-label="content">
            <div class="container-fluid pt-2 pb-4">
                <div class="col-lg-8 col-md-7 col-sm-12">
                    <h4 class="display-6 mt-2">Users</h4>
                </div>
                <div class=" d-flex justify-content-between">
                    <form action="{{ route('GetUsers') }}" method="post">
                        <div class="d-flex align-items-center">
                            @csrf
                            <input type="text" name="search" class="form-control" placeholder="search">
                            <button type="submit" class="btn btn-primary my-1 px-4">Search</button>
                        </div>
                    </form>
                    <a href="{{ route('CreateUser') }}" class="btn btn-primary my-1 px-4" style="float: right"> Add User</a>
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
                                            <th class="border-bottom py-3">Name</th>
                                            <th class="border-bottom py-3">Email</th>
                                            <th class="border-bottom py-3">Phone number</th>
                                            <th class="border-bottom py-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td class="py-3">{{$key+1}}</td>
                                                <td class="py-3">{{ $user->user_name }}</td>
                                                <td class="py-3">{{ $user->email }}</td>
                                                <td class="py-3">@if($user->phone) {{$user->phone}} @else - @endif</td>
                                                <td class="py-3 valign-middle">
                                                    <div class="d-flex align-item-center flex-row gap-3">
                                                        <a href="{{ route('EditUserPage', $user->id) }}"> <i
                                                                class="fa-solid fa-pen-to-square t-color-primary"></i></a>
                                                        <a href="{{ route('Userdestroy', $user->id) }}"> <i
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
                                    {{ $users->links('vendor.pagination.bootstrap-4') }}
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
