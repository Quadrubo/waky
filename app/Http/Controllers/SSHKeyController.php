<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSSHKeyRequest;
use App\Http\Requests\UpdateSSHKeyRequest;
use App\Models\SSHKey;

class SSHKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSSHKeyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSSHKeyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SSHKey  $sSHKey
     * @return \Illuminate\Http\Response
     */
    public function show(SSHKey $sSHKey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SSHKey  $sSHKey
     * @return \Illuminate\Http\Response
     */
    public function edit(SSHKey $sSHKey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSSHKeyRequest  $request
     * @param  \App\Models\SSHKey  $sSHKey
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSSHKeyRequest $request, SSHKey $sSHKey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SSHKey  $sSHKey
     * @return \Illuminate\Http\Response
     */
    public function destroy(SSHKey $sSHKey)
    {
        //
    }
}
