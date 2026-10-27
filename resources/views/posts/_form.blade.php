@csrf
<div class="mb-3">
    <label for="title" class="form-label">Tiêu đề</label>
    <input type="text" id="title" name="title"
           class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $post->title ?? '') }}">
    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="content" class="form-label">Nội dung</label>
    <textarea id="content" name="content" rows="10"
              class="form-control @error('content') is-invalid @enderror">{{ old('content', $post->content ?? '') }}</textarea>
    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<button type="submit" class="btn btn-primary">{{ $submit }}</button>
<a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Hủy</a>
