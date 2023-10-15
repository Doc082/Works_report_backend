<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::select('id','name', 'enterprise', 'iva', 'address', 'email', 'destinatary')->where('user_id', auth()->user()->id)->get();
    }

    public function search(StoreClientRequest $req){
        return Client::select('name', 'id')->where('user_id', auth()->user()->id)->where('name', 'LIKE', $req->name.'%')->first();

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {
        $client = new Client();
        $client->user_id = auth()->user()->id;
        $client->name = $request->name ?? 'PincoPallino';
        $client->enterprise = $request->enterprise ?? '';
        $client->iva = $request->iva ?? 0;
        $client->address = $request->address ?? '';
        $client->email = $request->email ?? '';
        $client->destinatary = $request->destinatary ?? '';

        $res = $client->save();

        return $this->getResult($client, $res, 'Nuovo Cliente Creato');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return $this->getResult($client, true, '');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClientRequest  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        //$client->user_id = $request->user_id;
        $client->name = $request->name ?? $client->name;
        $client->enterprise = $request->enterprise ?? $client->enterprise;
        $client->iva = $request->iva ?? $client->iva;
        $client->address = $request->address ?? $client->address;
        $client->email = $request->email ?? $client->email;
        $client->destinatary = $request->destinatary ?? $client->destinatary;

        $res = $client->save();

        return $this->getResult($client, $res, 'Cliente Aggiornato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $res = $client->delete();
        return $this->getResult($client, $res, 'Cliente cancellato');
    }

    private function getResult($data, $success, $message)
    {
        return [
            'data' => $data,
            'success' => $success,
            'message' => $message,
        ];
    }
}
