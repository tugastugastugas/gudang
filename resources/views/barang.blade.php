<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Barang</h4>
                    <br>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addUserModal">Add New Barang</button>
                    <input type="file" id="barcode-image" accept="image/*">
                    <canvas id="canvas" style="display: none;"></canvas>
                    <p>Hasil Scan: <span id="barcode-result"></span></p>
                    <form action="" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="barcode-input" class="form-label">Kode Barang</label>
                            <input type="text" id="barcode-input" name="kode_barang" readonly class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" id="nama_barang" name="nama_barang" readonly class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" id="stok" name="stok" readonly class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <input type="text" id="satuan" name="satuan" readonly class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="foto_barang" class="form-label">Foto Barang</label>
                            <!-- Menampilkan gambar jika ada -->
                            <img id="foto_barang_img" src="" alt="Foto Barang" style="max-width: 100%; height: auto; display: none;">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>


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
                                <th>Stok</th>
                                <th>Satuan</th>
                                <th>Foto Barang</th>
                                <th>Barcode</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barang as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->kode_barang }}</td>
                                <td>{{ $data->nama_barang }}</td>
                                <td>{{ $data->stok }}</td>
                                <td>{{ $data->satuan }}</td>
                                <td>
                                    @if($data->foto_barang)
                                    <img src="{{ asset('storage/' . $data->foto_barang) }}" alt="Foto Barang" style="width: 200px; height: auto; cursor: pointer;">
                                    @else
                                    No Photos
                                    @endif
                                </td>
                                <td>
                                    @if($data->barcode)
                                    <img src="{{ asset($data->barcode) }}" alt="Barcode" style="width: 200px; height: auto; cursor: pointer;">
                                    @else
                                    No Barcode
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('e_barang', $data->id_barang) }}">
                                        <button class="btn btn-danger">
                                            <i class="now-ui-icons ui-1_check"></i> Edit
                                        </button>
                                    </a>
                                    <form action="{{ route('barang.destroy', $data->id_barang) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
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
                                <th>Stok</th>
                                <th>Satuan</th>
                                <th>Foto Barang</th>
                                <th>Barcode</th>
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
                <h5 class="modal-title" id="addUserModalLabel">Tambah barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('t_barang') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" required>
                    </div>

                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <input type="text" class="form-control" id="satuan" name="satuan" required>
                    </div>

                    <div class="mb-3">
                        <label for="foto_barang" class="form-label">Foto Barang</label>
                        <input type="file" class="form-control" id="foto_barang" name="foto_barang" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("barcode-image").addEventListener("change", function(event) {
        let file = event.target.files[0];
        if (!file) return;

        let reader = new FileReader();
        reader.onload = function(e) {
            let img = new Image();
            img.src = e.target.result;
            img.onload = function() {
                let canvas = document.getElementById("canvas");
                let ctx = canvas.getContext("2d");
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0, img.width, img.height);

                // Menyediakan image data untuk dipindai
                let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                let code = jsQR(imageData.data, canvas.width, canvas.height, {
                    inversionAttempts: "dontInvert",
                });

                if (code) {
                    console.log("QR Code Ditemukan: ", code.data);
                    document.getElementById("barcode-result").innerText = code.data; // Menampilkan hasil
                    document.getElementById("barcode-input").value = code.data; // Menambahkan kode barang ke input field
                    fetchBarangData(code.data); // Memanggil fungsi untuk menampilkan data barang berdasarkan kode_barang
                } else {
                    console.warn("QR Code Tidak Ditemukan");
                    document.getElementById("barcode-result").innerText = "QR Code Tidak Ditemukan";
                }
            };
        };
        reader.readAsDataURL(file);
    });

    // Fungsi untuk mengambil data barang berdasarkan kode_barang yang terdeteksi
    function fetchBarangData(kode_barang) {
        // Kirim permintaan AJAX untuk mengambil data barang berdasarkan kode_barang
        fetch('/barang/' + kode_barang) // URL ini sesuai dengan route yang menangani pencarian data barang
            .then(response => response.json())
            .then(data => {
                if (data) {
                    // Menampilkan data barang di form
                    document.getElementById("nama_barang").value = data.nama_barang;
                    document.getElementById("stok").value = data.stok;
                    document.getElementById("satuan").value = data.satuan;

                    // Menampilkan foto barang dalam elemen <img>
                    let fotoBarangImg = document.getElementById("foto_barang_img");
                    if (fotoBarangImg) {
                        fotoBarangImg.src = '/storage/' + data.foto_barang; // Atur URL foto untuk menampilkan gambar
                        fotoBarangImg.style.display = 'block'; // Menampilkan elemen <img> jika ada foto
                    }
                } else {
                    console.warn("Data Barang Tidak Ditemukan");
                }
            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });
    }
</script>