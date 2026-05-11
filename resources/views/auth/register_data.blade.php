@extends('layouts.guest')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-base-200">
    <div class="card w-full max-w-xl bg-base-100 shadow-xl p-6">
        <h2 class="text-2xl font-bold text-center mb-4">Lengkapi Data Wali Murid</h2>

        @if(session('error'))
            <div class="alert alert-error mb-4">
                <div>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <form action="{{ route('register.data.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="form-control w-full">
                <label class="label" for="phone">
                    <span class="label-text">Nomor WhatsApp</span>
                </label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $phone ?? '') }}" class="input input-bordered w-full" readonly>
                @error('phone') <span class="text-sm text-error">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label" for="nik">
                        <span class="label-text">NIK</span>
                    </label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik') }}" class="input input-bordered w-full">
                    @error('nik') <span class="text-sm text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label class="label" for="nama">
                        <span class="label-text">Nama Lengkap</span>
                    </label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="input input-bordered w-full">
                    @error('nama') <span class="text-sm text-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-control w-full">
                <label class="label" for="alamat">
                    <span class="label-text">Alamat</span>
                </label>
                <textarea id="alamat" name="alamat" class="textarea textarea-bordered w-full" rows="3">{{ old('alamat') }}</textarea>
                @error('alamat') <span class="text-sm text-error">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label" for="provinsi">
                        <span class="label-text">Provinsi</span>
                    </label>
                    <input type="text" id="provinsi" name="provinsi" value="{{ old('provinsi') }}" class="input input-bordered w-full">
                    @error('provinsi') <span class="text-sm text-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label" for="kabupaten">
                        <span class="label-text">Kabupaten/Kota</span>
                    </label>
                    <input type="text" id="kabupaten" name="kabupaten" value="{{ old('kabupaten') }}" class="input input-bordered w-full">
                    @error('kabupaten') <span class="text-sm text-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label" for="kecamatan">
                        <span class="label-text">Kecamatan</span>
                    </label>
                    <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" class="input input-bordered w-full">
                    @error('kecamatan') <span class="text-sm text-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label" for="kelurahan">
                        <span class="label-text">Kelurahan</span>
                    </label>
                    <input type="text" id="kelurahan" name="kelurahan" value="{{ old('kelurahan') }}" class="input input-bordered w-full">
                    @error('kelurahan') <span class="text-sm text-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label" for="jenis_kelamin">
                        <span class="label-text">Jenis Kelamin</span>
                    </label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="select select-bordered w-full">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <span class="text-sm text-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label" for="agama">
                        <span class="label-text">Agama</span>
                    </label>
                    <input type="text" id="agama" name="agama" value="{{ old('agama') }}" class="input input-bordered w-full">
                    @error('agama') <span class="text-sm text-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label" for="pendidikan">
                        <span class="label-text">Pendidikan Terakhir</span>
                    </label>
                    <input type="text" id="pendidikan" name="pendidikan" value="{{ old('pendidikan') }}" class="input input-bordered w-full">
                    @error('pendidikan') <span class="text-sm text-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label" for="pekerjaan">
                        <span class="label-text">Pekerjaan</span>
                    </label>
                    <input type="text" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" class="input input-bordered w-full">
                    @error('pekerjaan') <span class="text-sm text-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-between items-center gap-3">
                <a href="{{ route('register') }}" class="btn btn-ghost">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
