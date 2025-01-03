<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <title>Laravel</title>

</head>
<body>
<nav class="mb-3">
    <div>
        <h2>Users</h2>
    </div>

</nav>
<div>
    <div class="col-lg-6 col-6">
        <h3>Add User</h3>
        <form action="{{route('web.users.store')}}" method="POST" enctype="multipart/form-data" class="mb-3">
            @csrf
            @method('POST')
            <input name="name" class="form-control" placeholder="enter name">
            @error('name')
            <div class="text-danger">{{$message}}</div>
            @enderror
            @method('POST')
            <input name="email" class="form-control" placeholder="enter email">
            @error('email')
            <div class="text-danger">{{$message}}</div>
            @enderror
            <input name="phone" class="form-control" placeholder="enter phone">
            @error('phone')
            <div class="text-danger">{{$message}}</div>
            @enderror
            <input name="position_id" class="form-control" placeholder="enter position_id">
            @error('position_id')
            <div class="text-danger">{{$message}}</div>
            @enderror
            <div class="form-group w-50">
                <label class="custom-file-label">Upload photo</label>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" name="photo">
                    </div>
                </div>
                @error('photo')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <button type="submit" value="Add" class="btn btn-primary mb-2 mt-4">Submit</button>
        </form>
    </div>
</div>
<div class="d-flex flex-wrap ">
    @foreach($users as $user)
            <div class="d-flex">
                <ul>
                    <a href="{{ route('web.users.show', $user->id) }}"> <li>id: {{ $user->id}}</li></a>
                    <li>name: {{$user->name}}</li>
                    <li>email: {{$user->email}}</li>
                    <li>phone: {{$user->phone}}</li>
                    @foreach($positions as $position)
                        @if( $position->id == $user->position_id )
                            <li>position: {{$position->name}}</li>
                            <li>position_id: {{$position->id}}</li>
                        @endif
                    @endforeach
                    <li>registration_timestamp: {{$user->created_at}}</li>
                    <li>photo url: {{$user->photo}}</li>
                    <img width="200" height="200" src="{{asset('storage/' . $user->photo)}}">
                    <li>remember_token: {{$user->remember_token}}</li>
                </ul>
            </div>
    @endforeach
    <div class=" pagination-sm pagination">
        {{$users->links()}}
    </div>
</div>


</body>
</html>
