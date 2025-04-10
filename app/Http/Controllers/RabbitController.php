<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Facades\Storage;
use Stomp\Transport\Message;
use Intervention\Image\Facades\Image;
use WebSocket\Client;
use App\Http\Requests\RabbitRequest;

class RabbitController extends Controller
{
    public function update(RabbitRequest $request)
    {
        $data = $request->validated();
        $fileData = null;
        $originalName = null;
        $resizedImage = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $originalName = $image->getClientOriginalName();
            $originalMime = $image->getMimeType();

            $resizedIma = Image::make($image->getPathname())
                ->fit(70, 70, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 80); // Кодируем в JPG с качеством 90
            $resizedImage = base64_encode($resizedIma->getEncoded()); 
        }

        $messageBody =  json_encode([
            'name' => $data['name'],
            'email' => $data['email'],
            'text' => $data['text'],
            'filename' => $originalName ,
            'content' => $resizedImage
        ]);

        $wsUrl = "wss://rabbitmq-ws.prototypecodetest.site/ws";
        $login = env('RABBITMQ_USER');
        $password = env('RABBITMQ_PASSWORD');
        $exchange = "lara-send-comment";
        $routingKey = "comment";

        $client = new Client($wsUrl, [
            'timeout' => 10,
            'headers' => [] // Без стандартных заголовков,
        ]);

        try {
      //      echo "Подключение к WebSocket...\n";
            // 1. Авторизация STOMP
            $connectFrame = "CONNECT\nlogin:$login\npasscode:$password\n\n\x00";
            $client->send($connectFrame);
      //      echo "Отправлен CONNECT\n";
            // 2. Ожидание ответа от сервера
            $response = $client->receive();
      //      echo "Ответ на CONNECT: $response\n";
            $sendFrame = "SEND\ndestination:/exchange/$exchange/$routingKey\n\n$messageBody\x00";
            $client->send($sendFrame);
      //      echo "Сообщение отправлено: $messageBody\n";
            // 4. Закрытие соединения
            $client->close();
        //    return response()->json(['status' => 'success']);
            return back()->with('success', 'Message sent to RabbitMQ!');

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


}
