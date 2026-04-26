@extends('layouts.app')

@section('title', 'Edit Jabatan')
@section('page-title', 'Edit Jabatan')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-pencil me-2"></i>Form Edit Jabatan
    </div>
    <div class="card-body">
        <form action="{{ route('jabatan.update', $jabatan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Kode <span class="text-danger">*</span></label>
                        <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $jabatan->kode) }}" required>
                        @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $jabatan->nama) }}" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Eselon</label>
                        <select name="eselon" class="form-select @error('eselon') is-invalid @enderror">
                            <option value="">- Non Eselon -</option>
                            @foreach($eselonOptions as $eselon)
                            <option value="{{ $eselon }}" {{ old('eselon', $jabatan->eselon) == $eselon ? 'selected' : '' }}>{{ $eselon }}</option>
                            @endforeach
                        </select>
                        @error('eselon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tunjangan</label>
                        <input type="number" name="tunjangan" class="form-control @error('tunjangan') is-invalid @enderror" value="{{ old('tunjangan', $jabatan->tunjangan) }}">
                        @error('tunjangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $jabatan->keterangan) }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Update
                </button>
                <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
