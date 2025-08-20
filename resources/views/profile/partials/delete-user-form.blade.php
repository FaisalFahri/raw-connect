<section class="space-y-6">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header">
            <h5 class="mb-0 fw-bold text-danger">Hapus Akun</h5>
        </div>
        <div class="card-body">
            <p class="text-muted">
                Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.
            </p>
            {{-- Tombol untuk memicu modal --}}
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                Hapus Akun
            </button>
        </div>
    </div>

    {{-- Modal Konfirmasi Penghapusan --}}
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-3">
                    @csrf
                    @method('delete')

                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title fw-bold" id="confirmUserDeletionModalLabel">
                            Apakah Anda yakin ingin menghapus akun Anda?
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted">
                            Setelah akun Anda dihapus, semua datanya akan dihapus secara permanen. Harap masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.
                        </p>

                        <div class="mt-3">
                            <label for="password_delete" class="form-label visually-hidden">Password</label>
                            <input
                                id="password_delete"
                                name="password"
                                type="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                placeholder="Password"
                            />
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>