@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            @include('components.side')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header seen">{{$invoice->client()->first()->firstname}} /
                        #<b>{{$invoice->invoicenum}}</b>

                        <a href="/invoice/{{$invoice->id}}" class="btn btn-sm btn-default">
                            <i class="fas fa-code pr-2"></i>@lang('Json')</a>

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
                                <table class="table table-striped">
                                    <tbody>
                                    @foreach($invoice->toArray() as $key => $value)
                                        <tr>
                                            <th scope="row">{{$key}}</th>
                                            <th>{!! $value !!}</th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <hr>

                                <div class="card">
                                    <div class="card-header"> @lang('Invoice Item')</div>
                                    <div class="card-body">
                                        <table class="table table-striped invoice-item">
                                            <tbody>
                                            @foreach($invoice->item()->get() as $item)
                                                @foreach($item->toArray() as $key => $value)
                                                    <tr>
                                                        <th scope="row">{{$key}}</th>
                                                        <th>{!! $value !!}</th>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')

@endsection

@section('js')

@endsection
