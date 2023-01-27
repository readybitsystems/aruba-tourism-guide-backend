@extends('admin-db.layouts.main')
@section('admin-section')
<title>Login</title>
    <div class="login">
        
        <div class="card shadow">
            <div class="card-title text-center border-bottom">
                <img src="./assets/images/brand-logo.png" width="110px" height="auto" alt="" class="mt-3">
                <h1 class="p-3">Login</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('LoginUser') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="username" class="form-label">Email</label>
                        <input type="email" class="form-control" id="username" required placeholder="name@example.com" name="email" value="{{ old('email') }}" />
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" required placeholder="Password" name="password" value="{{ old('password') }}" />
                    </div>
                    <div class="mb-2 d-flex justify-content-between align-item-center">
                        <div>
                            <input type="checkbox" class="form-check-input" id="remember" />
                            <label for="remember" class="form-label">Remember Me</label>
                        </div>
                        <div class="text-end">
                            <a href="#" class="text-decoration-none">
                                <span class="text-danger" style="font-size: 14px;">Forget password?</span>
                            </a>
                        </div>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn text-light main-bg rounded-3 py-3"
                            onclick="location.href='./index.html'">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

