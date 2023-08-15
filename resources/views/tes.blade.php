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
        <div class="d-flex flex-center text-right">
            <!--begin::Signin-->
            <div class="login-form login-signin">
                <form id="form-selesai" action="{{url('selesai')}}" method="post">
                    @csrf
                    <button class="btn btn-danger" id="btn-selesai">Selesai</button>
                </form>
            </div>
        </div>
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
                                    <td>A</td>
                                    <td>B</td>
                                    <td>C</td>
                                    <td>D</td>
                                    <td>E</td>
                                </tr>
                                <tr style="font-size: smaller; font-weight: lighter">
                                    <td>a</td>
                                    <td>b</td>
                                    <td>c</td>
                                    <td>d</td>
                                    <td>e</td>
                                </tr>
                            </table>
                        </h3>
                        <span class="text-muted font-weight-bold font-size-h4">

                            </span>
                    </div>
                    <!--begin::Title-->
                    <!--begin::Form group-->
                    <h1 id="pertanyaan" class="text-center"></h1>
                    <table class="table text-center">
                        <tr id="item-jawaban">
                            <td>
                                <form action="" class="submit-answer">
                                    @csrf
                                    <input type="hidden" value="" name="id_pertanyaan">
                                    <input id="pilihan_0" type="hidden" value="" name="jawaban">
                                    <button type="submit" class="btn btn-primary">a</button>
                                </form>
                            </td>
                            <td>
                                <form action="" class="submit-answer">
                                    @csrf
                                    <input type="hidden" value="" name="id_pertanyaan">
                                    <input id="pilihan_1" type="hidden" value="" name="jawaban">
                                    <button type="submit" class="btn btn-primary">b</button>
                                </form>
                            </td>
                            <td>
                                <form action="" class="submit-answer">
                                    @csrf
                                    <input type="hidden" value="" name="id_pertanyaan">
                                    <input id="pilihan_2" type="hidden" value="" name="jawaban">
                                    <button type="submit" class="btn btn-primary">c</button>
                                </form>
                            </td>
                            <td>
                                <form action="" class="submit-answer">
                                    @csrf
                                    <input type="hidden" value="" name="id_pertanyaan">
                                    <input id="pilihan_3" type="hidden" value="" name="jawaban">
                                    <button type="submit" class="btn btn-primary">d</button>
                                </form>
                            </td>
                            <td>
                                <form action="" class="submit-answer">
                                    @csrf
                                    <input type="hidden" value="" name="id_pertanyaan">
                                    <input id="pilihan_4" type="hidden" value="" name="jawaban">
                                    <button type="submit" class="btn btn-primary">e</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                    <!--end::Action-->
                </div>
                <!--end::Form-->
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        var do_get_test = false;
        var soal_lama = '';

        function getTes() {
            if (!do_get_test) {
                do_get_test = true;
                $.get('{{url('get-tes')}}')
                    .then(function (res) {
                        if (res) {
                            var waktu_sekarang = new Date(res.waktu_sekarang);
                            var waktu_mulai = new Date(res.waktu_mulai);
                            var waktu_selesai = new Date(res.waktu_selesai);
                            if ((waktu_selesai.getTime() - waktu_sekarang.getTime()) <= 0) {
                                window.location.href = '{{url('hasil-tes')}}'
                            }
                            totalSeconds = (waktu_sekarang.getTime() - waktu_mulai.getTime()) / 1000;
                            if (res.data) {
                                var pilihan = res.data.pilihan.map(function (val, i) {
                                    $('#pilihan_' + i).val(val);
                                    return '<td>' + val + '</td>'
                                })
                                if (res.data.soal_jawaban.length) {
                                    $('[name=id_pertanyaan]').val(res.data.soal_jawaban[0].id)
                                    $('#item-jawaban').show();
                                    if (res.data.soal_jawaban[0].id != soal_lama) {
                                        $('#pertanyaan').html(res.data.soal_jawaban[0].soal_shuffle)
                                        soal_lama = res.data.soal_jawaban[0].id;
                                    }
                                } else {
                                    $('#item-jawaban').hide();
                                    $('#pertanyaan').html('')
                                }
                                $('#kolom').html('Kolom ' + res.data.kolom)
                                $('#soal').html(pilihan);
                            } else {
                                $('#item-jawaban').hide();
                                $('#soal').html('')
                                $('#pertanyaan').html('')
                                $('#kolom').html('')
                            }
                        } else {
                            window.location.href = '{{url('hasil-tes')}}'
                        }
                        do_get_test = false;
                    })
            }
        }

        getTes()
        var submit_jawaban = false;
        $('.submit-answer').on('submit', function (e) {
            e.preventDefault();
            if (!submit_jawaban) {
                submit_jawaban = true;
                $('#item-jawaban').hide();
                $.post('{{url('submit-jawaban')}}', $(this).serialize())
                    .then(function () {
                        do_get_test = false;
                        getTes();
                        submit_jawaban = false;
                    })
            }
        })
        setInterval(function () {
            getTes()
        }, 1000);
        $('#btn-selesai').on('click',function (e){
            e.preventDefault();
            if (confirm('Ingin Mengakhiri Ujian ?')){
                $('#form-selesai').submit();
            }
        })
    </script>
    <script type="text/javascript">
        var minutesLabel = document.getElementById("minutes");
        var secondsLabel = document.getElementById("seconds");
        var totalSeconds = 0;
        setInterval(setTime, 1000);

        function setTime() {
            ++totalSeconds;
            secondsLabel.innerHTML = pad(totalSeconds % 60);
            minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
        }

        function pad(val) {
            var valString = val + "";
            if (valString.length < 2) {
                return "0" + valString;
            } else {
                return valString;
            }
        }
    </script>
@endpush
