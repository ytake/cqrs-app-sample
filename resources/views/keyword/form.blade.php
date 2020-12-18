@extends('layouts.default')
@section('contents')
    <h1>Sample Keyword Form</h1>
    <form action="{{\route('keyword.register')}}" method="post">
        @csrf
        <div>
            <label for="word">Keyword:
                <input type="text" name="word" value="{{ old('word', '') }}" id="word"/>
            </label>
            @error('word')
            <div>{{$message}}</div>
            @enderror
        </div>
        <div>
            <button type="submit" name="submit">submit</button>
        </div>
    </form>
@endsection
