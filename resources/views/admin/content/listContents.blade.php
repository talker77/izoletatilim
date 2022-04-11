@extends('admin.layouts.master')
@section('title','İçerik Listesi')


@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › İçerik Yönetim
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.content.new') }}"> <i class="fa fa-plus"></i> Yeni İçerik Ekle</a>&nbsp;
                    <a href="{{ route('admin.content') }}"><i class="fa fa-refresh"></i>&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">İçerik Yönetim</h3>

                    <div class="box-tools">
                        <form action="{{ route('admin.content') }}" method="get" id="form">
                            <div class="row">
                                <div class="col-md-3 input-group input-group-sm hidden-xs  pull-right">
                                    <input type="text" name="q" class="form-control pull-right" placeholder="İçeriklerde ara.." value="{{ request('q') }}">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Başlık</th>
                            <th>Üst</th>
                            <th>Kısa Açıklama</th>
                            <th>Durum</th>
                            @if(config('admin.MULTI_LANG'))
                                <th>Dil</th>
                            @endif
                            <th>#</th>
                        </tr>
                        @if(count($list) > 0)
                            @foreach($list as $l)
                                <tr>
                                    <td>{{ $l ->id }}</td>
                                    <td><a href="{{ route('admin.content.edit',$l->id) }}"> {{ $l->title }}</a></td>
                                    <td>
                                        @if(!is_null($l->parent))
                                            <a target="_blank" href="{{ route('admin.content.edit',$l->parent) }}">{{ $l->parentContent->title }} <i class="fa fa-external-link"></i></a>
                                        @endif
                                    </td>
                                    <td>{{ substr($l->spot,0,170)}}</td>
                                    <td><i class="fa fa-{{ $l -> active == false ? 'times text-red' : 'check text-green' }}"></i></td>
                                    @if(config('admin.MULTI_LANG'))
                                        <th><img src="{{ langIcon($l->lang) }}" alt=""></th>
                                    @endif
                                    <td><a href="{{ route('admin.content.delete',$l->id) }}" onclick="return confirm('Silmek istediğine emin misin ?')"><i
                                                class="fa fa-trash text-red"></i></a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center"><h5>İçerik Bulunamadı</h5></td>
                            </tr>
                        @endif

                        </tbody>

                    </table>
                    <div class="text-right"> {{ $list->appends(['q' => request('q')])->links() }}</div>
                </div>

                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
    </div>
@endsection
