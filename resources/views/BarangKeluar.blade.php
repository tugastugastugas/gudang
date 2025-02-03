<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Barang Keluar</h4>
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
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Jual</th>
                                <th>Total Harga</th>
                                <th>Tanggal Keluar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($BarangKeluar as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->barang->nama_barang }}</td>
                                <td>{{ $data->jumlah }}</td>
                                <td>{{ $data->harga_jual }}</td>
                                <td>{{ $data->total_harga }}</td>
                                <td>{{ $data->tanggal_keluar }}</td>
                                <td>
                                    <a href="{{ route('e_BarangKeluar', $data->id_keluar) }}">
                                        <button class="btn btn-danger">
                                            <i class="now-ui-icons ui-1_check"></i> Edit
                                        </button>
                                    </a>
                                    <form action="{{ route('BarangKeluar.destroy', $data->id_keluar) }}" method="POST" style="display:inline;">
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
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Jual</th>
                                <th>Total Harga</th>
                                <th>Tanggal Keluar</th>
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
                <h5 class="modal-title" id="addUserModalLabel">Tambah Barang Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('t_BarangKeluar') }}" method="POST">
                    @csrf

                    <div class="mb-3 buku">
                        <label class="form-label">Barang</label>
                        <select class="form-select" id="id_barang" name="id_barang" required>
                            <option value="" disabled selected>Pilih Barang</option>
                            @foreach ($barang as $j)
                                <option value="{{ $j->id_barang }}">{{ $j->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div>

                    <div class="mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" id="harga_jual" name="harga_jual" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                        <input type="date" class="form-control" id="tanggal_keluar" name="tanggal_keluar" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>