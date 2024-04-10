<!DOCTYPE html>
<html lang='ja'>

<head>
    <meta charset='UTF-8'>
    <title>書籍情報</title>
</head>

<body>
    <main>
        @if ($errors->any())
            <div style="color:red">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1>書籍情報</h1>
        <form action='{{ route('books.store') }}' method='POST'>
            @csrf
            <div>
                <label>カテゴリ</label>
                <select name='category_id'>
                    @foreach ($categories as $category)
                        <option value='{{ $category->id }}' @selected($category->id == old('category_id'))>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>タイトル</label>
                <input type='text' name='title' value='{{ old('title') }}'>
            </div>
            <div>
                <label>価格</label>
                <input type='number' min='1' name='price' value='{{ old('price') }}'>
            </div>
            <input type='submit' value='送信'>
        </form>
    </main>
</body>

</html>
