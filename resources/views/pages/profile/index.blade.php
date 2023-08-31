@extends('layouts.template')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $data['list'] }}</h4>
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary mt-3"><span
                            class="fas fa-pencil"></span> Edit Profile</a>
                </div>
                <div class="card-body">
                    <center>
                        <div class="avatar-lg" style="width: 250px!important;
    height: 250px!important;"><img
                                src="{{ $data['data']->profile[0]->photo_profile ? $data['data']->profile[0]->photo_profile : asset('/') . 'img/profile.jpg' }}"
                                alt="image profile" class="avatar-img rounded" width="180"></div>
                    </center>
                    <table class="display table ">
                        <tr>
                            <th>Name</th>
                            <th>{{ $data['data']->name }}</th>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th>{{ $data['data']->email }}</th>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <th>{{ $data['data']->phone }}</th>
                        </tr>
                        <tr>
                            <th>Company</th>
                            <th>{{ $data['data']->profile[0]->company }}</th>
                        </tr>
                        <tr>
                            <th>Division</th>
                            <th>{{ $data['data']->profile[0]->division }}</th>
                            <th></th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
