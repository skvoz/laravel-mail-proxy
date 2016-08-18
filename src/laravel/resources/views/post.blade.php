@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Emails list
                </div>

                <div class="panel-body">
                    @foreach ($items as $item)
                        <div class="item">
                            <h2>{{$item->getSubject()}}</h2>
                            <i>{{$item->getTo()}}</i>
                            <p>{{$item->getBody()}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection