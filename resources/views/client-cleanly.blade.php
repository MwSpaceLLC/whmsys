@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            @include('components.side')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header seen">{{$client->email}}

                        <a href="/client/{{$client->id}}" class="btn btn-sm btn-default">
                            <i class="fas fa-code pr-2"></i>@lang('Json')</a>
                    </div>

                    <div class="card-body">

                        <span class="badge span-{{$client->status}}">@lang($client->status)</span>

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
                                    @foreach($client->toArray() as $key => $value)
                                        <tr>
                                            <th scope="row">{{$key}}</th>
                                            <td>{!! $value !!}</td>
                                        </tr>
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

@endsection

@section('css')

@endsection

@section('js')

@endsection
