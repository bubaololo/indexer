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
        


                    <h4 class="card-title">Google indexing API</h4>
                    <p class="card-title-desc">Сообщает google о новых\обновлённых страницах <code class="highlighter-rouge">.nav-tabs</code> class to generate a tabbed interface.</p>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
                                <i class="dripicons-home me-1 align-middle"></i> <span class="d-none d-md-inline-block">Home</span> 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab">
                                <i class="dripicons-user me-1 align-middle"></i> <span class="d-none d-md-inline-block">Инфо</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                                <i class="dripicons-mail me-1 align-middle"></i> <span class="d-none d-md-inline-block">Messages</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#settings" role="tab">
                                <i class="dripicons-gear me-1 align-middle"></i> <span class="d-none d-md-inline-block">Settings</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3">
                        <div class="tab-pane active" id="home" role="tabpanel">
                            <p class="mb-0">
                                <div class="indexer__wrapper">
                                    <a href="results.html" class="button">Посмотреть логи по предыдущему запросу</a>

                                
                                    <div class="box">
                                        <form method="POST" id="form">
                                            <!-- <form action="php/app.php" method="POST"> -->
                                            <textarea name="one" id="one" placeholder="example.com"></textarea>
                                            <div class="form__controls" id="key">
                                              <select class="key__handler" id="key" name="key">
                                                <option value="1">ключ №<b>1</b></option>
                                                <option value="2">ключ №<b>2</b></option>
                                                <option value="3">ключ №<b>3</b></option>
                                                <option value="4">ключ №<b>4</b></option>
                                                <option value="5">ключ №<b>5</b></option>
                                                <option value="6">ключ №<b>6</b></option>
                                                <option value="7">ключ №<b>7</b></option>
                                                <option value="8">ключ №<b>8</b></option>
                                                <option value="9">ключ №<b>9</b></option>
                                                <option value="10">ключ №<b>10</b></option>
                                                <option value="11">ключ №<b>11</b></option>
                                                <option value="12">ключ №<b>12</b></option>
                                                <option value="13">ключ №<b>13</b></option>
                                                <option value="14">ключ №<b>14</b></option>
                                              </select>
                                              <select class="action__handler" name="action">
                                                <option value="URL_UPDATED">Добавить в индекс</option>
                                                <option value="get">Узнать статус</option>
                                                <option value="URL_DELETED">Удалить из индекса</option>
                                              </select>
                                              
                                              <input type="submit" name="send" value="отправить" class="button">
                                
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
                                    <script src="{{ asset('js/indexer.js') }}"></script>
                                </div>
                            </p>
                        </div>
                        <div class="tab-pane" id="profile" role="tabpanel">
                            <p class="mb-0">
                                - В форму вставляем список URL, каждый URL обязательно на новой строке<br><br>
                                - 1 ключ - максимум 200 URL в день на добавление/удаление из индекса<br><br>
                                - квота на получение статуса URL - 180 запросов в минуту<br><br>
                                - не более 600 урл в минуту, тоесть заряжаем 3 ключа и ждём минуту перед следующим заходом<br><br>
                                - "добавить в индекс" - сообщает google что добавлена или обновлена страница по указанному URL и нужно её проиндексировать<br><br>
                                - "узнать статус" - отправляет запрос о статусе URL, есть он в индексе или нет, и если есть то когда в последний раз он индексировался<br><br>
                                - "удалить из индекса" - запрос на удаление страницы из индекса google<br><br>
                                - в блоке информации о ключах указывается количество запросов по ключу за последние сутки                            </p>
                        </div>
                        <div class="tab-pane" id="messages" role="tabpanel">
                            <p class="mb-0">
                                Etsy mixtape wayfarers, ethical wes anderson tofu before they
                                sold out mcsweeney's organic lomo retro fanny pack lo-fi
                                farm-to-table readymade. Messenger bag gentrify pitchfork
                                tattooed craft beer, iphone skateboard locavore carles etsy
                                salvia banksy hoodie helvetica. DIY synth PBR banksy irony.
                                Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh
                                mi whatever gluten-free.
                            </p>
                        </div>
                        <div class="tab-pane" id="settings" role="tabpanel">
                            <p class="mb-0">
                                Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                art party before they sold out master cleanse gluten-free squid
                                scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                art party locavore wolf cliche high life echo park Austin. Cred
                                vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral,
                                mustache.
                            </p>
                        </div>
                    </div>

                
            
        

@endsection
