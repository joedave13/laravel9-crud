@extends('layouts.app', ['title' => 'Create Post'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold">Gambar</label>
                        <input type="file" class="form-control @error('image')
                            is-invalid
                        @enderror" name="image">

                        @error('image')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Judul</label>
                        <input type="text" class="form-control @error('title')
                            is-invalid
                        @enderror" name="title" value="{{ old('title') ?? '' }}">

                        @error('title')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Konten</label>
                        <textarea class="form-control @error('content')
                            is-invalid
                        @enderror" name="content" rows="5">{{ old('content') ?? '' }}</textarea>

                        @error('content')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;Simpan
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fa fa-arrow-rotate-right"></i>&nbsp;Reset
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('library-scripts')
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
@endpush

@push('scripts')
<script>
    CKEDITOR.replace('content')
</script>
@endpush