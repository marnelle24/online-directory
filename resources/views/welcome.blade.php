@extends('layouts.app')

@section('content')
    <homepage user='{{ Auth::user() }}'></homepage>
@endsection