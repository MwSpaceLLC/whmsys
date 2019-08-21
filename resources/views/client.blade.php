@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <ul class="side-menu">
                    <li><a href="/home">@lang('dashboard')</a></li>
                    <li class="active"><a href="/clients">@lang('clients')</a></li>
                    <li><a href="/invoices">@lang('invoices')</a></li>
                    <li><a href="/settings">@lang('settings')</a></li>
                </ul>
            </div>

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header seen">{{$client->firstname}} {{$client->lastname}} | {{$client->companyname}}

                        <a href="/client/{{$client->id}}/invoices" class="btn btn-sm btn-info"><i class="fas fa-search pr-2"></i>@lang('Invoices')</a>

                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <code id="json" data-json="{{$client}}"></code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-jsonview/1.2.3/jquery.jsonview.min.css"
          integrity="sha256-OhImf+9TMPW5iYXKNT4eRNntf3fCtVYe5jZqo/mrSQA=" crossorigin="anonymous"/>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jsonview/1.2.3/jquery.jsonview.min.js"
            integrity="sha256-yB+xHoEi5PoOnEAgHNbRMIbN4cNtOXAmBzkhNE/tQlI=" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $("#json").JSONView(document.getElementById('json').dataset.json);
        });
    </script>
@endsection
