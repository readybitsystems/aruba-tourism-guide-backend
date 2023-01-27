@extends('admin-db.layouts.main')
@section('admin-section')
<title>Create User</title>
    <!-- CONTENT -->
    <main class="main_content" aria-label="content">
        <div class="container-fluid pt-2 pb-4">
            <div class="row mt-2 justify-content-center">
                <div style="max-width: 500px;">
                    <!-- Page Title -->
                    <div class="row mt-2">
                        <div class="col col-xs-12">
                            <h4 class="display-6 text-center">
                                Add New User
                            </h4>
                        </div>
                    </div>

                    <!-- Add Form -->
                    <form action="{{ route('AddUser') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex flex-column gap-1 column-gap-2">
                            <label class="labels" for="first_name">Name</label>
                            <input type="text" class="form-control" placeholder="John" id="name" name="user_name"
                                class="form-control" value="{{ old('user_name') }}">
                        </div>
                        @if ($errors->has('user_name'))
                            <div class="error" style="color: red">{{ $errors->first('user_name') }}</div>
                        @endif
                        <div class="d-flex flex-column gap-1 column-gap-2">
                            <label class="labels" for="email">Email address</label>
                            <input type="text" class="form-control" placeholder="john@gmail.com" id="first_name"
                                name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        @if ($errors->has('email'))
                            <div class="error" style="color: red">{{ $errors->first('email') }}</div>
                        @endif
                        <div class="d-flex flex-column gap-1 column-gap-2">
                            <label class="labels" for="password">pasword</label>
                            <input type="password" class="form-control" placeholder="password" id="first_name"
                                name="password" class="form-control" value="{{ old('password') }}">
                        </div>
                        @if ($errors->has('password'))
                            <div class="error" style="color: red">{{ $errors->first('password') }}</div>
                        @endif
                        <div class="d-flex flex-column gap-1 column-gap-2">
                            <label class="labels" for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" placeholder="password" id="first_name"
                                name="confirm_password" class="form-control" value="{{ old('confirm_password') }}">
                        </div>
                        @if ($errors->has('confirm_password'))
                            <div class="error" style="color: red">{{ $errors->first('confirm_password') }}</div>
                        @endif
                        <div class="d-flex flex-column gap-1 column-gap-2">
                            <label class="labels" for="phone">Phone Number</label>
                            <input type="text" class="form-control" placeholder="466-565-656-456" id="first_name"
                                name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        @if ($errors->has('phone'))
                            <div class="error" style="color: red">{{ $errors->first('phone') }}</div>
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
