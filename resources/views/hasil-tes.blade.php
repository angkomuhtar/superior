@extends('metronic-layout.app')
@section('content')
    <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
        <!--begin::Content body-->
        <div class="d-flex flex-column-fluid flex-center">
            <!--begin::Signin-->
            <div class="login-form login-signin">
                <!--begin::Form-->
                <div class="pb-13 pt-lg-0 pt-5">
                    <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">{{$peserta->nama_peserta}}</h3>
                    <hr>
                    @php
                    $total = 0;
                    $soal = 0;
                    @endphp
                    @foreach ($hasil AS $key => $value)
                    <h5 class="text-dark font-size-h5 font-size-h2-lg">Kolom {{$key}} ({{$value['soal']}} Soal) : {{$value['benar']}} Benar</h5>
                        @php
                        $total += $value['benar'];
                        $soal += $value['soal'];
                        @endphp
                    @endforeach
                    <hr>
                    <h5 class="text-dark font-size-h5 font-size-h2-lg">Nilai Akhir ({{$soal}} Soal) : {{$total}} Benar</h5>
                </div>
                <div class="pb-lg-0 pb-5">
                    <form action="{{url('clear-data')}}" method="post">
                        @csrf
                        <button type="submit" id="kt_login_signin_submit" class="btn btn-success font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Selesai</button>
                    </form>
                </div>
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
        $.get('{{url('get-tes')}}')
            .then(function (res) {
                if (res.data) {
                    window.location.href = '{{url('tes')}}'
                }
            })
    </script>
@endpush
