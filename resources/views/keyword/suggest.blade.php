@extends('layouts.default')
@section('contents')
    <h1>Keyword List</h1>
    <div>
        @forelse($list as $row)
            <div>{{$row->getWord()}}:{{$row->getCount()}}</div>
        @empty
            <div>suggest none</div>
        @endforelse
        <form action="{{\route('keyword.suggest')}}" method="get">
            <div>
                <label for="word">Keyword:
                    <input type="text" name="word" value="{{ request('word', '') }}" id="word"/>
                </label>
            </div>
            <div>
                <input type="submit" value="submit">
            </div>
        </form>
    </div>
    <div>
        <a href="{{ route('home') }}">トップへ</a>
    </div>
@endsection
