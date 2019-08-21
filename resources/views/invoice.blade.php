@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <ul class="side-menu">
                    <li><a href="/home">@lang('dashboard')</a></li>
                    <li><a href="/clients">@lang('clients')</a></li>
                    <li class="active"><a href="/invoices">@lang('invoices')</a></li>
                    <li><a href="/settings">@lang('settings')</a></li>
                </ul>
            </div>

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header seen">{{$invoice->client->firstname}} {{$invoice->client->lastname}}
                        #<b>{{$invoice->invoicenum}}</b>

                        @if($invoice->status === 'Unpaid')

                            <a onclick="return confirm('@lang('U are shure?')');"
                               href="/script/Invoice/{{$invoice->id}}/status/Paid" class="btn btn-sm btn-success"><i
                                    class="far fa-money-bill-alt pr-2"></i>@lang('Pay')</a>
                        @endif

                        @if($invoice->status === 'Paid')

                            <a onclick="return confirm('@lang('U are shure?')');"
                               href="/script/Invoice/{{$invoice->id}}/status/Unpaid" class="btn btn-sm btn-danger"><i
                                    class="far fa-money-bill-alt pr-2"></i>@lang('Unpay')</a>
                        @endif

                        <a href="/client/{{$invoice->client->id}}/invoices" class="btn btn-sm btn-info"><i
                                class="fas fa-search pr-2"></i>@lang('See All')</a>

                        <span class="badge span-{{$invoice->status}}">@lang($invoice->status)</span>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('danger') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <code id="json" data-json="{{$invoice_child}}"></code>
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
