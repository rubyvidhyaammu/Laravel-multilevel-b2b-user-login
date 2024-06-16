@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{route('home')}}">Back to home</a>
            <h2 class="my-2">Agents List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        @if(Auth::user()->role == 'admin')
                        <th>Distributor Name</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach($agents as $val)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$val->name}}</td>
                        <td>{{$val->email}}</td>
                        @if(Auth::user()->role == 'admin')
                        <td>{{$val->dist_name}}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection