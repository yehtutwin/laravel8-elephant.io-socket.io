<?php

namespace App\Models;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class Socket
{
    public static function sendNotification($msg) {
        $client = new Client(new Version2X('http://localhost:3000', [
            'headers' => [
                'X-My-Header: websocket rocks',
                'Authorization: Bearer 12b3c4d5e6f7g8h9i'
            ]
        ]));
        
        $client->initialize();
        $client->emit('backend notification', ['msg' => $msg]);
        $client->close();
    }
}
