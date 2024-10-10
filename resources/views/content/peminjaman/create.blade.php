@extends('master.main')
 @section('title', 'Create Data')
 @section('content')
 <script>
        function updateStok() {
            const selectElement = document.querySelector('select[name="nama_barang"]');
            const stokDisplay = document.getElementById('stokDisplay');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const stok = selectedOption.getAttribute('data-stok');
            stokDisplay.textContent = stok ? `Stok Tersisa: ${stok}` : '';
        }
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.querySelector('input[name="tggl_pinjam"]');
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        });


    </script>
 <div class="container-fluid">
     <h1 class="h3 mb-4 text-gray-800">Create Pinjam Alat</h1>
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <h6 class="m-0 font-weight-bold text-primary"></h6>
         </div>
         <div class="card-body">
             <div class="table-responsive">
                 <form action="{{ route('simpan-pinjam') }}" method="POST">
                     @csrf


                     <div class="form-group">
                         <label for="nama">Nama</label>
                         <input type="text" name="nama" class="form-control" required>
                     </div>
                     <div class="form-group">
                         <label for="nim">Nim</label>
                         <input type="text" name="nim" maxlength="12" class="form-control" required>
                     </div>
                     <div class="form-group">
                         <label for="prodi">Prodi</label>
                         <select name="prodi" class="form-control" required>
                             <option value="">Pilih Prodi</option>
                             <option value="TRPL">TRPL</option>
                             <option value="Bisnis Digital">Bisnis Digital</option>
                             <option value="MANAJEMEN Bisnis Pariwisata">Manajemen Bisnis Pariwisata</option>
                             <option value="Teknik Sipil">Teknik Sipil</option>
                             <option value="Teknik Mesin">Teknik Mesin</option>
                             <option value="TPHT">TPHT </option>
                             <option value="Agribisnis">Agribisnis</option>
                             <option value="TMK">TMK</option>
                         </select>
                     </div>
                     <div class="form-group">
                         <label for="nama_barang">Nama Alat</label>
                         <select wire:model="selectedAlat" name="nama_barang" class="form-control" onchange="updateStok()">
                             <option value="">-- Select Alat --</option>
                             @foreach ($alat as $item)
                             <option value="{{ $item->nama_barang }}" data-stok="{{ $item->stok }}">
                                 {{ $item->nama_barang }}
                                 </option>
                                 @endforeach
                                 </select>   
                                 </div>
                                <div id="stokDisplay" class="mt-2"></div>

                     <div class="form-group">
                         <label for="jml_barang">Jumlah Barang</label>
                         <input type="number" name="jml_barang" class="form-control" required>
                     </div>
             </div>


             <div class="form-group">
                 <label for="tggl_pinjam">Tanggal Pinjam</label>
                 <input type="date" name="tggl_pinjam" class="form-control" required>
             </div>
             <button type="button" class="btn btn-danger" onclick="history.back()">Batal</button>
             <button type="submit" class="btn btn-primary">Submit</button>
             </form>
         </div>
     </div>
 </div>
 @include('sweetalert::alert')
 @endsection