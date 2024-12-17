@extends('home.submain')
@section('title', 'Pendaftaran')
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="mb-2 mb-4 text-gray-800 h3">Tabel Pendaftaran</h1>

        <!-- DataTales Example -->
        <div class="mb-4 shadow card">
            <div class="py-3 card-header">

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nim</th>
                                <th>Prodi</th>
                                <th>Divisi 1</th>
                                <th>Divisi 2</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($dtPendaftaran as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->nim }}</td>
                                    <td>{{ $item->prodi->nama }}</td>
                                    <td>
                                        @if ($item->divisi->isEmpty())
                                            {{ $item->divisi->first()->nama }}
                                        @else
                                            None
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->divisi->count() > 1)
                                            {{ $item->divisi[1]->nama }}
                                        @else
                                            None
                                        @endif
                                    </td>
                                    <!-- Status pendaftaran -->
                                    <td class="text-center" style="width: 3%;">
                                        @if ($item->status == 'menunggu')
                                            <span class="badge badge-warning">Belum Terverifikasi</span>
                                        @elseif ($item->status == 'diterima')
                                            <span class="badge badge-success">Terima</span>
                                        @elseif ($item->status == 'ditolak')
                                            <span class="badge badge-danger">Tolak</span>
                                        @endif
                                    </td>
                                    <!-- Aksi -->
                                    <td class="text-center" style="width: 9%;">
                                        {{-- @php $id = Crypt::encrypt($item->id); @endphp --}}
                                        <a href="{{ route('admin-pendaftaran-detail', $item->id_anggota) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Detail
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
