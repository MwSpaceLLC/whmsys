@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            @include('components.side')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header seen">vdvdvd /
                        #<b>vdsvdsvds</b>

                        <a href="/ticket/open/save" class="btn btn-sm btn-default">
                            <i class="fas fa-plus pr-2"></i>@lang('Open')</a>

                        <a href="/ticket/open/save" class="btn btn-sm btn-default">
                            <i class="fab fa-sign-out-alt pr-2"></i>@lang('Open')</a>
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
