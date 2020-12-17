@extends('layout.app')

@section('content')
    <floor-plans :user-auth="{{ Auth::user() }}"></floor-plans>
@endsection