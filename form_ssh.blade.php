@php
$tipe_name = '';
switch ($tipe) {
    case 1: // SSH
        $tipe_name = 'SSH';
        break;
    case 2: // HSPK
        $tipe_name = 'HSPK';
        break;
    case 3: // ASB
        $tipe_name = 'ASB';
        break;
    case 4: // SBU
        $tipe_name = 'SBU';
        break;
        defult:

        break;
}
@endphp

<form action="{{ route('opd.usulan.ajukan') }}" method="POST">
    @csrf
    <input type="hidden" value="{{ session('tahun') }}" class="form-control" name="" id="" readonly>
    <input type="hidden" value="{{ $tipe }}" class="form-control" name="tipe_ssh" id="" readonly>
    <div class="row">
        {{-- <div class="form-group">
            <input type="checkbox" name="zona"> Zona
        </div> --}}
        <div class="form-group col-md-12 ">
            <div class="btn btn-soft-success waves-effect waves-light rounded-pill">
                <div class="form-check form-check-success ">
                    <input class="form-check-input" type="checkbox" value="on" id="customckeck_{{ $tipe }}" name="zona">
                    <label class="form-check-label" for="customckeck_{{ $tipe }}">Aktifkan Perhitungan Zona</label>
                </div>
            </div>

        </div>
        <div class="form-group col-md-12 mb-2">
            <label for="">Kelompok Standar Harga ({{ $tipe_name }}) <span
                    class="text-danger">*</span></label>
            <select name="kelompok_id" class="form-control select2" id="form_klmpk_{{ $tipe }}"
                data-width="100%" required>

            </select>
        </div>
        <div class="form-group col-md-6 mb-2">
            <label for="">Uraian Objek <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="harga_nama" id="" required>
        </div>
        <div class="form-group col-md-6 mb-2">
            <label for="">Satuan <span class="text-danger">*</span></label>
            <select class="form-control form-satuan" data-width="100%" id="" name="satuan_id" required>
            </select>
        </div>
        <div class="form-group col-md-6 mb-2">
            <label for="">Spesifikasi <span class="text-danger">*</span></label>
            <textarea class="form-control" placeholder="Jangan menuliskan/menyebutkan merek" rows="4" name="harga_spek"
                id="" required></textarea>
        </div>
        <div class="form-group col-md-6 mb-2">
            <div class="form-group">
                <label for="">Harga (Rp) <span class="text-danger">*</span></label>
                <input type="number" step="any"
                    class="form-control @if (in_array($tipe, [2, 3])) harga-pekerjaan @endif" name="harga_nominal"
                    id="item_harga_{{ $tipe }}" required>
            </div>
            <div class="form-group">
                <select class="form-control mt-3 bg-gd-aqua text-dark" id="" name="harga_pajak" required>
                    <option value="">-- Pilih Status Pajak --</option>
                    <option value="1">Harga Sudah Termasuk Pajak (Harga Final) ✅</option>
                    <option value="2">Harga Butuh Penambahan Pajak ⚠️</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-12 mb-2">
            <label for="">Rekening Belanja (Boleh lebih dari satu) <span class="text-danger">*</span></label>
            <select class="form-control form-rekening" data-width="100%" id="" name="harga_rekening[]" multiple
                required>
            </select>
        </div>
        @if (in_array($tipe, [2, 3]))
            <div class="col-12" style="overflow: auto">
                <h5>Rincian Komponen</h5>
                <div class="mb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" onclick="initAddKomponen('{{ $tipe }}')"
                                class="btn btn-sm btn-soft-dark rounded-pill waves-effect waves-light elemen-pekerjaan">
                                <i class="mdi mdi-layers-plus"></i> Tambah Komponen
                            </button>
                        </div>
                        <div class="col-md-6 text-end">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modal_warning"
                                class="btn btn-sm btn-warning rounded-pill waves-effect waves-light elemen-pekerjaan">
                                <i class="mdi mdi-pencil-box-outline"></i> Input Harga Manual
                            </button>

                            <button type="button" onclick="toggleHarga()"
                                class="btn btn-sm btn-info rounded-pill waves-effect waves-light btn-komponen"
                                style="display: none">
                                <i class="mdi mdi-layers-plus"></i> Input Komponen
                            </button>
                        </div>
                    </div>

                </div>
                <table class="table table-hover table-striped table-dark bg-teal table-bordered elemen-pekerjaan"
                    style="font-size: 9pt">
                    <thead class="bg-teal-700">
                        <tr>
                            <th width="70">Tipe</th>
                            <th width="300">Uraian</th>
                            <th>Spesifikasi</th>
                            <th width="150" class="text-end">Harga Satuan (Rp)</th>
                            <th class="text-center" width="90">Koefisien</th>
                            <th width="150" class="text-end">Total (Rp)</th>
                            <th width="15"></th>
                        </tr>
                    </thead>
                    <tbody id="table_komponen_body_{{ $tipe }}">
                    </tbody>
                </table>
            </div>
        @endif
        <div class="form-group text-end col-md-12 mb-2">
            <hr>
            <button type="submit" class="btn btn-success ight">
                <span class="btn-label"><i class="mdi mdi-send-outline"></i></span> Kirim Usulan
            </button>
        </div>
    </div>
</form>

@push('additional_script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#form_klmpk_{{ $tipe }}').select2({
                placeholder: 'Cari...',
                minimumInputLength: 3,
                ajax: {
                    url: "{{ route('get-data.kelompok') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            type: '{{ $tipe }}'
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    text: item.kelompok_kode + ' - ' + item.kelompok_nama,
                                    id: item.id,
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endpush
