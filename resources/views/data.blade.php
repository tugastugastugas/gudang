<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Data Keuangan</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Supplier</th>
                                <th>Pembeli</th>
                                <th>Satuan</th>
                                <th>Total Harga Beli</th>
                                <th>Total Harga Jual</th>
                                <th>Keuntungan / Kerugian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $data2)
                                <tr>
                                    <td>{{ $data2->kode_barang }}</td>
                                    <td>{{ $data2->nama_barang }}</td>
                                    <td>{{ $data2->supplier }}</td>
                                    <td>{{ $data2->pembeli }}</td>
                                    <td>{{ $data2->satuan }}</td>
                                    <td>{{ $data2->total_harga_beli }}</td>
                                    <td>{{ $data2->total_harga_jual }}</td>
                                    <td>{{ $data2->keuntungan_kerugian }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Supplier</th>
                                <th>Pembeli</th>
                                <th>Satuan</th>
                                <th>Total Harga Beli</th>
                                <th>Total Harga Jual</th>
                                <th>Keuntungan / Kerugian</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
x