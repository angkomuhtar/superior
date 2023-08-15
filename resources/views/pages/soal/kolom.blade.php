@extends('metronic-layout.default')
@section('content')
    <div class="container">

        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <a href="{{route('dashboard.soal')}}" class="btn btn-white"><span class="fa fa-chevron-left"></span></a>
                    <h3 class="card-label">Kolom Soal {{$kelompok_soal->nama_kelompok_soal}}</h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{route('dashboard.soal.kolom.add',['id_kelompok' => $kelompok_soal->id])}}"
                       class="btn btn-primary font-weight-bolder">
											<span class="svg-icon svg-icon-md">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
												<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                     viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24"/>
														<circle fill="#000000" cx="9" cy="15" r="6"/>
														<path
                                                            d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                                            fill="#000000" opacity="0.3"/>
													</g>
												</svg>
                                                <!--end::Svg Icon-->
											</span>Tambah Kolom</a>
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-bordered table-checkable" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Soal</th>
                        <th>Kolom</th>
                        <th>Jumlah Jawaban</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($kelompok_soal->kolom As $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->soal}}</td>
                            <td>Kolom {{$item->kolom}}</td>
                            <td>{{$item->soalJawaban->count()}}</td>
                            <td>
                                <a href="{{route('preview',['soal' => $item->soal])}}" target="_blank" class="btn btn-dark"><span class="fa fa-eye"></span> Preview</a>
                                <a href="{{route('dashboard.soal.kolom.edit',['id_kelompok' => $kelompok_soal->id,'id' => $item->id])}}" class="btn btn-info"><span class="fa fa-edit"></span> Edit</a>
                                <a href="{{route('dashboard.soal.kolom.jawaban',['id_kelompok' => $kelompok_soal->id,'id_kolom' => $item->id])}}"
                                   class="btn btn-primary"><span class="flaticon-list-3"></span> Jawaban</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-delete" data-id="{{$item->id}}" data-id-kelompok="{{$kelompok_soal->id}}"><span class="flaticon-delete"></span> Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!--end: Datatable-->
            </div>
            <div class="card-footer">
                <form action="{{route('dashboard.soal.kolom.import',['id_kelompok' => $kelompok_soal->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if (session()->has('success'))
                        <div class="form-group mb-8">
                            <div class="alert alert-custom alert-success" role="alert">
                                <div class="alert-text">{{session('success')}}</div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <label class="col-6 text-right">
                            <a href="{{asset('template/sample_excel.xlsx')}}" download class="btn btn-success btn-sm"><span class="fa fa-file-excel"></span></a>
                        </label>
                        <div></div>
                        <div class="custom-file col-4">
                            <input name="kolom_soal" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file" class="custom-file-input" id="customFile" required>
                            <label class="custom-file-label" for="customFile">Pilih File Excel</label>
                        </div>
                        <div class="col-2 text-right">
                            <button type="submit" class="btn btn-warning">Import Soal</button>
                        </div>
                    </div>
                </form>
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
            var id_kelompok = $(this).data('id-kelompok');
            if (confirm('Yaking Ingin Menghapus Data ?')){
                $.post('{{url('dashboard/soal')}}/'+id_kelompok+'/kolom/'+id+'/delete',{_token:'{{csrf_token()}}'})
                    .then(function (){
                        location.reload()
                    },function (err){
                        alert('Tidak dapat Menghapus Data, data yang ingin dihapus berkaitan dengan data peserta ujian')
                    })
            }
        })
    </script>
@endpush
