<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends BaseModel
{
    use HasFactory;

    protected $table = "book";

    public $timestamps = false;

    /**
     * The authors that belong to the book.
     */
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'annotation',
        'publish_date'
    ];

    protected $dates = [
        'publish_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
         'publish_date' => "date:Y-m-d"
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

    /**
     * Есть ли заданный автор среди авторов книги
     * @param int $authorId
     * @return bool
     */
    public function hasAuthor(int $authorId)
    {
        $bookAuthor = $this->authors()->where(['author_id' => $authorId])->get();

        return count($bookAuthor) > 0;
    }
}
