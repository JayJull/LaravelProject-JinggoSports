@extends('home.submain')
@section('title', 'Divisi')
@section('content')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="mb-2 mb-4 text-gray-800 h3">Tabel Divisi</h1>


    <!-- DataTales Example -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            {{-- @role('admin') --}}
            <a href="{{ route('tambahdivisi') }}" class="ml-auto btn btn-primary btn-sm"><i class="fas fa-plus"></i>
                Tambah</a>
            {{-- @endrole --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            {{-- @role('admin') --}}
                            <th>Aksi</th>
                            {{-- @endrole
                            @role('anggota') --}}
                            {{-- <th>anggota</th> --}}
                            {{-- @endrole --}}
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($dtDivisi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>

                            @php $id_divisi = Crypt::encrypt($item->id_divisi); @endphp
                            {{-- @role('anggota') --}}
                            {{-- <td>
                                <a href="{{ route('view-anggota', $id) }}" class="btn btn-primary btn-sm"><i class="fas fa-user-friends"></i> anggota</a>
                            </td> --}}
                            {{-- @endrole --}}

                            </td>
                            {{-- @role('admin') --}}
                            <td class="text-center" style="width: 15%;">

                                <form onsubmit="return confirm('Apakah Anda Yakin Menghapus?');" action="{{ route('hapusdivisi', $item->id_divisi) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    @php $id_divisi = Crypt::encrypt($item->id_divisi); @endphp

                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</button>
                                </form>
                                <a href="{{ route('editdivisi', $id_divisi) }}" {{ $id_divisi }} class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            </td>
                            {{-- @endrole --}}

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
