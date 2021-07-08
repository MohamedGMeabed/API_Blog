<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail</title>
</head>
<body>

    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
               User {{$post->user->name}} Has Add A New Post <br>
               Post ID Is:  {{$post->id}}
            </div>
            <p>Post Body IS:   {{$post->body}} </p>
    
        </div>
    </div>
    
</body>
</html>