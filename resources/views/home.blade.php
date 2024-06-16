@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="my-2">Dashboard</h2>
            <div class="row">
                @if(Auth::user()->role == 'admin')
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">Distributor</div>
                        <div class="card-body text-center">
                            <h1>{{$distributor_count}}</h1>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{route('distributors')}}">View</a>
                                <a href="{{route('create.distributor')}}">Add</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'distributor')
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">Agents</div>
                        <div class="card-body text-center">
                            <h1>{{$agent_count}}</h1>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{route('agents')}}">View</a>
                                <a href="{{route('create.agent')}}">Add</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'distributor' || Auth::user()->role == 'agent')
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">Users</div>
                        <div class="card-body text-center">
                            <h1>{{$user_count}}</h1>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{route('users')}}">View</a>
                                <a href="{{route('create.user')}}">Add</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(Auth::user()->role == 'user')
                <div class="border my-2 pt-2">
                    <p>Name : {{Auth::user()->name}}</p>
                    <p>Email : {{Auth::user()->email}}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
