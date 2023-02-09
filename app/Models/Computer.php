<?php

namespace App\Models;

use Diegonz\PHPWakeOnLan\PHPWakeOnLan;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mac_address',
        'ip_address',
        'ssh_user',
        's_s_h_key_id',
        'ssh_shutdown_command',
    ];

    public function wake()
    {
        $macAddress = [$this->mac_address];

        try {
            $phpWakeOnLan = new PHPWakeOnLan();
            $result = $phpWakeOnLan->wake($macAddress);

            return $result;
        } catch (Exception $e) {
            return [
                'result' => 'Bad',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function sSHKey()
    {
        return $this->belongsTo(SSHKey::class);
    }

    public function canBeShutdownBy(User $user)
    {
        if ($user->can('force_shutdown_computer', $this)) {
            return true;
        }

        if ($user->can('shutdown_computer') && ! $this->isInUse()) {
            return true;
        }

        return false;
    }

    public function canBeUsedBy(User $user)
    {
        if ($user->can('use_computer', $this)) {
            return true;
        }

        return false;
    }

    public function canBeUnusedBy(User $user)
    {
        if ($user->can('use_computer', $this)) {
            return true;
        }

        return false;
    }

    public function canBeWokenUpBy(User $user)
    {
        if ($user->can('wake_computer', $this)) {
            return true;
        }

        return false;
    }


    public function isInUse()
    {
        return $this->users()->count() !== 0;
    }
}
