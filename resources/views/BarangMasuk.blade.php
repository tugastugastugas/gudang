<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Barang Masuk</h4>
                    <br>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New Barang</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Supplier</th>
                                <th>Jumlah</th>
                                <th>Harga Beli</th>
                                <th>Total Harga</th>
                                <th>Satuan</th>
                                <th>Tanggal Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($BarangMasuk as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->barang->kode_barang }}</td>
                                <td>{{ $data->barang->nama_barang }}</td>
                                <td>{{ $data->supplier }}</td>
                                <td>{{ $data->jumlah }}</td>
                                <td>{{ $data->harga_beli }}</td>
                                <td>{{ $data->total_harga }}</td>
                                <td>{{ $data->barang->satuan }}</td>
                                <td>{{ $data->tanggal_masuk }}</td>
                                <td>
                                    <a href="{{ route('e_BarangMasuk', $data->id_masuk) }}">
                                        <button class="btn btn-danger">
                                            <i class="now-ui-icons ui-1_check"></i> Edit
                                        </button>
                                    </a>
                                    <form action="{{ route('BarangMasuk.destroy', $data->id_masuk) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Supplier</th>
                                <th>Jumlah</th>
                                <th>Harga Beli</th>
                                <th>Total Harga</th>
                                <th>Satuan</th>
                                <th>Tanggal Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Menambah Pengguna -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Tambah Barang Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('t_BarangMasuk') }}" method="POST">
                    @csrf

                    <div class="mb-3 buku">
                        <label class="form-label">Barang</label>
                        <select class="form-select" id="id_barang" name="id_barang" required>
                            <option value="" disabled selected>Pilih Barang</option>
                            @foreach ($barang as $j)
                            <option value="{{ $j->id_barang }}">{{ $j->nama_barang }} | {{ $j->kode_barang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input type="text" class="form-control" id="supplier" name="supplier" required>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div>

                    <div class="mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" id="harga_beli" name="harga_beli" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>