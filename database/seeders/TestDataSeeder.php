<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authorId1 = DB::table('author')->insertGetId([
                'fio' => "Фамилия1 Имя1 Отчество1",
                'birth_date' => Date::create(1990, 1, 1),
                'death_date' => null,
        ]);

        $authorId2 = DB::table('author')->insertGetId([
            'fio' => "Фамилия2 Имя2 Отчество2",
            'birth_date' => Date::create(1991,3, 1),
            'death_date' => Date::create(2020,5, 1),
        ]);

        $authorId3 = DB::table('author')->insertGetId([
            'fio' => "Фамилия2 Имя2 Отчество2",
            'birth_date' => Date::create(1991,3, 1),
            'death_date' => Date::create(2020,5, 1),
        ]);

        $book1 = DB::table('book')->insertGetId([
            'name' => "Книга 1",
            'annotation' => "Описание книги 1",
            'publish_date' => Date::create(2020,2, 1)
        ]);

        DB::table('book_author')->insert([
            'book_id' => $book1,
            'author_id' => $authorId1,
        ]);

        DB::table('book_author')->insert([
            'book_id' => $book1,
            'author_id' => $authorId2,
        ]);

        $book2 = DB::table('book')->insertGetId([
            'name' => "Книга 2",
            'annotation' => "Описание книги 2",
            'publish_date' => Date::create(2020,2, 2)
        ]);

        DB::table('book_author')->insert([
            'book_id' => $book2,
            'author_id' => $authorId1,
        ]);

        DB::table('book_author')->insert([
            'book_id' => $book2,
            'author_id' => $authorId2,
        ]);

        DB::table('book_author')->insert([
            'book_id' => $book2,
            'author_id' => $authorId3,
        ]);

        $book3 = DB::table('book')->insertGetId([
            'name' => "Книга 3",
            'annotation' => "Описание книги 3",
            'publish_date' => Date::create(2020,3, 2)
        ]);

        DB::table('book_author')->insert([
            'book_id' => $book3,
            'author_id' => $authorId2,
        ]);

        DB::table('book_author')->insert([
            'book_id' => $book3,
            'author_id' => $authorId3,
        ]);
    }
}
