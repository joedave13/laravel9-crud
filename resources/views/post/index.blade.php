@extends('layouts.app', ['title' => 'Post List'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                <a href="{{ route('post.create') }}" class="btn btn-success mb-3">
                    <i class="fas fa-plus"></i>&nbsp;Tambah Post
                </a>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Gambar</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Content</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                        <tr>
                            <td class="text-center">
                                <img src="{{ Storage::url('post/' . $post->image) }}" class="rounded" width="150px;"
                                    alt="Post Image">
                            </td>
                            <td style="width: 30%;">{{ $post->title }}</td>
                            <td style="width: 30%;">{!! $post->content !!}</td>
                            <td class="text-center">
                                <form action="{{ route('post.destroy', $post->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah anda yakin?')" class="inline-block">
                                    <button type="button" class="btn btn-sm btn-info" data-id="{{ $post->id }}"
                                        onclick="showDetailPost(this)">
                                        <i class="fa fa-circle-info"></i>
                                    </button>
                                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="alert alert-danger">
                                    Post belum tersedia.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@include('post.show')
@endsection

@push('scripts')
<script>
    function showDetailPost(_this) {
        let id = $(_this).data('id');
        let url = "{{ url('post') }}" + '/' + id;
        
        if (id) {
            $.ajax({
                'url': url,
                'type': 'GET',
                'dataType': 'json',
                'success': function (res) {
                    let post = res.post;
                    let imageUrl = "{{ url('storage/post') }}" + '/' + post.image;
                    $('#showPostModal').modal('show');
                    $('#postTitleModal').empty().append(post.title);
                    $('#postImageModal').attr('src', imageUrl);
                    $('#postCreatedAtModal').empty().append(post.created_at);
                    $('#postContentModal').empty().append(post.content);
                }
            });
        }
    }
</script>
@endpush