@extends('metronic-layout.default')
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Pengaturan Aplikasi</h3>
            </div>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{Session::get('success')}}</strong>
            </div>
            @endif
            <form action="{{route('dashboard.setting')}}" method="post">
                @csrf
                <div class="form-group fv-plugins-icon-container">
                    <label>Kode Aktivasi</label>
                    <input type="text" class="form-control form-control-solid form-control-lg" name="kode_aktivasi" placeholder="Input Kode Aktivasi" value="{{optional($setting->where('parameter','kode_aktivasi')->first())->value}}" required>
                    <span class="form-text text-muted"></span>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection
