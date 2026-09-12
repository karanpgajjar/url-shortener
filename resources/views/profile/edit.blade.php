<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="mb-4">Profile</h3>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Profile Information</h5>

                    @if (session("status") === "profile-updated")
                    <div class="alert alert-success">Saved.</div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method("patch")

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus>
                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            <x-input-error :messages="$errors->get('email')" />
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Update Password</h5>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method("put")

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input id="current_password" type="password" name="current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
                            <x-input-error :messages="$errors->get('current_password', 'updatePassword')" />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input id="password" type="password" name="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                            <x-input-error :messages="$errors->get('password', 'updatePassword')" />
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror">
                            <x-input-error :messages="$errors->get('password_confirmation', 'updatePassword')" />
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>

            <div class="card border-danger">
                <div class="card-body">
                    <h5 class="card-title text-danger">Delete Account</h5>
                    <p class="text-muted small">Once deleted, all resources will be permanently removed.</p>

                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        Delete Account
                    </button>
                </div>
            </div>

            <div class="modal fade" id="deleteAccountModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method("delete")
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm Account Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="delete_password" class="form-label">Password</label>
                                    <input id="delete_password" type="password" name="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror">
                                    <x-input-error :messages="$errors->get('password', 'userDeletion')" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>