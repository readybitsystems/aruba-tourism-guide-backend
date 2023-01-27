@extends('admin-db.layouts.main')
@section('admin-section')
<title>Admin Profile</title>
    <!-- CONTENT -->
    <main class="main_content" aria-label="content">
        <div class="container-fluid pt-2 pb-4">
            <div class="row mt-2 justify-content-center">
                <div style="max-width: 500px;">
                    <!-- Page Title -->
                    <div class="row mt-2">
                        <div class="col col-xs-12">
                            <h4 class="display-6 text-center">
                               Edit Profile
                            </h4>
                        </div>
                    </div>
                    <!-- Add Form -->
                    <form action="{{route('updateAdminProfile')}}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="d-flex flex-column gap-1 column-gap-2">
                                <label class="labels" for="first_name">Name</label>
                                <input type="text" class="form-control" placeholder="John"  name="user_name"
                                      value="{{$user->user_name}}">
                            </div>
                            <div class="d-flex flex-column gap-1 column-gap-2">
                                <label class="labels" for="first_name">Phone</label>
                                <input type="text" class="form-control"   name="phone"  value="{{$user->phone}}">
                            </div>
                            <div class="d-flex flex-column gap-1 column-gap-2">
                                <label class="labels" for="first_name">Password</label>
                                <input type="text" class="form-control"  id="first_name" name="pasword" >
                            </div>
                            <div class="d-flex flex-column gap-1 mt-4 mt-md-0">
                                <label class="labels" for="last_name">Profile Image</label>
                                <input type="file" class="form-control" accept="image/*" name="user_profile" >
                            </div>
                        <div class="row d-flex align-item-center flex-column gap-3">
                            <div class="d-flex align-item-center justify-content-between gap-3 mt-3">
                                <button class="btn btn-primary profile-button w-50" type="submit">
                                  Edit Profile
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
