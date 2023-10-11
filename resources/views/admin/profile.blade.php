@extends('layouts.admin.master')

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Profile Page</h4>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header text-center">
                        <img src="{{ (!empty($user->profile_image))? url('upload/admin_images/'.$user->profile_image):url('images/no_image.jpg') }}"
                        alt="Profile Image" class="rounded-circle avatar-xl">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Name: {{ $user->name }}</h4><hr>
                        <h4 class="card-title">Email: {{ $user->email }}</h4><hr>
                        <a href="{{ route('profile.edit') }}" class="btn btn-info btn-rounded waves-effect waves-light">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
