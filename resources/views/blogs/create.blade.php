<h1>Create Blog</h1>

<form action="{{ route('blogs.store') }}" method="POST">
    @csrf
    <label>Title:</label><br>
    <input type="text" name="title"><br><br>

    <label>Content:</label><br>
    <textarea name="content"></textarea><br><br>

    <button type="submit">Save</button>
</form>
