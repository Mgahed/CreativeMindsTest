@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3"><u>Update User Info</u></h1>
        <form method="post" action="{{route('crud.update',$user->id)}}">
            @csrf
            <div class="form-group">
                <label for="exampleInputusername">username</label>
                <input type="text" name="username" class="form-control" id="exampleInputusername"
                       placeholder="Enter username" value="{{$user->username}}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                       value="{{$user->email}}">
            </div>
            <div class="form-group">
                <label for="exampleInputNumber">Mobile Number</label>
                <input type="text" name="mobile_number" class="form-control" id="exampleInputNumber"
                       placeholder="Mobile Number" value="{{$user->mobile_number}}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
