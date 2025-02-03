<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Edit Barang Keluar</h4>
        </div>
    </div>
    <div class="card-body">
        
        <form action="{{ route('update.BarangKeluar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Nama barang</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="nama_barang" value="{{ $BarangKeluar->barang->nama_barang  }}" disabled>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Jumlah</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="jumlah" value="{{ $BarangKeluar->jumlah }}">
            </div>
            
            <div class="form-group">
                <label for="exampleInputEmail1">Harga Jual</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="harga_jual" value="{{ $BarangKeluar->harga_jual }}">
            </div>
            
            <div class="form-group">
                <label for="exampleInputEmail1">Tanggal Keluar</label>
                <input type="date" class="form-control" id="exampleInputEmail1" name="tanggal_keluar" value="{{ $BarangKeluar->tanggal_keluar }}">
            </div>
            
            
            <input type="hidden" name="id" value="{{ $BarangKeluar->id_keluar }}">

            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="submit" class="btn btn-danger">cancel</button>
        </form>
    </div>
</div>