<h1>Edit Blog</h1>

<form action="{{ route('blogs.update', $blog->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Title:</label><br>
    <input type="text" name="title" value="{{ $blog->title }}"><br><br>

    <label>Content:</label><br>
    <textarea name="content">{{ $blog->content }}</textarea><br><br>

    <button type="submit">Update</button>
</form>
