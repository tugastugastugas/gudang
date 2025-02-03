<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Edit Barang Masuk</h4>
        </div>
    </div>
    <div class="card-body">
        
        <form action="{{ route('update.BarangMasuk') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Nama barang</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="nama_barang" value="{{ $BarangMasuk->barang->nama_barang  }}" disabled>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Jumlah</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="jumlah" value="{{ $BarangMasuk->jumlah }}">
            </div>
            
            <div class="form-group">
                <label for="exampleInputEmail1">Harga Beli</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="harga_beli" value="{{ $BarangMasuk->harga_beli }}">
            </div>
            
            <div class="form-group">
                <label for="exampleInputEmail1">Tanggal Masuk</label>
                <input type="date" class="form-control" id="exampleInputEmail1" name="tanggal_masuk" value="{{ $BarangMasuk->tanggal_masuk }}">
            </div>
            
            
            <input type="hidden" name="id" value="{{ $BarangMasuk->id_masuk }}">

            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="submit" class="btn btn-danger">cancel</button>
        </form>
    </div>
</div>