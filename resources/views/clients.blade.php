@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            @include('components.side')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">@lang('Clients') {{ $clients->links() }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">

                                <!-- Card -->
                                @foreach($clients as $client)
                                    <div class="card">
                                        <i class="fas fa-user-circle badge-{{$client->status}}"></i>
                                        <!-- Card content -->
                                        <div class="card-body row">

                                            <div class="col-md-10">
                                                <!-- Title -->
                                                <h4 class="card-title"><span class="cl-title">{{$client->firstname}}</span> | <span class="cl-span">{{$client->city}}</span></h4>
                                                <!-- Text -->
                                                <p class="card-text">
                                                    {{$client->datecreated->diffforhumans()}} | {{$client->phonenumber}} | {{$client->email}} | {{$client->tax_id}}
                                                </p>
                                                <!-- Button -->
                                            </div>

                                            <div class="col-md-2">
                                                <a href="/client/{{$client->id}}" class="btn btn-primary btn-sm waves-effect waves-light"><i class="fas fa-external-link-alt"></i></a>
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
