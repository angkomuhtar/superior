@extends('metronic-layout.default')
@section('content')
    <!--begin::Notice-->
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <a href="{{url()->previous()}}" class="btn btn-white"><span class="fa fa-chevron-left"></span></a>
                <h3 class="card-label">Tambah Jawaban Kolom {{$kolom->kolom}}</h3>
            </div>
        </div>
        <div class="card-body">
            <form
                action="{{optional($jawabanSoal)->id ? route('dashboard.soal.kolom.jawaban.edit',['id_kelompok' => $kolom->id_kelompok_soal,'id_kolom' => $kolom->id,'id' => $jawabanSoal->id]) : route('dashboard.soal.kolom.jawaban.add',['id_kelompok' => $kolom->id_kelompok_soal,'id_kolom' => $kolom->id])}}"
                method="post">
                @csrf
                <div class="form-group fv-plugins-icon-container">
                    <label>Kolom</label>
                    <input type="number" min="1" class="form-control form-control-solid form-control-lg" name=""
                           placeholder="Kolom" value="{{$kolom->kolom}}" readonly>
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group fv-plugins-icon-container">
                    <label>Soal</label>
                    <input type="text" minlength="5" maxlength="5"
                           class="form-control form-control-solid form-control-lg" name="" placeholder="Soal"
                           value="{{$kolom->soal}}" readonly>
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group">
                    <label>Jawaban</label>
                    <div class="radio-inline" id="jawaban">

                    </div>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection
@push('partial_scripts')
    <script>
        $(document).ready(function (){
            var val = "{{$kolom->soal}}".split('');
            var jawaban = val.map(function (val,i){
                    return '<label class="radio">'+
                '<input type="radio" '+{!! optional($jawabanSoal)->id ? "(val === '".$jawabanSoal->jawaban."' ? 'checked' : '')" : "(i==0 ? 'checked' : '')" !!}+' value="'+val+'" name="jawaban">'+
                    '<span></span>'+val+
            '</label>'
                });
            $('#jawaban').html(jawaban.join(''));
        });
    </script>
@endpush
