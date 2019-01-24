@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
            <div id="app" class="container">
                <div class="title m-b-md">
                    <category></category>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
