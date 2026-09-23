<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    protected $fillable = ['user_id', 'token', 'device_name', 'last_used_at'];
    public $timestamps = true;

    public function user() { return $this->belongsTo(User::class); }

    public static function issue(User $user, string $deviceName = 'mobile'): string
    {
        $plain = bin2hex(random_bytes(32));
        self::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $plain),
            'device_name' => $deviceName,
            'last_used_at' => now(),
        ]);
        return $plain;
    }
}
