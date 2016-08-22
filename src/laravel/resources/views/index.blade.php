@extends('layouts.app')

@section('content')
{{--    {{$request->session()->get('status')}}--}}
    <div class="container">
        <div class="col-sm-12">
            <div class="panel panel-default">
                @if ($error = $request->session()->get('error'))
                    <div class="alert alert-danger}}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{$error}}
                    </div>
                @endif

                @if ($status = $request->session()->get('status'))
                    <div class="alert alert-success}}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{$status}}
                    </div>
                @endif

                <div class="panel-heading">
                    Emails list
                </div>

                <div class="panel-body">
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-2"><h2><u>from</u></h2></div>
                            <div class="col-sm-2"><h2><u>to</u></h2></div>
                            <div class="col-sm-2"><h2><u>subject</u></h2></div>
                            <div class="col-sm-2"><h2><u>action</u></h2></div>
                        </div>
                        @foreach ($items as $item)

                            <div class="row">
{{--                                <div class="col-sm-2">{{$item->user->getEmail()}}</div>--}}
                                <div class="col-sm-2">{{'here must be user name and email'}}</div>
                                <div class="col-sm-2">{{$item->getTarget()}}</div>
                                <div class="col-sm-2">{{$item->getSubject()}}</div>
                                <div class="col-sm-2">
                                    <a href="/delete/{{$item->getId()}}">delete</a>
                                    <a href="/view/{{$item->getId()}}">view</a>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection