<h1>Blogs</h1>
<a href="{{ route('blogs.create') }}">+ Add New Blog</a>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<ul>
@foreach($blogs as $blog)
    <li>
        <a href="{{ route('blogs.show', $blog->id) }}">{{ $blog->title }}</a>
        <a href="{{ route('blogs.edit', $blog->id) }}">Edit</a>
        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </li>
@endforeach
</ul>
