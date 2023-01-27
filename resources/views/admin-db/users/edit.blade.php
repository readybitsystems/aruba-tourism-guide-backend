@extends('admin-db.layouts.main')
@section('admin-section')
<title>Edit User</title>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="row ">


                    {{-- <h1 class="mt-4">Edit User</h1> --}}

                    <div class="row mt-5">
                        <div class="col col-xs-12">
                            <h4 class="display-6 text-center">
                                Edit User
                            </h4>
                        </div>
                    </div>
                    <div class="col-3">
                    </div>
                    <div class="card-body col-6">
                        <form action="{{ route('UpdateUser', $user) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex flex-column gap-1 column-gap-2">
                                <label class="labels" for="first_name">Name</label>
                                <input type="text" class="form-control" placeholder="John" id="name"
                                    name="user_name" class="form-control" value="{{ $user->user_name }}">
                            </div>
                            @if ($errors->has('user_name'))
                                <div class="error" style="color: red">{{ $errors->first('user_name') }}</div>
                            @endif
                            <div class="d-flex flex-column gap-1 column-gap-2">
                                <label class="labels" for="email">Email address</label>
                                <input type="text" class="form-control" placeholder="john@gmail.com" id="first_name"
                                    name="email" class="form-control" value="{{ $user->email }}">
                            </div>
                            @if ($errors->has('user_name'))
                                <div class="error" style="color: red">{{ $errors->first('user_name') }}</div>
                            @endif
                            <div class="d-flex flex-column gap-1 column-gap-2">
                                <label class="labels" for="password">pasword</label>
                                <input type="password" class="form-control" placeholder="password" id="first_name"
                                    name="password" value="{{ $user->password }}">
                            </div>
                            @if ($errors->has('password'))
                                <div class="error" style="color: red">{{ $errors->first('password') }}</div>
                            @endif
                            <div class="d-flex flex-column gap-1 column-gap-2">
                                <label class="labels" for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" placeholder="password" id="first_name"
                                    name="confirm_password" value="{{ $user->password }}">
                            </div>
                            @if ($errors->has('confirm_password'))
                                <div class="error" style="color: red">{{ $errors->first('confirm_password') }}</div>
                            @endif
                            <div class="d-flex flex-column gap-1 column-gap-2">
                                <label class="labels" for="phone">Phone Number</label>
                                <input type="text" class="form-control" placeholder="466-565-656-456" id="first_name"
                                    name="phone" value="{{ $user->phone }}">
                            </div>
                            @if ($errors->has('phone'))
                                <div class="error" style="color: red">{{ $errors->first('phone') }}</div>
                            @endif
                            <div class="row d-flex align-item-center flex-column gap-3">
                                <div class="d-flex align-item-center justify-content-between gap-3 mt-3">
                                    <button class="btn btn-primary profile-button w-50" type="submit">
                                        Update User
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
