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

<div class="mb-3">
    <label for="category_id" class="form-label">Chuyên mục</label>
    <select id="category_id" name="category_id"
            class="form-select @error('category_id') is-invalid @enderror">
        <option value="">-- Chọn chuyên mục --</option>
        @foreach (\App\Models\Category::orderBy('id')->get() as $category)
            <option value="{{ $category->id }}"
                @selected(old('category_id', $post->category_id ?? request('category')) == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>