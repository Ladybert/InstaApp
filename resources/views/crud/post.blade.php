<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post</title>
</head>
<body class="bg-gray-900">
    <div class="bg-gray-800 flex items-center">
        <h2 class="text-slate-100 text-2xl font-semibold mx-4 my-2">
            InstaApp
        </h2>
    </div>
    <div class="flex justify-center items-center w-2/3 mx-auto my-6 bg-gray-600">
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="user_id" value="{{Auth::user()->id}}" style="display: none;">
            <img id="preview" src="#" alt="Preview" class="hidden max-w-[200px] max-h-[200px]">
            <input type="file" id="image" name="image" accept="image/*">
            <textarea name="text" class="textarea textarea-warning textarea-lg my-2" placeholder="Type Here..."></textarea>
            <input type="submit" value="Post"/>
        </form>
    </div>
    <script>
        document.getElementById('image').onchange = function (event) {
            let reader = new FileReader();
            
            reader.onload = function(){
                let output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
</body>
</html>