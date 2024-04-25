<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invoice extends Model
{
    use HasFactory, Notifiable;
      /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $table = 'invoice';

    /**
     * Indicates if the model should be time
     * @var bool
     */
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'vat',
        'note',
        'status',
        'delivery',
        'desk_id',
        'user_id',
        'confirm',
        'customer_id',
        'discount',
        'created_at',
        'updated_at',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ ];

    public function details()
    {
        return $this->hasMany(InvoiceDetails::class, 'invoice_id');
    }

}
