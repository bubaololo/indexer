@extends('layouts.dashboard')
@push('styles')
    <link href="{{ asset('css/indexer.css') }}" rel="stylesheet">
@endpush

@section('page-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Индексатор</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Сервисы</a></li>
                        <li class="breadcrumb-item active">Индексатор</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif


        <h4 class="card-title">Google indexing API</h4>
        <p class="card-title-desc">Сообщает google о новых\обновлённых страницах</p>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
                    <i class="dripicons-browser-upload me-1 align-middle"></i> <span class="d-none d-md-inline-block">indexer</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#info" role="tab">
                    <i class="dripicons-information me-1 align-middle"></i> <span class="d-none d-md-inline-block">Инфо</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#keys" role="tab">
                    <i class="dripicons-card me-1 align-middle"></i> <span class="d-none d-md-inline-block">Ключи</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#settings" role="tab">
                    <i class="dripicons-gear me-1 align-middle"></i> <span class="d-none d-md-inline-block">Settings</span>
                </a>
            </li> --}}
        </ul>

        <!-- Tab panes -->
        <div class="tab-content p-3">
            <div class="tab-pane active" id="home" role="tabpanel">
                <p class="mb-0">
                <div class="indexer__wrapper">
                    <a href="results.html" class="btn btn-secondary waves-effect waves-light">Посмотреть логи по предыдущему
                        запросу</a>
                    <div class="box">
                        <form id="form" class="indexer__form">
                            {{-- <form action="/indexer" method="POST" enctype="multipart/form-data"> --}}
                            @csrf
                            <div class="custom-textarea my-3">
                                <textarea name="one" id="one" class="form-control  textarea" placeholder="example.com"
                                    data-bs-toggle="popover" data-bs-trigger="focus" title=""
                                    data-bs-content="В форму вставляем список URL, каждый URL обязательно на новой строке"
                                    data-bs-original-title="Список URL"></textarea>
                                <div class='linenumbers'></div>
                            </div>
                            <div class="form__controls" id="key">

                                <select class="form-select d-inline-block w-auto" id="key" name="key"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                    data-bs-original-title="Выберите ключ на котором есть неизрасходованные на сегодня запросы">
                                    @foreach ($keys as $keyname => $keyacc)
                                        <option title='{{ $keyacc }}' value="{{ $keyname }}">ключ
                                            <b>{{ $keyname }}</b>
                                        </option>
                                    @endforeach
                                </select>

                                <select class="form-select d-inline-block w-auto" name="action" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="" data-bs-original-title="Выберите действие">
                                    <option value="URL_UPDATED">Добавить в индекс</option>
                                    <option value="get">Узнать статус</option>
                                    <option value="URL_DELETED">Удалить из индекса</option>
                                </select>

                                <input type="submit" name="send" value="отправить"
                                    class="btn btn-primary waves-effect waves-light" data-bs-toggle="tooltip"
                                    data-bs-placement="right" title=""
                                    data-bs-original-title="Отправить запросы с указанными URL">

                            </div>

                        </form>
                        <div class="keys"></div>
                        <div class="list">
                            <table class="email">

                            </table>
                            <table class="url">

                            </table>
                        </div>

                    </div>
                </div>
                </p>
            </div>
            <div class="tab-pane" id="info" role="tabpanel">
                <p class="mb-0">
                    - В форму вставляем список URL, каждый URL обязательно на новой строке<br><br>
                    - 1 ключ - максимум 200 URL в день на добавление/удаление из индекса<br><br>
                    - квота на получение статуса URL - 180 запросов в минуту<br><br>
                    - не более 600 урл в минуту, тоесть заряжаем 3 ключа и ждём минуту перед следующим заходом<br><br>
                    - "добавить в индекс" - сообщает google что добавлена или обновлена страница по указанному URL и нужно
                    её проиндексировать<br><br>
                    - "узнать статус" - отправляет запрос о статусе URL, есть он в индексе или нет, и если есть то когда в
                    последний раз он индексировался<br><br>
                    - "удалить из индекса" - запрос на удаление страницы из индекса google<br><br>
                    - в блоке информации о ключах указывается количество запросов по ключу за последние сутки
                </p>
            </div>
            {{-- <div class="tab-pane" id="profile" role="tabpanel">
                <p class="mb-0">
                    lorem ipsum</p>
            </div> --}}
            <div class="tab-pane" id="keys" role="tabpanel">
                <p class="mb-0">
                <div class="row">

                    @foreach ($keys as $keyname => $keyacc)
                        <div class="col-sm-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Название ключа: {{ $keyname }}</h5>
                                    <p class="card-text">{{ $keyacc }}</p>
                                    @can('handle-keys')
                                        <a href="{{ route('key-page', $keyname) }}" class="btn btn-outline-info">Подробнее</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @can('handle-keys')
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">Новый ключ</h4>
                                    <p class="card-title-desc">загрузить файл API ключа</p>

                                    <form action="/keys" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <label for="formFile" class="form-label">Выберите .json файл, привязанный к google service account, 
                                            имя файла должно быть уникальным.
                                        </label>
                                        <input class="form-control" type="file" name="file" id="formFile" required>

                                        <button type="submit" class="btn mt-3 btn-primary waves-effect waves-light">
                                            Загрузить <i class="ri-arrow-right-line align-middle ms-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endcan

                </div>
                </p>
            </div>
        </div>

        @push('scripts')
            <script src="{{ asset('js/indexer.js') }}"></script>
        @endpush
    @endsection
