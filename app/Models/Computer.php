<?php

namespace App\Models;

use Diegonz\PHPWakeOnLan\PHPWakeOnLan;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

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
    ];

    public function wake() {
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

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
