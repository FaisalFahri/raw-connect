<x-guest-layout>
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <h5 class="text-center fw-bold mb-4">Selamat Datang Kembali</h5>

            {{-- Untuk menampilkan pesan status, misal setelah reset password --}}
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Alamat Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Ingat Saya --}}
                <div class="mb-3 form-check">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label">Ingat saya</label>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    @if (Route::has('password.request'))
                        <a class="small text-decoration-none" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                    
                    <button type="submit" class="btn btn-primary fw-semibold px-4">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>