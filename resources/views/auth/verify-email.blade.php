<x-guest-layout>
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <div class="mb-4 text-muted">
                Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan? Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang lain.
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 alert alert-success">
                    Link verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat registrasi.
                </div>
            @endif

            <div class="mt-4 d-flex align-items-center justify-content-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-muted">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>