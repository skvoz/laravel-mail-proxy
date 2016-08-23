@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-12">
            <a href="/">home</a>
            >>
            <a>{{$email->getSubject()}}</a>
        </div>
    </div>

    <div class="container">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Subject:{{$email->getSubject()}}
                </div>
                <div class="panel-body">
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-12">
                                from: {{$email->getUser()->getEmail()}} <br/>
                                to: {{$email->getTarget()}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                {{$email->getBody()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection