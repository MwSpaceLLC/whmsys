@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            @include('components.side')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header seen">{{$client->companyname}}

                        <a href="/client/{{$client->id}}/invoices" class="btn btn-sm btn-info"><i
                                class="fas fa-search pr-2"></i>@lang('Invoices')</a>

                        <a href="/client/{{$client->id}}/cleanly" class="btn btn-sm purple-gradient cleanly">
                            <i class="fab fa-html5 pr-2"></i>@lang('Cleanly')</a>

                    </div>

                    <div class="card-body">

                        <span class="badge span-{{$client->status}}">@lang($client->status)</span>

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
        $(function () {
            $("#json").JSONView(document.getElementById('json').dataset.json);
        });
    </script>
@endsection
