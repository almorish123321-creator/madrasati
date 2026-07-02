<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class My_Parent extends Authenticatable
{
    use HasFactory, HasTranslations, Notifiable;

    public $translatable  = ['Name_Father', 'Job_Father','Name_Mother','Job_Mother'];

    protected $guarded = [];


    protected $table = 'my__parents';
}
