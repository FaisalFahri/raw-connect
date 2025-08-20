<x-guest-layout>
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <div class="mb-4 text-muted">
                Ini adalah area aman dari aplikasi. Mohon konfirmasi password Anda sebelum melanjutkan.
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-control"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>