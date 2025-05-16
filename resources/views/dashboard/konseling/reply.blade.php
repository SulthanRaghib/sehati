<!-- Modal Reply -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const replyButtons = document.querySelectorAll('.btn-reply');

        replyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const judul = this.getAttribute('data-judul');
                const isiKonseling = this.getAttribute('data-konseling');
                const nama = this.getAttribute('data-nama');

                document.getElementById('konseling_id').value = id;
                document.getElementById('judul').textContent = judul;
                document.getElementById('isi_konseling').textContent = isiKonseling;
                document.getElementById('nama').textContent = nama;
            });
        });
    });
</script>

<div class="modal fade text-left" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">
                    Balas Pesan Konseling | {{ $a->siswa->nama }}
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <form action="{{ route('admin.konseling.reply') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group row align-items-center">
                            <input type="hidden" name="konseling_id" id="konseling_id">

                            <div class="col-lg-3 col-3">
                                <label class="col-form-label">Judul</label>
                            </div>
                            <div class="col-lg-9 col-9">
                                : <span id="judul">{{ $a->judul }}</span>
                            </div>

                            <div class="col-lg-3 col-3">
                                <label class="col-form-label">Pesan Konseling</label>
                            </div>
                            <div class="col-lg-9 col-9">
                                : <span id="isi_konseling">{{ $a->isi_konseling }}</span>
                            </div>
                            <div class="col-lg-12 col-12">
                                <label class="col-form-label">Balas Pesan</label>
                                <textarea name="isi_jawaban" id="isi_jawaban" class="form-control  @error('isi_jawaban') is-invalid @enderror"
                                    placeholder="Balas Pesan Konseling" rows="10" cols="100" style="resize: none;">{{ old('isi_jawaban') }}</textarea>
                                @error('isi_jawaban')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
                </div>
            </form>
        </div>
    </div>
</div>
