@extends('metronic-layout.default')
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <a href="{{route('dashboard.tes')}}" class="btn btn-white"><span class="fa fa-chevron-left"></span></a>
                <h3 class="card-label">{{optional($tes)->id ? 'Edit' : 'Tambah'}} Tes</h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{optional($tes)->id ? route('dashboard.tes.edit',$tes) : route('dashboard.tes.add')}}" method="post">
                @csrf
                <input type="hidden" name="aktif" value="1">
                <div class="form-group fv-plugins-icon-container">
                    <label>Nama Tes</label>
                    <input type="text" class="form-control form-control-solid form-control-lg" name="nama_tes"
                           placeholder="Nama Tes" value="{{old('nama_tes') ?? optional($tes)->nama_tes}}" required>
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group fv-plugins-icon-container">
                    <label>Secret key</label>
                    <input type="text" class="form-control form-control-solid form-control-lg" name="secret_key"
                           placeholder="Secret Key" value="{{old('secret_key') ?? optional($tes)->secret_key}}" required>
                    @if ($errors->has('secret_key'))
                        @foreach($errors->get('secret_key') AS $er)
                            <span class="form-text text-muted">{{$er}}</span>
                        @endforeach
                    @endif
                    <div class="form-group fv-plugins-icon-container">
                    <label>Waktu Tiap Kolom (menit)</label>
                    <input type="number" min="1" class="form-control form-control-solid form-control-lg" name="batas_waktu"
                           placeholder="Batas Waktu" value="{{old('batas_waktu') ?? optional($tes)->batas_waktu}}" step="1" required>
                    <span class="form-text text-muted"></span></div>
                <div class="form-group fv-plugins-icon-container">
                    <label>Kelompok Soal</label>
                    <select name="id_kelompok_soal" class="form-control form-control-solid form-control-lg" id="" required>
                        <option value="" selected disabled>Pilih Kelompok Soal</option>
                        @foreach ($kelompok_soal AS $item)
                            <option value="{{$item->id}}" {{old('id_kelompok_soal') ? (old('id_kelompok_soal') == $item->id ? 'selected' : '') :  (optional($tes)->id_kelompok_soal === $item->id ? 'selected' : '')}}>{{$item->nama_kelompok_soal}}</option>
                        @endforeach
                    </select>
                    <span class="form-text text-muted"></span>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection
