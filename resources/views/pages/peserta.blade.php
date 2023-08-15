@extends('metronic-layout.default')
@section('content')
    <div class="container">

        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Peserta
                    </h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    <!--end::Dropdown-->
                    <!--begin::Button-->
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-bordered table-checkable" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Nomor Telepon</th>
                        <th>Waktu Ujian</th>
                        <th>Kelompok Soal</th>
                        <th>Hasil</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($peserta AS $item)
                        <tr>
                            <td>{{$item->nama_peserta}}</td>
                            <td>{{$item->no_telp}}</td>
                            <td>{{$item->waktu_mulai_tes}}</td>
                            <td>{{$item->nama_tes}}</td>
                            <td>
                                @php
                                $benar = 0;
                                $soal = 0;
                                @endphp
                                @foreach ($item->hasil AS $key => $value)
                                    kolom {{$key}} {{isset($value['soal']) ? "(".$value['soal']." Soal)" : ''}} : {{method_exists($value,'count') ? $value->count() : $value['benar']}} Benar <hr>
                                    @php
                                    $soal += isset($value['soal']) ? $value['soal'] : 0;
                                    $benar += method_exists($value,'count') ? $value->count() : $value['benar'];
                                    @endphp
                                @endforeach
                                Total {{$soal > 0 ? "($soal Soal)" : ''}}: {{$benar}} Benar
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!--end: Datatable-->
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
@endsection
@push('partial_styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('partial_scripts')
    <script>
        $('#kt_datatable').dataTable();
        $('.btn-delete').on('click',function (e){
            e.preventDefault();
            var id = $(this).data('id');
            if (confirm('Yaking Ingin Menghapus Data ?')){
                $.post('{{url('dashboard/tes')}}/'+id+'/delete',{_token:'{{csrf_token()}}'})
                    .then(function (){
                        location.reload()
                    })
            }
        })
        $('.btn-toggle-aktif').on('click',function (e){
            e.preventDefault();
            var id = $(this).data('id');
            if (confirm('Yaking Ingin Mengubah Status Data ?')){
                $.post('{{url('dashboard/tes')}}/'+id+'/toggle-aktif',{_token:'{{csrf_token()}}'})
                    .then(function (){
                        location.reload()
                    })
            }
        })
    </script>
@endpush
