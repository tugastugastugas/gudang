<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Edit Barang</h4>
        </div>
    </div>
    <div class="card-body">
        
        <form action="{{ route('update.barang') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Kode barang</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="kode_barang" value="{{ $barang->kode_barang }}" disabled>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Nama barang</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="nama_barang" value="{{ $barang->nama_barang }}">
            </div>
            
            <div class="form-group">
                <label for="exampleInputEmail1">Stok</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="stok" value="{{ $barang->stok }}">
            </div>
            
            <div class="form-group">
                <label for="exampleInputEmail1">Satuan</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="satuan" value="{{ $barang->satuan }}">
            </div>
            
            
            <input type="hidden" name="id" value="{{ $barang->id_barang }}">

            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="submit" class="btn btn-danger">cancel</button>
        </form>
    </div>
</div>