<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\BookGenre;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@bookstore.com',
                'password' => Hash::make('AdminP@ssw0rd!'),
            ]);

            User::create([
                'name' => 'User1',
                'email' => 'user1@bookstore.com',
                'wallet' => 100,
                'password' => Hash::make('user1password'),
            ]);
        }

        if (Genre::count() == 0) {
            Genre::create([
                'name' => 'Computer algorithms',
            ]);
            Genre::create([
                'name' => 'Computer programming',
            ]);
            Genre::create([
                'name' => 'Computer Science',
            ]);
            Genre::create([
                'name' => 'Computers',
            ]);
            Genre::create([
                'name' => 'Software Development & Engineering',
            ]);
        }

        if (Book::count() == 0) {
            Book::create([
                'title' => 'Introduction To Algorithms',
                'author' => 'Thomas H Cormen, Charles E Leiserson, Ronald L Rivest, Clifford Stein',
                'isbn' => '9780262032933, 0262032937',
                'price' => 94.84,
                'pages' => 1180,
                'released_at' => '2001-01-01',
                'description' => "The first edition won the award for Best 1990 Professional and Scholarly Book in Computer Science and Data Processing by the Association of American Publishers.\nThere are books on algorithms that are rigorous but incomplete and others that cover masses of material but lack rigor. Introduction to Algorithms combines rigor and comprehensiveness."
            ]);
            Book::create([
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '9780132350884, 0132350882',
                'price' => 35.61,
                'pages' => 431,
                'released_at' => '2009-01-01',
                'description' => "Even bad code can function. But if code isn't clean, it can bring a development organization to its knees. Every year, countless hours and significant resources are lost because of poorly written code. But it doesn't have to be that way.",
            ]);
        }

        if (BookGenre::count() == 0) {
            BookGenre::create([
                'book_id' => 1,
                'genre_id' => 1,
            ]);
            BookGenre::create([
                'book_id' => 1,
                'genre_id' => 2,
            ]);
            BookGenre::create([
                'book_id' => 1,
                'genre_id' => 3,
            ]);
            BookGenre::create([
                'book_id' => 1,
                'genre_id' => 4,
            ]);
            BookGenre::create([
                'book_id' => 2,
                'genre_id' => 4,
            ]);
            BookGenre::create([
                'book_id' => 2,
                'genre_id' => 5,
            ]);
        }
    }
}
