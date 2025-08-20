<x-guest-layout>
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <h5 class="text-center fw-bold mb-4">Atur Ulang Password</h5>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password Baru</label>
                    <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password" />
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                    <input id="password_confirmation" class="form-control"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>