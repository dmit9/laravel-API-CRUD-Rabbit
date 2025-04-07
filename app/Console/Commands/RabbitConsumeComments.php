<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use WebSocket\Client;

class RabbitConsumeComments extends Command
{
    protected $signature = 'ws:consume-comments';
    protected $description = 'Consume messages from RabbitMQ over WebSocket';

    public function handle()
    {
        $wsUrl = 'wss://rabbitmq-ws.prototypecodetest.site/ws';
        $login = env('RABBITMQ_USER');
        $password = env('RABBITMQ_PASSWORD');
        $queueName = 'comment';
        $subscriptionId = "sub-1";

        while (true) { // 🔄 Вечный цикл
            try {
                $client = new Client($wsUrl, ['timeout' => 30]);
                $client->send("CONNECT\nlogin:$login\npasscode:$password\nheart-beat:15000,15000\n\n\x00");
                $response = $client->receive();
                $destination = "/queue/$queueName";
                $client->send("SUBSCRIBE\ndestination:$destination\nid:$subscriptionId\nack:auto\nreceipt:$subscriptionId\n\n\x00");
                while (true) {
                    try {
                        $message = $client->receive();
                        if (!empty(trim($message))) {
                            echo " [✔] Получено сообщение:\n$message\n";
                            $data = json_decode($message->body, true);

                            if (!isset($data['name'], $data['text'])) {
                                Log::error('Некорректные данные в сообщении', ['message' => $message->body]);
                                return;
                            }
                        
                            echo"Получено сообщение от {$data['name']}: {$data['text']}";
                        
                            if (!empty($data['fileData'])) {
                                Log::info("Файл в сообщении: " . json_encode($data['fileData']));
                            }
                        }
                    } catch (\Exception $e) {
           //             echo "⚠️ Ошибка при чтении: " . $e->getMessage() . "\n";
                        break; // ❌ Выход из внутреннего цикла, но перезапуск процесса
                    }
                }
            } catch (\Exception $e) {
     //           echo "❌ Ошибка соединения: " . $e->getMessage() . "\n";
            }
            // 🔄 Подождать 5 секунд перед новым подключением
            echo "🔄 Переподключение через 5 секунд...\n";
            sleep(5);
        }
    }
}
