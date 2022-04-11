@extends('site.layouts.base')
@section('header')
    <title>Mesajlar</title>
    {{--    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
    {{--    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>--}}
    {{--    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>--}}
    <!------ Include the above in your HEAD tag ---------->

    <script src="https://use.fontawesome.com/45e03a14ce.js"></script>
    <style>
        #custom-search-input {
            background: #e8e6e7 none repeat scroll 0 0;
            margin: 0;
            padding: 10px;
        }

        #custom-search-input .search-query {
            background: #fff none repeat scroll 0 0 !important;
            border-radius: 4px;
            height: 33px;
            margin-bottom: 0;
            padding-left: 7px;
            padding-right: 7px;
        }

        #custom-search-input button {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: 0 none;
            border-radius: 3px;
            color: #666666;
            left: auto;
            margin-bottom: 0;
            margin-top: 7px;
            padding: 2px 5px;
            position: absolute;
            right: 0;
            z-index: 9999;
        }

        .search-query:focus + button {
            z-index: 3;
        }

        .all_conversation button {
            background: #f5f3f3 none repeat scroll 0 0;
            border: 1px solid #dddddd;
            height: 38px;
            text-align: left;
            width: 100%;
        }

        .all_conversation i {
            background: #e9e7e8 none repeat scroll 0 0;
            border-radius: 100px;
            color: #636363;
            font-size: 17px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            width: 30px;
        }

        .all_conversation .caret {
            bottom: 0;
            margin: auto;
            position: absolute;
            right: 15px;
            top: 0;
        }

        .all_conversation .dropdown-menu {
            background: #f5f3f3 none repeat scroll 0 0;
            border-radius: 0;
            margin-top: 0;
            padding: 0;
            width: 100%;
        }

        .all_conversation ul li {
            border-bottom: 1px solid #dddddd;
            line-height: normal;
            width: 100%;
        }

        .all_conversation ul li a:hover {
            background: #dddddd none repeat scroll 0 0;
            color: #333;
        }

        .all_conversation ul li a {
            color: #333;
            line-height: 30px;
            padding: 3px 20px;
        }

        .member_list .chat-body {
            margin-left: 47px;
            margin-top: 0;
        }

        .top_nav {
            overflow: visible;
        }

        .member_list .contact_sec {
            margin-top: 3px;
        }

        .member_list li {
            padding: 6px;
        }

        .member_list ul {
            border: 1px solid #dddddd;
        }

        .chat-img img {
            height: 34px;
            width: 34px;
        }

        .member_list li {
            border-bottom: 1px solid #dddddd;
            padding: 6px;
        }

        .member_list li:last-child {
            border-bottom: none;
        }

        .member_list {
            height: 380px;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sub_menu_ {
            background: #e8e6e7 none repeat scroll 0 0;
            left: 100%;
            max-width: 233px;
            position: absolute;
            width: 100%;
        }

        .sub_menu_ {
            background: #f5f3f3 none repeat scroll 0 0;
            border: 1px solid rgba(0, 0, 0, 0.15);
            display: none;
            left: 100%;
            margin-left: 0;
            max-width: 233px;
            position: absolute;
            top: 0;
            width: 100%;
        }

        .all_conversation ul li:hover .sub_menu_ {
            display: block;
        }

        .new_message_head button {
            background: #2d3e52 none repeat scroll 0 0;
            border: medium none;
        }

        .new_message_head {
            background: #2d3e52 none repeat scroll 0 0;
            float: left;
            font-size: 13px;
            font-weight: 600;
            padding: 18px 10px;
            width: 100%;
        }

        .message_section {
            border: 1px solid #dddddd;
        }

        .chat_area {
            float: left;
            height: 600px;
            overflow-x: hidden;
            overflow-y: auto;
            width: 100%;
        }

        .chat_area li {
            padding: 14px 14px 0;
        }

        .chat_area li .chat-img1 img {
            height: 40px;
            width: 40px;
        }

        .chat_area .chat-body1 {
            margin-left: 50px;
        }

        .chat-body1 p {
            background: #fbf9fa none repeat scroll 0 0;
            padding: 10px;
        }

        .chat_area .admin_chat .chat-body1 {
            margin-left: 0;
            margin-right: 50px;
        }

        .chat_area li:last-child {
            padding-bottom: 10px;
        }

        .message_write {
            background: #f5f3f3 none repeat scroll 0 0;
            float: left;
            padding: 15px;
            width: 100%;
        }

        .message_write textarea.form-control {
            height: 70px;
            padding: 10px;
        }

        .chat_bottom {
            float: left;
            margin-top: 13px;
            width: 100%;
        }

        .upload_btn {
            color: #777777;
        }

        .sub_menu_ > li a, .sub_menu_ > li {
            float: left;
            width: 100%;
        }

        .member_list li:hover {
            background: #428bca none repeat scroll 0 0;
            color: #fff;
            cursor: pointer;
        }

        .admin-chat-box {
            background-color: #e8f9ff !important;
        }

        .active {
            background-color: #07b7f2;
            color: white;
        }
    </style>
@endsection
@section('content')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">@lang('panel.navbar.messages')</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="/">Anasayfa</a></li>
                <li class="">@lang('panel.navbar.messages')</li>
                @include('site.kullanici.partials.addNewServiceButton')
            </ul>
        </div>
    </div>
    <section id="content" class="gray-area">
        <div class="container">
            <div id="main">
                @include('site.layouts.partials.messages')
                <div class="tab-container full-width-style arrow-left dashboard">
                    @include('site.kullanici.partials.myAccountLeftSidebar')
                    <div class="tab-content">
                        <div id="main" class="col-sms-6 col-sm-8 col-md-12">
                            <div class="main_section">
                                <div class="">
                                    <div class="chat_container">
                                        <div class="col-sm-3 chat_sidebar">
                                            <div class="row">
                                                <div id="custom-search-input">
                                                    <div class="input-group col-md-12">
                                                        <span>Mesajlar</span>
                                                    </div>
                                                </div>
                                                <div class="member_list">
                                                    <ul class="list-unstyled">
                                                        @foreach($list as $l)
                                                            @php
                                                              $lObject = (new \App\Models\Message((array)$l));
                                                              $sender = $lObject->sender();
                                                            @endphp
                                                            <li class="left clearfix {{ $lObject->sender()->id == request('from') ? 'active' : '' }}">
                                                                <a href="{{ route('user.chat.index',['from' =>$sender->id]) }}">
                                                                     <span class="chat-img pull-left">
                                                                         <img src="/site/images/img_1.png"
                                                                              alt="{{ $sender->full_name }}"
                                                                              class="img-circle">
                                                                     </span>
                                                                    <div class="chat-body clearfix">
                                                                        <div class="header_sec">
                                                                            <strong class="primary-font"
                                                                                    title="{{ $sender->full_name }}">{{ str_limit($sender->full_name,10) }}</strong>
                                                                            <strong
                                                                                class="pull-right">{{ $lObject->created_at->diffForHumans() }}</strong>
                                                                        </div>
                                                                        <div class="contact_sec">
                                                                            <strong
                                                                                class="primary-font">{{ str_limit($l->message,16) }}</strong>
                                                                            <span
                                                                                class="badge pull-right">{{ $lObject->unReadCount($sender,$lObject->receiver()) }}</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!--chat_sidebar-->


                                        <div class="col-sm-9 message_section">
                                            <div class="row">
                                                @if(count($activeMessages))
                                                    <div class="new_message_head">
                                                        <div class="pull-left">
                                                            <button>
                                                                {{ $activeMessages[0]->sender()->full_name }}
                                                            </button>
                                                        </div>
                                                        <div class="pull-right">
                                                            <div>
                                                                @if($service)
                                                                    <a target="_blank" style="color: white" href="{{ route('services.detail',['slug' => $service->slug]) }}">
                                                                        <i class="fa fa-external-link"></i> &nbsp; {{ $service->title }}
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div><!--new_message_head-->

                                                    <div class="chat_area" id="chat_area">
                                                        <ul class="list-unstyled">
                                                            @foreach($activeMessages as $message)
                                                                @if($message->from_id == $loggedUser->id)
                                                                    <li class="left clearfix admin_chat">
                                                                     <span class="chat-img1 pull-right">
                                                                     <img src="/site/images/user.png" alt="User Avatar"
                                                                          class="img-circle">
                                                                     </span>
                                                                        <div class="chat-body1 clearfix">
                                                                            <p class="admin-chat-box">{{ $message->message }}</p>
                                                                            <div
                                                                                class="chat_time pull-right">{{ $message->created_at }}</div>
                                                                        </div>
                                                                    </li>
                                                                @else
                                                                    <li class="left clearfix">
                                                                 <span class="chat-img1 pull-left">
                                                                 <img src="/site/images/user.png"
                                                                      title="{{ $message->sender()->full_name }}"
                                                                      class="img-circle">
                                                                 </span>
                                                                        <div class="chat-body1 clearfix">
                                                                            <p> {{ $message->message }}</p>
                                                                            <div
                                                                                class="chat_time pull-right">{{ $message->created_at }}</div>
                                                                        </div>
                                                                    </li>
                                                                @endif

                                                            @endforeach
                                                        </ul>
                                                    </div><!--chat_area-->
                                                    <div class="message_write">
                                                        <form action="{{ route('user.chat.create') }}" method="POST">
                                                            <input type="hidden" name="related_id" value="{{ request()->get('service') }}">
                                                            @csrf
                                                            <input type="hidden" name="to_id" value="{{ $activeMessages[0]->sender()->id  }}">
                                                            <textarea class="form-control" name="message"
                                                                      placeholder="bir mesaj yaz"></textarea>
                                                            <div class="clearfix"></div>
                                                            <div class="chat_bottom">
                                                                <button class="pull-right btn btn-success">
                                                                    Gönder
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                @else
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                           <center> <h4>Herhangi bir mesaj yok</h4></center>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div> <!--message_section-->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script>
        $(".chat_area").animate({scrollTop: document.getElementById('chat_area').scrollHeight}, "slow");
        $(".member_list .badge").each(function (index, element) {
            console.log($(element).text())
            const text = $(element).text()
            if (text == 0) {
                $(element).remove()
            }
        })
    </script>
@endsection
