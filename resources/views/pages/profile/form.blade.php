@extends('layouts.template')
@section('content')
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $data['list'] }}</h4>
                        <a href="{{ route('profile.index') }}" class="btn btn-sm btn-primary mt-3"><span
                                class="fas fa-long-arrow-alt-left"></span> Back To
                            {{ $data['menu'] }}</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('name') has-error has-feedback @enderror">
                                    <label for="errorInput">Fullname</label>
                                    <input type="text" value="{{ old('name', $data['data']->name) }}"
                                        class="form-control" name="name">
                                    @error('name')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('email') has-error has-feedback @enderror">
                                    <label for="errorInput">Email</label>
                                    <input type="email" value="{{ old('email', $data['data']->email) }}"
                                        class="form-control" name="email">
                                    @error('email')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('phone') has-error has-feedback @enderror">
                                    <label for="errorInput">Phone</label>
                                    <input type="number" value="{{ old('phone', $data['data']->phone) }}"
                                        class="form-control" name="phone">
                                    @error('phone')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('company') has-error has-feedback @enderror">
                                    <label for="errorInput">Company</label>
                                    <input type="text" value="{{ old('company', $data['data']->company) }}"
                                        class="form-control" name="company">
                                    @error('company')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('division') has-error has-feedback @enderror">
                                    <label for="errorInput">Division</label>
                                    <input type="text" value="{{ old('division', $data['data']->division) }}"
                                        class="form-control" name="division">
                                    @error('division')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('profile_image') has-error has-feedback @enderror">
                                    <label for="errorInput">Upload Profile Image</label>
                                    <input type="file" accept="image/*"
                                        value="{{ old('profile_image', $data['data']->profile_image) }}"
                                        class="form-control" name="profile_image">
                                    @error('profile_image')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
