<form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" 
                value="{{ request('tanggal_awal') }}">
        </div>
        <div class="col-md-3">
            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" 
                value="{{ request('tanggal_akhir') }}">
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>
