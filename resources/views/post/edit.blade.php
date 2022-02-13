@extends('layouts.app', ['title' => 'Edit Post'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="font-weight-bold">Gambar</label>
                        <input type="file" class="form-control @error('image')
                            is-invalid
                        @enderror" name="image">
                        <small class="text-muted">Kosongkan bila tidak ingin mengubah gambar.</small>

                        @error('image')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Judul</label>
                        <input type="text" name="title" class="form-control @error('title')
                            is-invalid
                        @enderror" value="{{ old('title') ?? $post->title }}">

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
                        @enderror" name="content" rows="5">{{ old('content') ?? $post->content }}</textarea>

                        @error('content')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-edit"></i>&nbsp;Update
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