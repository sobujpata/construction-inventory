@extends('layout.sidenav-layout')
@section('content')
    @include('components.store.product-list')
    @include('components.product.buy-product-delete')
    @include('components.store.store-create')
    @include('components.store.store-update')
@endsection
