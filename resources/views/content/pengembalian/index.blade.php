@extends('home.submain')
@section('title', 'Alat')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 mb-4">Tabel Pengembalian Alat</h1>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow-x: auto;">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Barang</th>
                            <th>Jumlah Barang</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Gambar</th>
                            <th>Petugas</th>
                        
                            <th>Aksi</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($dtpengembalian as $data)
                        <td>{{ $loop->iteration }}</td>

                        <td>{{$data->peminjaman->anggota->nama}}</td>
                        <td>{{$data->peminjaman->anggota->prodi->nama}}</td>
                        <td>{{$data->peminjaman->alat->nama_alat}}</td>
                        <td>{{$data->peminjaman->jml_alat}}</td>
                        <td>{{ date('d-m-Y', strtotime ($data->tggl_pinjam)) }}</td>
                        <td>{{ date('d-m-Y', strtotime ($data->tggl_kembali)) }}</td>
                        <!-- <td>{{ $data->deskripsi }}</td> -->
                        <td>
                            @if ($data->image)
                            @php
                            $imagePath = asset('storage/images/pengembalian/' . $data->image);
                           //  dd($imagePath, $data->image);
                            @endphp
                            <img src="{{ $imagePath }}" alt="Gambar tidak ada" style="max-width: 200px; max-height: 200px;">
                            @else
                            gambar tidak ada
                            @endif
                        </td>
                        <td>{{ $data->petugas ? $data->petugas->name : 'N/A' }}</td>
                        <td class="text-center" style="width: 9%;">
                            <form onsubmit="return confirm('Apakah Anda Yakin Menghapus?');" action="{{ route('delete-pengembalian', $data->id_pengembalian) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</button>
                            </form>
                        </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

{{-- sweet alert --}}
@include('sweetalert::alert')

@endsection