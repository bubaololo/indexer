@extends('layouts.dashboard')

@section('page-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Главное меню</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Главная</a></li>
                        <li class="breadcrumb-item active">Стартовая страница</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="col-lg-4">
                                <div class="card">
                                    <h4 class="card-header ">Сервисы</h4>
                                    <div class="card-body">
                                        <h4 class="card-title ">список всех сервисов</h4>
                                        <p class="card-text">каталог и краткое описание всех сервисов доступных в системе</p>
                                        <a href="{{ route('services-index') }}" class="btn btn-primary">перейти</a>
                                    </div>
                                </div>
                            </div>
@endsection
