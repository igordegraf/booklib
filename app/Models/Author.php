<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends BaseModel
{
    use HasFactory;

    protected $table = "author";

    public $timestamps = false;

    /**
     * The books that belong to the author.
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_author');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fio',
        'birth_date',
        'death_date'
    ];

    protected $dates = [
        'birth_date',
        'death_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => "date:Y-m-d",
        'death_date' => "date:Y-m-d"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
//        'created_at',
//        'updated_at'
    ];

}
