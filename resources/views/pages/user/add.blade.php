@extends('metronic-layout.default')
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <a href="{{route('dashboard.user')}}" class="btn btn-white"><span class="fa fa-chevron-left"></span></a>
                <h3 class="card-label">{{optional($user)->id ? 'Edit' : 'Tambah'}} User</h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{optional($user)->id ? route('dashboard.user.edit',$user) : route('dashboard.user.add')}}" method="post">
                @csrf
                <div class="form-group fv-plugins-icon-container">
                    <label>Nama</label>
                    <input type="text" class="form-control form-control-solid form-control-lg" name="name"
                           placeholder="Nama User" value="{{old('name') ?? optional($user)->name}}" required>
                    @if ($errors->has('name'))
                        @foreach($errors->get('name') AS $er)
                            <span class="form-text text-muted">{{$er}}</span>
                        @endforeach
                    @endif
                </div>
                <div class="form-group fv-plugins-icon-container">
                    <label>Email</label>
                    <input type="email" class="form-control form-control-solid form-control-lg" name="email"
                           placeholder="Email User" value="{{old('email') ?? optional($user)->email}}" required>
                    @if ($errors->has('email'))
                        @foreach($errors->get('email') AS $er)
                            <span class="form-text text-muted">{{$er}}</span>
                        @endforeach
                    @endif
                </div>
                <div class="form-group fv-plugins-icon-container">
                    <label>Passoword</label>
                    <input type="password" class="form-control form-control-solid form-control-lg" name="password"
                           placeholder="Password" {{optional($user)->id ? '' : 'required'}}>
                    @if ($errors->has('password'))
                        @foreach($errors->get('password') AS $er)
                            <span class="form-text text-muted">{{$er}}</span>
                        @endforeach
                    @endif
                </div>
                <div class="form-group fv-plugins-icon-container">
                    <label>Konfirmasi Passoword</label>
                    <input type="password" class="form-control form-control-solid form-control-lg" name="password_confirmation"
                           placeholder="Konfirmasi Password" {{optional($user)->id ? '' : 'required'}}>
                    <span class="form-text text-muted"></span>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection
