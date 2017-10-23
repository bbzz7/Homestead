@extends('layouts.default')
@section('content')
    <h1>主页</h1>
@stop
@section('test')
    <p>test2</p>
@append

@section('test')
    <p>test3</p>
@append

{{--@section('test')--}}
    {{--<p>test4</p>--}}
{{--@overwrite--}}