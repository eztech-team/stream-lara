<?php

namespace App\Http\Controllers;

use App\Http\Services\LobbyService;
use App\Models\Lobby;
use Illuminate\Http\Request;

class LobbyController extends Controller
{
    protected LobbyService $service;

    public function __construct()
    {
        $this->service = new LobbyService();
    }

    public function index()
    {
        $lobbies = Lobby::with('')->get();

        return response(['lobies' => $lobbies], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'unique:lobbies'],
            'description' => ['required'],
            'requirement' => ['required'],
            'resolution' => ['required'],
            'fps' => ['required'],
            'restreams.*.url' => ['required'],
            'restreams.*.key' => ['required']
        ]);

        $this->service->createService($data);

        return response(['message' => 'Lobby created successfully'], 201);
    }

    public function show(Lobby $lobby)
    {
        return response(['lobby' => $lobby], 200);
    }

    public function destroy(Lobby $lobby)
    {
        $lobby->delete();

        return response(['message' => 'Lobby deleted'], 200);
    }
}
