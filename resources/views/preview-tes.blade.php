@extends('metronic-layout.app')
@section('content')
    <style>
        #pertanyaan {
            letter-spacing: 30px;
        }
    </style>
    <div
    class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
    <!--begin::Content body-->
    <div class="d-flex flex-column-fluid flex-center">
        <!--begin::Signin-->
        <div class="login-form login-signin">
            <!--begin::Form-->
            <div class="form" novalidate="" id="">
                <!--begin::Title-->
                <div class="pb-13 pt-lg-0 pt-5">
                    <h1 class="text-center" style="font-size: xxx-large">
                        <label id="minutes">00</label>
                        <label id="colon">:</label>
                        <label id="seconds">00</label>
                    </h1>
                    <h2 class="text-center" id="kolom">

                    </h2>
                    <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg text-center">
                        <table class="table table-borderless">
                            <tr id="soal">
                                @php
                                 $n = 'a';
                                @endphp
                                @foreach($soal_array AS $i)
                                    <td>{{$i}}</td>
                                @endforeach
                            </tr>
                            <tr style="font-size: smaller; font-weight: lighter">
                                @for($x=0;$x<count($soal_array);$x++)
                                    <td>{{$n++}}</td>
                                @endfor
                            </tr>
                        </table>
                    </h3>
                    <span class="text-muted font-weight-bold font-size-h4">

                            </span>
                </div>
                <!--begin::Title-->
                <!--begin::Form group-->
                <h1 id="pertanyaan" class="text-center">{{$soal}}</h1>
                <table class="table text-center">
                    <tr id="item-jawaban">
                        <td>
                            <h5>Preview Soal</h5>
                        </td>
                    </tr>
                </table>
                <!--end::Action-->
            </div>
            <!--end::Form-->
        </div>
        <!--end::Signin-->
        <!--begin::Signup-->
        <!--end::Signup-->
        <!--begin::Forgot-->
        <!--end::Forgot-->
    </div>
    <!--end::Content body-->
    <!--begin::Content footer-->
    <!--end::Content footer-->
</div>
@endsection
@push('script')

@endpush
