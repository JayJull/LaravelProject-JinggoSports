@extends('master.main')
@section('title', 'Presensi')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 mb-4">Presensi Sekarang</h1>

    <div class="row">

        <!-- TABEL -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <!-- Optional header -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jadwal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($pendaftar->divisi_1)
                                <tr>
                                    <td>1</td>
                                    <td>{{ $pendaftar->divisi_1 }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($jadwalDivisi1 as $jadwal)
                                            <li>{{ $jadwal->hari }}: {{ $jadwal->waktu_mulai }} -
                                                {{ $jadwal->waktu_selesai }}
                                            </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        @if ($statusPresensi1 == 'sudah presensi')
                                        <span class="badge badge-success" style="padding: 4px 10px;"> Sudah Presensi
                                    </span>
                                        @else
                                        <span class="badge badge-danger" style="padding: 4px 14px;"> Belum Presensi
                                            </span>
                                        @endif
                                        
                                    </td>
                                </tr>
                                @endif
                                @if ($pendaftar->divisi_2)
                                <tr>
                                    <td>2</td>
                                    <td>{{ $pendaftar->divisi_2 }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($jadwalDivisi2 as $jadwal)
                                            <li>{{ $jadwal->hari }}: {{ $jadwal->waktu_mulai }} -
                                                {{ $jadwal->waktu_selesai }}
                                            </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                    @if ($statusPresensi2 == 'sudah presensi')
                                    <span class="badge badge-success" style="padding: 4px 10px;"> Sudah Presensi
                                    </span>
                                        @else
                                        <span class="badge badge-danger" style="padding: 4px 14px;"> Belum Presensi
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endif


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                @if (Auth::user()->gambar !== null)
                <div class="card-profile-image mt-4 d-flex justify-content-center">
                    <a>
                        <img class="img-profile rounded-circle" src="{{ asset('storage/foto/' . Auth::user()->gambar) }}" width="160" height="160">
                    </a>
                </div>
                @else
                <div class="card-profile-image mt-4 d-flex justify-content-center">
                    <a>
                        <img class="img-profile rounded-circle" src="{{ asset('template/img/undraw_profile.svg') }}" width="160" height="160">
                    </a>
                </div>
                @endif

                <div class="card-body">
                    <form action="{{ route('store-presensi') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center">
                                    <h5 class="font-weight-bold">{{ Auth::user()->name }}</h5>
                                    <p class="font-weight">{{ Auth::user()->role }}</p>

                                    <select name="divisi" id="divisi" class="form-control">
                                        @if ($pendaftar->divisi_1 && $dtDivisi->where('nama', $pendaftar->divisi_1)->first()->aktifasi)
                                            <option value="{{ $pendaftar->divisi_1 }}">{{ $pendaftar->divisi_1 }}</option>
                                        @endif
                                        @if ($pendaftar->divisi_2 && $dtDivisi->where('nama', $pendaftar->divisi_2)->first()->aktifasi)
                                            <option value="{{ $pendaftar->divisi_2 }}">{{ $pendaftar->divisi_2 }}</option>
                                        @endif
                                    </select>
                                    <br>
                                    <div class="mb-3">
                                        <input type="file" id="bukti" name="bukti" style="opacity:0; display:none" class="btn btn-primary">
                                        <label for="bukti" class="btn btn-primary btn-block">Upload bukti</label>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-success flex-grow-1">Presensi</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form id="deleteForm" action="{{ route('delete-profile') }}" method="POST">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

{{-- sweet alert --}}
@include('sweetalert::alert')

@endsection
