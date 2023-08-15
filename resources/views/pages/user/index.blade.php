@extends('metronic-layout.default')
@section('content')
    <div class="container">

        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">User
                    </h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    <!--end::Dropdown-->
                    <!--begin::Button-->
                    <a href="{{route('dashboard.user.add')}}" class="btn btn-primary font-weight-bolder">
											<span class="svg-icon svg-icon-md">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<circle fill="#000000" cx="9" cy="15" r="6" />
														<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
													</g>
												</svg>
                                                <!--end::Svg Icon-->
											</span>Tambah User</a>
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-bordered table-checkable" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($user AS $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>
                                <a href="{{route('dashboard.user.edit',$item)}}" class="btn btn-info"><span class="fa fa-edit"></span> Edit</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-delete" data-id="{{$item->id}}"><span class="flaticon-delete"></span> Hapus</a>
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
                $.post('{{url('dashboard/user')}}/'+id+'/delete',{_token:'{{csrf_token()}}'})
                    .then(function (){
                        location.reload()
                    },function (err){
                        alert('Tidak dapat Menghapus Data, data yang ingin dihapus berkaitan dengan tabel lain')
                    })
            }
        })
    </script>
@endpush
