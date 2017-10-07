<?php

namespace CoreCMF\Broadcasting\App\Models;

use Schema;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public $table = 'Broadcasting_configs';

    protected $fillable = [];

    public function getStatusAttribute($value)
    {
        return (boolean)$value;
    }

}
