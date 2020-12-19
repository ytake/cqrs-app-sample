@extends('layouts.default')
@section('contents')
    <h1>Keywords have been registered!</h1>
    <div>
        <a href="{{ route('keyword.form') }}">キーワード登録にもどる</a>
    </div>
    <div>
        <a href="{{ route('home') }}">トップへ</a>
    </div>
@endsection
