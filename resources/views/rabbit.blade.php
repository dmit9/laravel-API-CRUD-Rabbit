<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <title>Laravel</title>

</head>
<body>
<div class="container mb-3 mt-3">
    <nav class="d-flex">
        <div class="mb-3">
            <h2><a href="/"> All users</a></h2>
        </div>

    </nav>
    <div class="d-flex flex-wrap ">
        <div class="d-flex">

            <div class="">
                <h3>Adding a comment to a site <a href='https://comment.prototypecodetest.site/' target="_blank">
                    comment.prototypecodetest.site</a> using the RabbitMQ message broker</h3>
                <form action="{{route('rabbit.update')}}" method="POST" enctype="multipart/form-data"
                      class="mb-3">
                    @csrf
                    @method('patch')
                    <input name="name" class="form-control" placeholder="enter name" >
                    @error('name')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                    <input name="email" class="form-control" placeholder="enter email" >
                    @error('email')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                    <input name="text" class="form-control" placeholder="enter comment" >
                    @error('text')
                    <div class="text-danger">{{$message}}</div>
                    @enderror

                    <div class="form-group ">
                        <label class="custom-file-label">Upload image</label>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" name="image"  id="image" placeholder="image">
                            </div>
                        </div>
                        @error('image')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ">Submit</button>
                </form>
            </div>

        </div>
    </div>

</body>
</html>
