@extends('metronic-layout.app')
@section('content')
    <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
        <!--begin::Content body-->
        <div class="d-flex flex-column-fluid flex-center">
            <!--begin::Signin-->
            <div class="login-form login-signin">
                <!--begin::Form-->
                <form class="form" action="{{url('mulai-tes')}}" method="post" novalidate="" id="">
                @csrf
                <!--begin::Title-->
                    <div class="pb-13 pt-lg-0 pt-5">
                        <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Berhasil Daftar</h3>
                        <span class="text-muted font-weight-bold font-size-h4">
									<a href="javascript:;" id="kt_login_signup" class="text-primary font-weight-bolder"></a></span>
                    </div>
                    <!--begin::Title-->
                    <!--begin::Form group-->
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Nama Peserta</label>
                        <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="text" value="{{$peserta->nama_peserta}}" readonly/>
                    </div>
                    <!--end::Form group-->
                    <!--begin::Form group-->
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-n5">
                            <label class="font-size-h6 font-weight-bolder text-dark pt-5">Nama Tes</label>
                        </div>
                        <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="text" value="{{$peserta->tes->nama_tes}}" readonly/>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-n5">
                            <label class="font-size-h6 font-weight-bolder text-dark pt-5">Jumlah Kolom</label>
                        </div>
                        <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="text" value="{{$peserta->tes->kelompokSoal->kolom->count()}}" readonly/>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-n5">
                            <label class="font-size-h6 font-weight-bolder text-dark pt-5">Waktu Per Kolom</label>
                        </div>
                        <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="text" value="{{$peserta->tes->batas_waktu}} Menit" readonly/>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-n5">
                            <label class="font-size-h6 font-weight-bolder text-dark pt-5">Batas Waktu Ujian</label>
                        </div>
                        <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="text" value="{{$peserta->tes->batas_waktu * $peserta->tes->kelompokSoal->kolom->count()}} Menit" readonly/>
                    </div>
                    <!--end::Form group-->
                    <!--begin::Action-->
                    <div class="pb-lg-0 pb-5">
                        <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Mulai Ujian</button>
                        <a href="javascript:void(0)" class="btn btn-warning font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3" id="batal-ujian">Keluar</a>
                    </div>
                    <!--end::Action-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Signin-->
            <!--begin::Signup-->
            <!--end::Forgot-->
        </div>
        <!--end::Content body-->
        <!--begin::Content footer-->
        <!--end::Content footer-->
    </div>
@endsection
@push('script')
    <script>
            $('#batal-ujian').click(function () {
                if (confirm('Yakin Ingin Keluar !!')) {
                    $.post('{{route('batal-ujian')}}', {_token: '{{csrf_token()}}'})
                        .then(function () {
                            location.reload()
                        })
                }
            })
    </script>
@endpush
