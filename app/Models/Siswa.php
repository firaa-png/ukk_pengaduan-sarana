<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = ['nis', 'nama', 'kelas', 'jurusan', 'username', 'password', 'avatar'];

    // Hide password when serializing
    protected $hidden = ['password'];

    // Hash password when set
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = password_hash($value, PASSWORD_BCRYPT);
        }
    }

    // Return public URL for avatar if set
    public function getAvatarUrlAttribute()
    {
        if (!empty($this->avatar)) {
            return asset($this->avatar);
        }
        return null;
    }
}
