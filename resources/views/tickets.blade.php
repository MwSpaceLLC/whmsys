@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            @include('components.side')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <a href="/tickets/Open" class="btn btn-sm btn-info"><i
                                class="fas fa-search-dollar pr-2"></i></i>@lang('Open')</a>
                        <a href="/invoices/Answered" class="btn btn-sm btn-warning"><i
                                class="fas fa-search-location pr-2"></i>@lang('Answered')</a>
                        <a href="/invoices/Closed" class="btn btn-sm btn-success"><i
                                class="fas fa-search pr-2"></i>@lang('Closed')</a>
                        {{ $tickets->links() }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">

                                <!-- Card -->
                                @foreach($tickets as $ticket)
                                    <div class="card">
                                        <i class="fas fa-envelope badge-{{$ticket->status}}"></i>
                                        <!-- Card content -->
                                        <div class="card-body row">

                                            <div class="col-md-10">
                                                <!-- Title -->
                                                <h4 class="card-title"><span
                                                        class="cl-title">{!! \Illuminate\Support\Str::limit($ticket->title, 65) !!}</span>
                                                    | <span class="cl-span">{{$ticket->email}}</span></h4>
                                                <!-- Text -->
                                                <p class="card-text">
                                                    @lang('Created at') {{$ticket->date->format(config('app.time_format'))}}
                                                    /
                                                    <span
                                                        class="info">@lang('Last reply at') {{$ticket->lastreply->format(config('app.time_format'))}}</span>
                                                </p>
                                                <!-- Button -->
                                            </div>

                                            <div class="col-md-2">
                                                <a href="/ticket/{{$ticket->id}}"
                                                   class="btn btn-sm btn-primary waves-effect waves-light"><i
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
