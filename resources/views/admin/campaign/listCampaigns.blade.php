@extends('admin.layouts.master')
@section('title','Kampanya Listesi')


@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Kampanyalar
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.campaigns.new') }}"> <i class="fa fa-plus"></i> Yeni Kampanya Ekle</a>&nbsp;
                    <a href="{{ route('admin.campaigns') }}"><i class="fa fa-refresh"></i>&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Kampanyalar</h3>

                    <div class="box-tools">
                        <form action="{{ route('admin.campaigns') }}" method="get" id="form">
                            <div class="row">
                                <div class="col-md-3 input-group input-group-sm hidden-xs  pull-right">
                                    <input type="text" name="q" class="form-control pull-right" placeholder="Kampanyalarda ara.." value="{{ request('q') }}">

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
                            <th>İndirim Tipi</th>
                            <th>İndirim Tutarı</th>
                            <th>Başlangıç</th>
                            <th>Bitiş</th>
                            <th>Fotoğraf</th>
                            <th>Durum</th>
                            <th>#</th>
                        </tr>
                        @if(count($list) > 0)
                            @foreach($list as $l)
                                <tr>
                                    <td>{{ $l ->id }}</td>
                                    <td><a href="{{ route('admin.campaigns.edit',$l->id) }}"> {{ $l->title }}</a></td>
                                    <td>{{ $l -> statusLabel()}}</td>
                                    <td>{{ $l -> discount_amount}}</td>
                                    <td>{{ $l -> start_date}}</td>
                                    <td>{{ $l -> end_date}}</td>
                                    <td><a href="{{ imageUrl('public/kampanyalar',$l->image) }}"><i class="fa fa-image"></i></a></td>
                                    <td><i class="fa fa-{{ $l -> active == false ? 'times text-red' : 'check text-green' }}"></i></td>
                                    <td><a href="{{ route('admin.campaigns.delete',$l->id) }}" onclick="return confirm('Silmek istediğine emin misin ?')"><i
                                                class="fa fa-trash text-red"></i></a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center"><h5>Kampanya Bulunamadı</h5></td>
                            </tr>
                        @endif

                        </tbody>

                    </table>
                    <div class="text-right"> {{ $list->appends(['q' => request('q'),'parent_category'=> request('parent_category')])->links() }}</div>
                </div>

                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
    </div>
@endsection
