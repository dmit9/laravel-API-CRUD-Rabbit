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
                <h3>Edit User</h3>
                <form action="{{route('user.update', $user->id)}}" method="POST" enctype="multipart/form-data"
                      class="mb-3">
                    @csrf
                    @method('patch')
                    <input name="name" class="form-control" placeholder="enter name" value="{{$user->name}}">
                    @error('name')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                    <input name="email" class="form-control" placeholder="enter email" value="{{$user->email}}">
                    @error('email')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                    <input name="phone" class="form-control" placeholder="enter phone" value="{{$user->phone}}">
                    @error('phone')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                    <div class="form-group">
                        <label for="genre">Choose position_id</label>
                        <select class="form-control" name="position_id">
                            @foreach($positions as $position)
                                <option
                                    {{ $position->id == $user->position->id ? 'selected' : '' }}
                                    value="{{ $position->id }}">
                                    id: {{ $position->id }} name: {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ">
                        <img width="200" height="200" src="{{asset('storage/' . $user->photo)}}">
                        <label class="custom-file-label">Upload photo</label>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" name="photo"  id="photo" placeholder="photo">
                            </div>
                        </div>
                        @error('photo')
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
