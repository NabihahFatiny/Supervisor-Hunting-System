<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usershs extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable; // Use the Authenticatable trait

    protected $table = 'user_shs';
    protected $fillable = ['username', 'temp_password', 'new_password', 'role','created_at','updated_at'];
    protected $primaryKey = 'user_Id';
    // If you're using hashed passwords, make sure to return the correct password field
    public function getAuthPassword()
    {
        return $this->new_password ? $this->new_password : $this->temp_password;
    }

}
