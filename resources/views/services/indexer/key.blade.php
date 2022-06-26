@extends('layouts.dashboard')


@section('page-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Информация о ключе</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Сервисы</a></li>
                      <li class="breadcrumb-item active"> <a href="{{ route('indexer') }}">Индексатор</a></li>
                        <li class="breadcrumb-item active"> Ключ </li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->




                <div class="card-header">
                    <i class="mdi mdi-file-key"></i>
                    Файл ключа: {{ $keyName }}.json
                </div>
                <div class="card-footer text-muted">
                    Файл ключа был добавлен: {{ $keyDate }}
                </div>


                <button type="button" class="btn btn-danger m-3 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal">
                    <i class="ri-close-line align-middle me-2"></i>
                    Удалить ключ
                    
                </button>
                <!-- sample modal content -->
                <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Удаление ключа</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h5 class="font-size-16">Вы уверены что хотите удалить ключ?</h5>
                                <p>Это действие нельзя будет отменить, файл ключа будет удадён</p>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Отменить</button>
                                <a href="/keys/{{ $keyName }}/delete">
                                <button type="button" class="btn btn-danger waves-effect waves-light">Да, удалить ключ</button>
                            </a>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <div class="card-body">
                    <h4 class="card-title ">Содержимое файла</h4>
                    <hr/>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Поле</th>
                        <th>Значение</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $keyContent as $name => $value)
                    
                    <tr>
                        <th scope="row">{{ $name }}</th>
                        <td>{{ $value }}</td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
                    
                </div>

        

    @endsection
