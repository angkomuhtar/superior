@extends('metronic-layout.default')
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <a href="{{route('dashboard.soal')}}" class="btn btn-white"><span class="fa fa-chevron-left"></span></a>
                <h3 class="card-label">{{optional($kelompok_soal)->id ? 'Edit' : 'Tambah'}} Kelompok Soal</h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{optional($kelompok_soal)->id ? route('dashboard.soal.edit',$kelompok_soal) : route('dashboard.soal.add')}}" method="post">
                @csrf
                <div class="form-group fv-plugins-icon-container">
                    <label>Nama Kelompok Soal</label>
                    <input type="text" class="form-control form-control-solid form-control-lg" name="nama_kelompok_soal" placeholder="Nama Kelompok Soal" value="{{optional($kelompok_soal)->nama_kelompok_soal}}" required>
                    <span class="form-text text-muted"></span>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection
