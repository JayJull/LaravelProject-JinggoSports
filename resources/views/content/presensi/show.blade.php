@extends('home.submain')
@section('title', 'Data Presensi')
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800 mb-4">Data Presensi</h1>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- Optional header -->
            <a href="{{route('cetak-presensi')}}" target="_blank" class="btn btn-success">cetak <i class="fas fa-print"></i></a>

        </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Divisi</th>
                                <th>Tanggal</th>
                                <th>Bukti Kehadiran</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $item)
                                <tr class="data">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="nama">{{ $item->nama_anggota }}</td>
                                    <td class="divisi">{{ $item->nama_divisi }}</td>
                                    <td class="tanggal">{{ $item->tanggal }}</td>


                                    <td>
                                    @if ($item->bukti)
                                <img src="{{ asset('storage/buktiPresensi/' . $item->bukti) }}" alt="Gambar tidak ada" style="max-width: 200px; max-height: 200px;">
                                @else
                                Tidak ada bukti
                                @endif
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
