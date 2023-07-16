<?php

namespace App\Observers;

use App\Models\SSHKey;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Crypt\RSA;

class SSHKeyObserver
{
    /**
     * Handle the SSHKey "created" event.
     *
     * @return void
     */
    public function created(SSHKey $sSHKey)
    {
        $private = RSA::createKey();
        $public = $private->getPublicKey();

        $privateKeyName = $sSHKey->name;
        $publicKeyName = $sSHKey->name.'.pub';

        $privateSSHKey = $private->toString('OpenSSH');
        $publicSSHKey = $public->toString('OpenSSH');

        Storage::disk('private')->put($privateKeyName, $privateSSHKey);
        Storage::disk('private')->put($publicKeyName, $publicSSHKey);

        $sSHKey->public_file = $publicKeyName;
        $sSHKey->private_file = $privateKeyName;

        chmod(Storage::disk('private')->path($privateKeyName), 0400);

        $sSHKey->save();
    }

    /**
     * Handle the SSHKey "updated" event.
     *
     * @return void
     */
    public function updated(SSHKey $sSHKey)
    {
        //
    }

    public function deleting(SSHKey $sSHKey)
    {
        Storage::disk('private')->delete($sSHKey->public_file);
        Storage::disk('private')->delete($sSHKey->private_file);
    }

    /**
     * Handle the SSHKey "deleted" event.
     *
     * @return void
     */
    public function deleted(SSHKey $sSHKey)
    {
        //
    }

    /**
     * Handle the SSHKey "restored" event.
     *
     * @return void
     */
    public function restored(SSHKey $sSHKey)
    {
        //
    }

    /**
     * Handle the SSHKey "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(SSHKey $sSHKey)
    {
        //
    }
}
