@extends('layout.sidenav-layout')
@section('content')
    @include('components.collection.collection-list')
    {{-- @include('components.collection.collection-delete') --}}
    @include('components.collection.collection-create')
    @include('components.collection.collection-update')
@endsection
