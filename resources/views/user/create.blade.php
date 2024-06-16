@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{route('home')}}">Back to home</a>
            @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                {{session('success')}}
            </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Create User') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('create.user') }}">
                        @csrf
                        <div class="row mb-3" @if(Auth::user()->role == 'distributor' || Auth::user()->role == 'agent') style="display:none" @endif>
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Distributor') }}</label>

                            <div class="col-md-6">
                                <select id="distributor" type="text" class="form-control @error('distributor') is-invalid @enderror" name="distributor" value="{{ old('distributor') }}" required autocomplete="distributor" autofocus>
                                    <option value="">--select--</option>
                                    @foreach($distributor as $val)
                                    <option value="{{$val->id}}" @if($distributor_id == $val->id) selected="selected" @endif>{{$val->name}}</option>
                                    @endforeach
                                </select>
                                @error('distributor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3" @if(Auth::user()->role == 'agent') style="display:none" @endif>
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Agent') }}</label>

                            <div class="col-md-6">
                                <select id="agent" type="text" class="form-control @error('agent') is-invalid @enderror" name="agent" value="{{ old('agent') }}" required autocomplete="agent" autofocus>
                                    <option value="">--select--</option>
                                    @foreach($agent as $val)
                                    <option value="{{$val->id}}" @if(Auth::user()->id == $val->id) selected="selected" @endif>{{$val->name}}</option>
                                    @endforeach
                                </select>
                                @error('agent')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create User') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js_content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#distributor').change(function(){
            $('#agent').html('<option value="">--select--</option>');
            if(this.value > 0){
                $.ajax({
                    url: "{{route('agent.data')}}",
                    type:"post",
                    data: {"_token": "{{ csrf_token() }}", "distributor_id":this.value},
                    success: function(result){
                        $("#agent").append(result);
                    }
                });
            }
        });
    });
</script>
@endsection
