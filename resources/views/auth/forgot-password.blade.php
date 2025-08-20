<x-guest-layout>
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <div class="mb-4 text-muted">
                Lupa password Anda? Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan link untuk mengatur ulang password Anda melalui email.
            </div>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Alamat Email</label>
                    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        Kirim Link Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>