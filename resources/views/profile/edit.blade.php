{{-- @extends('setup.layout')
@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
    @endsection --}}

    @extends('setup.layout')
@section('content')
    <div>
        <div class="px-5 dashboard-main-body-padding">
            <div class="dashboard-edit-profile-container shadow p-5 rounded-4">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileEditForm">
                    @method('PATCH')
                    @csrf
                    <section class="mb-5 d-flex justify-content-between">
                        <div class="d-flex align-items-center gap-4">
                            <div>
                                <input type="file" id="profile-img" accept="image/*" name="image"
                                    class="d-none profile-edited" />
                                <label for="profile-img" class="edit-profile-img">
                                    <img src="{{ @Auth::user()->profile_photo ? Storage::url(Auth::user()->profile_photo) : asset('assets/icon/user-avatar.svg') }}"
                                        alt="avatar" />
                                    <div class="profile-camera-icon">
                                        <i class="bi bi-camera-fill"></i>
                                    </div>
                                </label>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <h2 class="mb-3 text-center text-lg-start dashboard-payment-title">
                                    My Profile
                                </h2>
                                <div class="db-profile-info d-flex flex-column gap-1">
                                    <p class="small-text-14">
                                        {{ Auth::user()->name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <div class="row g-3">
                            <div class="col-12 login-field">
                                <label for="name" class="mb-2">Name <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}"
                                    placeholder="Enter full name"
                                    class="form-control input-style py-2 small-text-12 profile-edited" required />
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6 login-field">
                                <label for="phone_no" class="mb-2">Mobile No. <sup class="text-danger">*</sup></label>
                                <input type="text" name="phone_no" id="mobile" value="{{ Auth::user()->phone_no }}"
                                    placeholder="Enter mobile no."
                                    class="form-control input-style py-2 small-text-12 profile-edited" />
                                @error('phone_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6 login-field">
                                <label for="email" class="mb-2">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}"
                                    placeholder="Enter email address"
                                    class="form-control input-style py-2 small-text-12 profile-edited" />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div id="editBtnShow" class="search-btn mt-4">
                            <button class="small-text-12">
                                Update
                            </button>
                        </div>
                    </section>
                </form>
                <h5 class="mt-5">Update Password</h5>
                <hr>
                <form action="{{ route('password.update') }}" method="POST" enctype="multipart/form-data"
                    id="passForm">
                    @method('PUT')
                    @csrf

                    <section>
                        <div class="row g-1">
                            <div class="mb-3 login-field">
                                <label for="current_password" class="form-label">Password <sup
                                        class="text-danger">*</sup></label>
                                <input type="password" class="form-control small-text-12" id="current_password"
                                    name="current_password" placeholder="Enter your current password" required>
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 login-field">
                                <label for="password" class="form-label">New Password <sup
                                        class="text-danger">*</sup></label>
                                <input type="password" class="form-control small-text-12" id="password" name="password"
                                    placeholder="Enter your new password" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 login-field">
                                <label for="password_confirmation" class="form-label">Confirm Password <sup
                                        class="text-danger">*</sup></label>
                                <input type="password" class="form-control small-text-12" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirm password" required>
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="search-btn mt-4">
                            <button class="small-text-12">
                                Change Password
                            </button>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('#profileEditForm').validate({
            errorPlacement: function(error, element) {
                error.insertAfter($(element).closest('.input-style'));
            }
        });
        $('#passForm').validate();
    </script>
@endpush

