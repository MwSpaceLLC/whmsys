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
                    <div class="card-header">
                        <a href="/invoices/Paid" class="btn btn-sm btn-success"><i class="fas fa-search-dollar pr-2"></i></i>@lang('Paid')</a>
                        <a href="/invoices/Unpaid"  class="btn btn-sm btn-danger"><i class="fas fa-search-location pr-2"></i>@lang('Unpaid')</a>
                        <a href="/invoices/Cancelled" class="btn btn-sm btn-elegant"><i class="fas fa-search pr-2"></i>@lang('Cancelled')</a>
                        <a href="/invoices/Overdue" class="btn btn-sm btn-light"><i class="fas fa-search pr-2"></i>@lang('Overdue')</a>
                        {{ $invoices->links() }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">

                                <!-- Card -->
                                @foreach($invoices as $invoice)
                                    <div class="card">
                                        <i class="fas fa-file-invoice-dollar badge-{{$invoice->status}}"></i>
                                        <!-- Card content -->
                                        <div class="card-body row">

                                            <div class="col-md-10">
                                                <!-- Title -->
                                                <h4 class="card-title"><span
                                                        class="cl-title">{!! \Illuminate\Support\Str::limit($invoice->client()->first()->firstname, 25) !!}</span>
                                                    | <span class="cl-span">{{$invoice->subtotal}}</span></h4>
                                                <!-- Text -->
                                                <p class="card-text">
                                                    @lang('Created at') {{$invoice->date->format(config('app.time_format'))}} /
                                                    <span class="info">@lang('Due at') {{$invoice->duedate->format(config('app.time_format'))}}</span>
                                                </p>
                                                <!-- Button -->
                                            </div>

                                            <div class="col-md-2">
                                                <a href="/invoice/{{$invoice->id}}" class="btn btn-sm btn-primary waves-effect waves-light"><i
                                                        class="fas fa-external-link-alt"></i></a>
                                            </div>

                                        </div>

                                    </div>
                            @endforeach
                            <!-- Card -->

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>

    </script>
@endsection
