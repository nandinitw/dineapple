<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OauthClients extends Model
{
    protected $table = 'oauth_clients';
    protected $fillable = ['outlet_id','name','secret','redirect','personal_access_client','redirect','password_client'];

}
