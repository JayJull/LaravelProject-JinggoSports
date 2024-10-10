@extends('master.main')
@section('title', 'Anggota')
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800 mb-4">Tabel Anggota</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            {{-- <div class="card-header py-3">
                <a href="#" class="btn btn-primary btn-sm ml-auto"><i class="fas fa-plus"></i>
                    Tambah</a>
            </div> --}}
            <div class="card-header py-3">

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

                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($dtAnggota as $item)
                                @if ($item->status == 'terima')
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->nim }}</td>
                                        <td>{{ $item->prodi }}</td>
                                        <td>{{ $item->divisi_1 }}</td>
                                        <td>
                                            @if ($item->divisi_2)
                                                {{ $item->divisi_2 }}
                                            @else
                                                tidak memilih
                                            @endif
                                        </td>


                                        <td class="text-center" style="width: 9%;">
                                        @php $id = Crypt::encrypt($item->id); @endphp
                                            <a href="{{ route('detail-pengurus', $id) }}"
                                                class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Detail</a>

                                        </td>
                                    </tr>
                                @endif
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
