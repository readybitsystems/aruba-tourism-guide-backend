@extends('admin-db.layouts.main')
@section('admin-section')
    <title>Dashboard</title>
    <div class="main_layout">
        <title>Dashboard</title>
        <!-- BACKGROUND OVERLAY -->
        <!-- PAGE -->
        <div class="primary_container" aria-label="page">
            <!-- HEADER END -->
            <!-- CONTENT -->
            <main class="main_content" aria-label="content">
                <div class="container-fluid pt-2 pb-4">
                    <!-- Page Title -->
                    <div class="row mt-3">
                        <div class="col-lg-8 col-md-7 col-sm-12">
                            <h4 class="display-6">
                            <?php
                                // I'm america/aruba so my timezone is America/Aruba
                                date_default_timezone_set('America/Aruba');
                                // 24-hour format of an hour without leading zeros (0 through 23)
                                $Hour = date('G');
                                $admin_name = ucfirst(request()->user->user_name);

                                if ($Hour >= 6 && $Hour <= 11) {
                                    echo '<span class="text-muted">Good Morning, </span>'.$admin_name ;
                                } elseif ($Hour > 11 && $Hour <= 18) {
                                    echo '<span class="text-muted">Good Afternoon, </span> '.$admin_name;
                                } elseif ($Hour > 18 || $Hour <= 6) {
                                    echo '<span class="text-muted">Good Night, </span> '.$admin_name;
                                }
                            ?>
                            </h4>
                        </div>
                    </div>
                    <!-- Dashboard Cards -->
                    <div class="row p-2 mt-2 rounded row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 gy-3">
                        <div class="col">
                            <div class="card text-start rounded shadow-sm bg-light h-100" style="border: none;">
                                <div class="card-body d-flex gap-3 flex-column">
                                    <h2 class="card-title">{{ $users }}</h2>
                                    <p class="card-text">Numbers of users</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-start rounded shadow-sm bg-light h-100" style="border: none;">
                                <div class="card-body d-flex gap-3 flex-column">
                                    <h2 class="card-title">{{ $languages }}</h2>
                                    <p class="card-text">Numbers of languages</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-start rounded shadow-sm bg-light h-100" style="border: none;">
                                <div class="card-body d-flex gap-3 flex-column">
                                    <h2 class="card-title">{{ $tours }}</h2>
                                    <p class="card-text">Numbers of tours</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-start rounded shadow-sm bg-light h-100" style="border: none;">
                                <div class="card-body d-flex gap-3 flex-column">
                                    <h2 class="card-title">{{ $places }}</h2>
                                    <p class="card-text">Numbers of places</p>
                                </div>
                            </div>
                        </div>
                    </div>
            </main>
        </div>
        </main>
        <!-- CONTENT END -->
    </div>
    </div>
@endsection
