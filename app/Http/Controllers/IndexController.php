<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\V1\TokenController;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Tinify\Source;
use Illuminate\Support\Str;
use function Tinify\setKey;

class IndexController extends Controller
{
    public function index()
    {
        $users = UserResource::collection(User::paginate(6));
        $positions = Position::all();
        return view('index', compact('users', 'positions'));
    }

    public function show(User $user)
    {
        $positions = Position::all();
        return view('user', compact('user', 'positions'));
    }


    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = Str::random(15) . '.jpg';

            $image = Image::make($photo->getPathname())
                ->fit(70, 70, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 90); // Сжатие на уровне 90%

            $tempPath = storage_path('app/public/images/temp/' . $filename);
            $image->save($tempPath);

            setKey('1BC4cXMKstgLxcKJbWV6qnkfkzTzJ1VK'); // Укажите ваш API-ключ
            $source = Source::fromFile($tempPath); // Загрузка файла в TinyPNG
            $optimizedPath = 'images/users/' . $filename;
            $source->toFile(storage_path('app/public/' . $optimizedPath));
            unlink($tempPath);
            $data['photo'] = $optimizedPath;
        }

        $user = User::create($data);

        $token = $user->createToken('registration_token', ['create-user'])->plainTextToken;
        $expiresAt = \Illuminate\Support\Carbon::now()->addMinutes(40);
        $user->tokens()->where('token', hash('sha256', explode('|', $token)[1]))->update([
            'expires_at' => $expiresAt,
        ]);

        $user->update(['remember_token' => $token]);

        return redirect()->route('index')->with('success', 'User created successfully');
    }


}
