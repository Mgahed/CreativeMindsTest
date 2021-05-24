@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3"><u>All Users</u></h1>
        <div class="row justify-content-center">
            <table class="table table-dark">
                <thead>
                <tr>
                    <th scope="col">username</th>
                    <th scope="col">email</th>
                    <th scope="col">mobile number</th>
                    <th scope="col">role</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th>{{$user->username}}</th>
                        <td>{{$user->email==null?"no mail":$user->email}}</td>
                        <td>{{$user->mobile_number==null?"no number":$user->mobile_number}}</td>
                        <td>{{$user->role}}</td>
                        <td>
                            <a href="{{ route('crud.update_form',$user->id) }}" class="btn btn-success">Edit</a>
                            <a href="{{ route('crud.delete',$user->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
