@extends('metronic-layout.app')
@section('content')
    <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
        <!--begin::Content body-->
        <div class="d-flex flex-column-fluid flex-center">
            <!--begin::Signin-->
            <div class="login-form login-signin">
                <!--begin::Form-->
                <form class="form" action="{{url('daftar-peserta')}}" method="post" novalidate="" id="">
                @csrf
                <!--begin::Title-->
                    <div class="pb-13 pt-lg-0 pt-5">
                        <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Daftar Peserta</h3>
                        <span class="text-muted font-weight-bold font-size-h4">
									<a href="javascript:;" id="kt_login_signup" class="text-primary font-weight-bolder"></a></span>
                    </div>
                    <!--begin::Title-->
                    <!--begin::Form group-->
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Nama Peserta</label>
                        <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="text" name="nama_peserta" autocomplete="off" required/>
                    </div>
                    <!--end::Form group-->
                    <!--begin::Form group-->
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-n5">
                            <label class="font-size-h6 font-weight-bolder text-dark pt-5">Nomor Telepon</label>
                        </div>
                        <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="text" name="no_telp" autocomplete="off" required/>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-n5">
                            <label class="font-size-h6 font-weight-bolder text-dark pt-5">Kode Ujian</label>
                        </div>
                        <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="text" name="secret_key" autocomplete="off" required/>
                    </div>
                    <!--end::Form group-->
                    <!--begin::Action-->
                    <div class="pb-lg-0 pb-5">
                        <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Daftar Ujian</button>
                        <a href="javascript:void(0)" class="btn btn-warning font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3" id="revoke-aktivas">Keluar</a>
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
            $('#revoke-aktivas').click(function () {
                if (confirm('Yakin Ingin Keluar !!')) {
                    $.post('{{route('aktivasi.revoke')}}', {_token: '{{csrf_token()}}'})
                        .then(function () {
                            location.reload()
                        })
                }
            })
    </script>
@endpush
