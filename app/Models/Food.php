<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Food extends Model
{
    use HasFactory, Notifiable;
      /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $table = 'food';
    /**
     * Indicates if the model should be time
     * @var bool
     */
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'category_id',
        'code',
        'image_url',
        'description',
        'name',
        'price',
        'status',
        'created_at',
        'updated_at',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ ];

}
