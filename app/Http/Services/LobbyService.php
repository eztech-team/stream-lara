<?php

namespace App\Http\Services;

use App\Models\Lobby;

class LobbyService
{
    public function createService($data)
    {
        $data['restreams'] = json_encode($data['restreams']);
        Lobby::create($data);
    }
}