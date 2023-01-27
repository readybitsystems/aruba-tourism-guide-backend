<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{url('public/admin-assets/images/brand-logo.png')}}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ custom_public_url('admin-assets/css/bootstrap.min.css" rel="stylesheet') }}" />
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ custom_public_url('public/admin-assets/favicons/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ custom_public_url('admin-assets/favicons/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ url('admin-assets/favicons/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href="{{ custom_public_url('admin-assets/css/bootstrap.min.css" rel="stylesheet') }}" />
    <link href="{{ custom_public_url('admin-assets/css/styles.css" rel="stylesheet') }}" />
</head>
<body>

    <div class="main_layout">
      @if (isset(request()->user))
        <!-- BACKGROUND OVERLAY -->
        <button type="button" class="border-0 bg_overlay_28"></button>
        <!-- DRAWER NAV BAR -->

      <aside class="primary_navigation" id="drawer"> 
      <button class="bg-transparent border-0 position-absolute d-lg-none" style="right: 10px; top: 0px"
        aria-label="close-menu-btn" id="close-menu">
        <i class="fa fa-times"></i>
      </button>
      <div class="brand_p0 border-bottom d-flex align-items-center justify-content-center" aria-label="site-brand">
        <div class="text-center w-100">
          <a href="{{route('Dashboard')}}"><img src="{{url('public/admin-assets/images/brand-logo.png')}}" width="45px" class="img-fluid" /> </a>
          
          <h6 class="brand_title">{{ucfirst(request()->user->user_name)}}</h6>
        </div>
      </div>
      <nav class="position-relative" aria-label="navigation">
        <ul class="px-0 py-5 m-0 list-unstyled ">
        
          <li class= " nav_item mb-2 py-2 me-2 rounded-end @if (\Request::route()->getName() == 'Dashboard') active @endif " >
            
            <a  class=" nav_link text-decoration-none d-flex align-items-center active"
            
             href="{{route('Dashboard')}}" >
              <span class="icon_wrapper mx-3 rounded-circle d-flex align-items-center justify-content-center ">


                <i class="fa fa-comments t-color-primary"></i>
              </span>
              <h6 class="link_txt m-0 ">Dashboard</h6>
            </a>
          </li>
          <li class="nav_item mb-2 py-2 me-2 rounded-end @if (\Request::route()->getName() == 'GetUsers') active @endif ">
            <a href="{{ route('GetUsers') }}" class="nav_link text-decoration-none d-flex align-items-center">
              <span class="icon_wrapper mx-3 rounded-circle d-flex align-items-center justify-content-center">
                <i class="fa fa-comments t-color-primary " ></i>
              </span>
              <h6 class="link_txt m-0">Users </h6>
            </a>
          </li>
          <li class="nav_item mb-2 py-2 me-2 rounded-end  @if (\Request::route()->getName() == 'getlanguagesall ') active @endif ">
            <a href="{{route('getlanguagesall')}}" class="nav_link text-decoration-none d-flex align-items-center">
              <span class="icon_wrapper mx-3 rounded-circle d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-file-lines text-warning"></i>
              </span>
              <h6 class="link_txt m-0">Languages</h6>
            </a>
          </li>
          <li class="nav_item mb-2 py-2 me-2 rounded-end @if (\Request::route()->getName() == 'GetTours') active @endif">
            <a href="{{route('GetTours')}}" class="nav_link text-decoration-none d-flex align-items-center   ">
              <span class="icon_wrapper mx-3 rounded-circle d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-users t-color-primary"></i>
              </span>
              <h6 class="link_txt m-0">Tours</h6>
            </a>
          </li>
          <li class="nav_item mb-2 py-2 me-2 rounded-end @if (\Request::route()->getName() == 'GetPlaces') active @endif ">
            <a href="{{route('GetPlaces')}}" class="nav_link text-decoration-none d-flex align-items-center ">
              <span class="icon_wrapper mx-3 rounded-circle d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-file-lines t-color-primary"></i>
              </span>
              <h6 class="link_txt m-0">Places</h6>
            </a>
          </li>
          <li class="nav_item mb-2 py-2 me-2 rounded-end @if (\Request::route()->getName() == 'EditProfile') active @endif">
            <a href="{{route('EditProfile')}}" class="nav_link text-decoration-none d-flex align-items-center   ">
              <span class="icon_wrapper mx-3 rounded-circle d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-users t-color-primary"></i>
              </span>
              <h6 class="link_txt m-0">Profile</h6>
            </a>
          </li>
          <li class="nav_item mb-2 py-2 me-2 rounded-end">
            <a href="{{route('Logout')}}" class="nav_link text-decoration-none d-flex align-items-center">
              <span class="icon_wrapper mx-3 rounded-circle d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-user t-color-primary"></i>
              </span>
              <h6 class="link_txt m-0">Logout</h6>
            </a>
          </li>
          
        </ul>
      </nav>

    </aside>
        <!-- DRAWER END -->

        <!-- PAGE -->
        <!-- HEADER top -->
        
        
        <div class="primary_container" aria-label="page"> 
         <header class="header_s0 px-2 p-3">
        <div class="row">
          <div class="col-1 align-self-center me-2">
            <button class="btn focus_none d-lg-none px-1 py-1" id="open-menu" aria-label="open-menu-btn">
              <i class="fa fa-bars text-dark fs-5"></i>
            </button>
          </div>
          <div class="col">
            <ul class="p-0 m-0 ms-auto list-unstyled d-flex align-items-center justify-content-end">
              <li>
                <div style="width:36px;height:36px;border-radius: 100%; overflow:hidden">
                  <img src="
                  <?php if (request()->user->user_profile) echo request()->user->profile_image; else echo url('public/admin-assets/images/dp.png'); 
                  ?>" alt="" width="100%" height="100%">
                </div>
              </li>
              <li>
                <a href="#">
                  <img src="../../assets/images/dp.png" alt="" width="35px" class="img-fluid" />
                </a>
              </li>
            </ul>
          </div>
        </div>
        @endif   
      </header>