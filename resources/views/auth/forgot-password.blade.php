<x-guest-layout>
    <p class="text-muted small mb-3">
        Forgot your password? Enter your email and we'll send a reset link.
    </p>

    @if (session("status"))
    <div class="alert alert-success">{{ session("status") }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Email Password Reset Link
        </button>
    </form>
</x-guest-layout>