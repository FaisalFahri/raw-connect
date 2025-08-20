<section>
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header">
            <h5 class="mb-0 fw-bold">Update Password</h5>
            <p class="mb-0 text-muted small">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                {{-- Password Saat Ini --}}
                <div class="mb-3">
                    <label for="update_password_current_password" class="form-label">Password Saat Ini</label>
                    <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div class="mb-3">
                    <label for="update_password_password" class="form-label">Password Baru</label>
                    <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-3">
                    <label for="update_password_password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                </div>

                <div class="d-flex align-items-center gap-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>

                    @if (session('status') === 'password-updated')
                        <span class="text-success small">Tersimpan.</span>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>