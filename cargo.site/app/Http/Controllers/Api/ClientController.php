<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::get();
        return ClientResource::collection($clients);
    }

    public function show(Client $client)
    {
        return new ClientResource($client);
    }
}
