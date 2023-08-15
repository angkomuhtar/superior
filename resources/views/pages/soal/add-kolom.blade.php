@extends('metronic-layout.default')
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <a href="{{route('dashboard.soal.kolom',['id_kelompok' => $kelompok->id])}}" class="btn btn-white"><span class="fa fa-chevron-left"></span></a>
                <h3 class="card-label">{{optional($data_kolom)->id ? 'Edit' : 'Tambah'}} Kolom Soal {{$kelompok->nama_kelompok_soal}}</h3>

            </div>
        </div>
        <div class="card-body">
            <form action="{{optional($data_kolom)->id ? route('dashboard.soal.kolom.edit',['id_kelompok' => $kelompok->id,'id' => $data_kolom->id]) : route('dashboard.soal.kolom.add',['id_kelompok' => $kelompok->id])}}" method="post">
                @csrf
                <div class="form-group">
                    @if (optional($data_kolom)->id)
                        <small>Mengubah Soal Akan Menghapus Semua Jawaban!!</small>
                    @endif
                </div>
                <div class="form-group fv-plugins-icon-container">
                    <label>Kolom</label>
                    <input type="number" min="1" class="form-control form-control-solid form-control-lg" name="kolom" placeholder="Kolom" value="{{optional($data_kolom)->kolom ?? $kolom}}" readonly>
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group fv-plugins-icon-container">
                    <label>Soal</label>
                    <input type="text"  minlength="5" maxlength="5" class="form-control form-control-solid form-control-lg" name="soal" placeholder="Soal" value="{{optional($data_kolom)->soal}}" required >
                    @if ($errors->has('harus_unique'))
                        @foreach($errors->get('harus_unique') AS $er)
                            <span class="form-text text-muted">{{$er}}</span>
                        @endforeach
                    @endif
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection
