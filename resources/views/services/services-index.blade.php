@extends('layouts.dashboard')

@section('page-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Все сервисы</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Сервисы</a></li>
                        <!-- <li class="breadcrumb-item active">Индексатор</li> -->
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="col-md-6 col-xl-3">
    <div class="card">
        <img class="card-img-top img-fluid"
            src="https://developers.google.com/search/images/googlebot_and_spider_header.png?hl=ru" alt="Card image cap">
        <div class="card-body">
            <h4 class="card-title ">Индексация</h4>
            <p class="card-text">Быстрая индексация страниц через google indexing API</p>
            <a href="{{ route('indexer') }}" class="btn btn-primary waves-effect waves-light">перейти</a>
        </div>
    </div>
</div>
@endsection
