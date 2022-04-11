@extends('admin.layouts.master')
@section('title','Admin Anasayfa')
@section('link1','products')
@section('link1_title','Ürünler')
@section('link2_title','Ürün adı')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Admin
            <small>Kontrol Paneli</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('homeView') }}"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li class="active">Kontrol Paneli</li>
        </ol>
    </section>
@endsection

