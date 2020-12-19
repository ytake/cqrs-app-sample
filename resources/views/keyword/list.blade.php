@extends('layouts.default')
@section('contents')
    <h1>Keyword List</h1>
    <div>
        @foreach($list as $row)
            <div>{{$row->getWord()}}:{{$row->getCount()}}</div>
        @endforeach
    </div>
    <div>
        <a href="{{ route('home') }}">トップへ</a>
    </div>
@endsection
