@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Postingan Wali (Forum)</h2>

    <div class="row">
        @foreach($forums as $post)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white d-flex align-items-center">
                    <div class="avatar bg-primary text-white rounded-circle me-2 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                        {{ substr($post->user->name ?? 'User', 0, 1) }}
                    </div>
                    <div>
                        <strong class="d-block">{{ $post->user->name ?? 'Unknown User' }}</strong>
                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                </div>

                @if($post->image)
                <img src="{{ asset('storage/'.$post->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Post Image">
                @endif
                
                <div class="card-body">
                    <p class="card-text">{{ Str::limit($post->deskripsi, 100) }}</p>
                </div>

                <div class="card-footer bg-light d-flex justify-content-between">
                    <span class="text-danger"><i class="fas fa-heart"></i> {{ $post->likes_count }} Likes</span>
                    <span class="text-primary"><i class="fas fa-comment"></i> {{ $post->comments_count }} Comments</span>
                </div>
                
                <div class="card-footer bg-white text-center">
                    <button class="btn btn-sm btn-outline-danger w-100">
                        <i class="fas fa-trash"></i> Hapus Postingan
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $forums->links() }}
    </div>
</div>
@endsection