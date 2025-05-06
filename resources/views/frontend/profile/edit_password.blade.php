<!-- Edit Password Tab -->
<div class="tab-pane fade show active" id="edit" role="tabpanel">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
            Perbarui Password
        </div>

        <div class="card-body">
            <form action="{{ route('siswa.profile.newPassword.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <div class="input-group">
                        <input type="password"
                            class="form-control password-input @error('password') is-invalid @enderror" name="password"
                            placeholder="Masukkan password baru">
                        <button type="button" class="input-group-text hide-show-password">
                            <i class="bi bi-eye"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password"
                            class="form-control password-input @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" placeholder="Masukkan konfirmasi password baru">
                        <button type="button" class="input-group-text hide-show-password">
                            <i class="bi bi-eye"></i>
                        </button>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Perbarui Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Edit Password Tab -->
@push('scripts')
    <script>
        document.querySelectorAll('.hide-show-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    </script>
@endpush
