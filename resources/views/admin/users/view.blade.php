@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>User Details
                        <a href="{{ url('users') }}" class="btn btn-primary btn-sm float-right">Back</a>
                    </h1>
                    <hr>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                        <label for="">Role</label>
                            <div class="p-2 border">{{ $user->role_as == '0' ? 'User':'Admin' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label for="">First Name</label>
                            <div class="p-2 border">{{ $user->name }}</div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Last Name</label>
                            <div class="p-2 border">{{ $user->lname }}</div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Email</label>
                            <div class="p-2 border">{{ $user->email }}</div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Phone</label>
                            <div class="p-2 border">{{ $user->phone }}</div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Adress 1</label>
                            <div class="p-2 border">{{ $user->adress1 }}</div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Adress 2</label>
                            <div class="p-2 border">{{ $user->adress2 }}</div>
                        </div>
                        <div class="col-md-4">
                            <label for="">City</label>
                            <div class="p-2 border">{{ $user->city }}</div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Country</label>
                            <div class="p-2 border">{{ $user->country }}</div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Zip code</label>
                            <div class="p-2 border">{{ $user->zipcode }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection