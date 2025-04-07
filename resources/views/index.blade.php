<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <title>Laravel</title>

</head>

<body class="px-2">

<div class="container mb-3 mt-3">
    <nav class="d-flex justify-content-around mb-3">
        <div>
            <h2>Users</h2>
             <p>Sourse code <a href='https://github.com/dmit9/laravel-API-CRUD-test' target="_blank">github.com/dmit9/laravel-API-CRUD-test</a></p>
        </div>
        <div class="mb-3">
            <h2><a href="{{route('rabbit')}}" > rabbitmq send</a></h2>
        </div>

    </nav>

    <div class="d-flex gap-2 mb-3">
        <div class="col-lg-6 col-6 border border-secondary rounded p-1">
            <h3>Add User</h3>
            <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data" class="mb-3 ">
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
                <div class="form-group">
                        <label for="position_id">Choose position_id</label>
                        <select class="form-control" name="position_id">
                            @foreach($positions as $position)
                                <option
                                    {{ old('position_id') == $position->id ? 'selected' : '' }}
                                    value="{{ $position->id }}">
                                    id: {{ $position->id }} name: {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                </div>
                @error('position_id')
                <div class="text-danger">{{$message}}</div>
                @enderror
                <div class="form-group ">
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
                <button type="submit" value="Add" class="btn btn-primary ">Submit</button>
            </form>
        </div>
        <div class="col-lg-6 col-6 border border-secondary ml-1 rounded p-1">
            <h3>Available API links</h3>
            <p><a href="/api/v1/users" target="_blank">/api/v1/users</a></p>
            <p><a href="/api/v1/positions" target="_blank">/api/v1/positions</a></p>
            <p><a href="/api/v1/token" target="_blank">/api/v1/token</a></p>
            <p><a href="/" target="_blank">/public/</a></p>
            <p><a href="user/20" target="_blank">user/20</a></p>
        </div>
    </div>
    <div class=" pagination-sm pagination">
        {{$users->links()}}
    </div>
    <div class="mb-3 d-flex gap-2 border border-secondary ml-1 rounded p-1">
        <p>Sort By: </p>
        <a href="{{ route('index', ['sort' => 'id', 'direction' => ($sortField === 'id' && $sortDirection === 'asc') ? 'desc' : 'asc']) }}"
           class="btn btn-sm btn-primary">
            ID {{ $sortField === 'id' ? ($sortDirection === 'asc' ? '⬆️' : '⬇️') : '' }}
        </a>

        <a href="{{ route('index', ['sort' => 'name', 'direction' => ($sortField === 'name' && $sortDirection === 'asc') ? 'desc' : 'asc']) }}"
           class="btn btn-sm btn-secondary">
            Name {{ $sortField === 'name' ? ($sortDirection === 'asc' ? '⬆️' : '⬇️') : '' }}
        </a>

        <a href="{{ route('index', ['sort' => 'created_at', 'direction' => ($sortField === 'created_at' && $sortDirection === 'asc') ? 'desc' : 'asc']) }}"
           class="btn btn-sm btn-info">
            Date {{ $sortField === 'created_at' ? ($sortDirection === 'asc' ? '⬆️' : '⬇️') : '' }}
        </a>
    </div>
    <div class="d-flex flex-wrap gap-2">
        @foreach($users as $user)
            <div class="d-flex  border border-secondary rounded p-1">
                <ul>
                <div class="d-flex gap-2">
                        <a class="btn btn-sm btn-secondary" href="{{ route('user.show', $user->id) }}">Show</a>
                        <a class="btn btn-sm btn-secondary" href="{{ route('user.edit', $user->id) }}">Edit</a>
                        <form  action="{{route('user.delete', $user->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <input type="submit" class="btn btn-secondary" value="Delete">
                        </form>
                    </div>
                    <a href="{{ route('user.show', $user->id) }}">
                        <li>id: {{ $user->id}}</li>
                    </a>
                    <li>name: {{$user->name}}</li>
                    <li>email: {{$user->email}}</li>
                    <li>phone: {{$user->phone}}</li>
                    @php $shownPosition = false; @endphp
                    @foreach($positions as $position)
                        @if( $position->id == $user->position_id && !$shownPosition)
                            <li>position: {{$position->name}}</li>
                            <li>position_id: {{$position->id}}</li>
                            @php $shownPosition = true; @endphp
                        @endif
                    @endforeach
                    <li>registration_timestamp: {{$user->created_at}}</li>
                    <li>photo url: {{$user->photo}}</li>
                    <img width="100" height="100" src="{{asset('storage/'.$user->photo)}}" style="border-radius: 10%;">
                    <li style="width: 300px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                        remember_token: {{$user->remember_token}}</li>
                </ul>
            </div>
        @endforeach

    </div>
</div>


</body>
</html>
