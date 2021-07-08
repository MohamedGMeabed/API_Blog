<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Posts</title>
</head>
<body>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
                <th>#</th>
                <th>Body</th>
                <th>User ID</th>
                <th>Actions</th>
            </tr>
          </thead>
          <tbody>
             
            @foreach($posts as $post)
         
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->body }}</td>
                <td>{{ $post->user_id }}</td>
                <td>
                    <a class="btn btn-secondary" href="#"> Edit  </a>
                    <a class="btn btn-secondary" href="#"> Delete </a>
                </td>
            </tr>
   
            @endforeach
    
          </tbody>
        </table>
    </div>
    
</body>
</html>