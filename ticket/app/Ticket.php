<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    const STATUS_CREATED = 1;
    const STATUS_ATTENDIND = 2;
    const STATUS_CLOSED = 3;

    //
    protected $fillable = [
        'user_id',
        'category_id',
        'assigned',
        'ticket_id',
        'description',
        'title',
        'priority',
        'message',
        'status',
        "tipoHerramienta",
        "tipoPregunta",
        "tipoProblema",
        "comment",
        "time_solution",
        "answer",
        'is_open',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
