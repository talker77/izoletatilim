@extends('admin.layouts.master')
@section('title','Paketler')
@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Paketler
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.packages.new') }}"><i class="fa fa-plus"></i>&nbsp;Ekle</a>
                    <a href="{{ route('admin.packages.index') }}"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Paketler</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Başlık</th>
                            <th>Slug</th>
                            <th>Açıklama</th>
                            <th>Fiyat</th>
                            <th>Gün</th>
                            <th>Durum</th>
                            <th>Son Güncelleme</th>
                            <th>Oluşturma</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($packages as $package)
                            <tr>
                                <td>{{ $package->id }}</td>
                                <td>{{ $package->title }}</td>
                                <td>{{ $package->slug }}</td>
                                <td>{{ str_limit($package->description,20) }}</td>
                                <td>{{ $package->price }} ₺</td>
                                <td>{{ $package->day }}</td>
                                <td><i class="fa fa-{{ $package->status ? 'check' : 'times' }}"></i></td>
                                <td>{{ createdAt($package->updated_at) }}</td>
                                <td>{{ createdAt($package->created_at) }}</td>
                                <td><a href="{{ route('admin.packages.edit',['package' => $package->id]) }}">
                                        <i class="fa fa-edit"></i>
                                    </a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

