<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::query()->truncate();
        BookCategory::query()->truncate();

        if (is_dir(public_path('images'))) {
            system('cd ' . public_path() . ' && rm -rf images');
        }
        /** @var array<string, string> $categories */
        $categories = [
            'Авангардная литература' => 'Характеризуется нарушением канонов и языковыми и сюжетными экспериментами. Как правило, авангард выходит очень маленькими тиражами. Тесно переплетается с интеллектуальной прозой.',
            'Боевик' => 'Ориентирован преимущественно на мужскую аудиторию. Основа сюжета — драки, погони, спасение красоток и т.п.',
            'Детектив' => 'Основная сюжетная линия — раскрытие преступления.',
            'Исторический роман' => 'Основная сюжетная линия — события прошлого, в основном, исторического характера.',
            'Любовный роман' => 'Основная сюжетная линия — любовные отношения между героями.',
            'Научная фантастика' => 'Основная сюжетная линия — события будущего, в основном, научного характера.',
            'Приключения' => 'Герои ввязываются в авантюру и/или отправляются в рискованное путешествие.',
            'Триллер/ужасы' => 'Героям грозит смертельная опасность, от которой они пытаются избавиться.',
            'Драма' => 'Основная сюжетная линия — развитие событий, приводящих к катастрофе.',
            'Фантастика' => 'Сюжет закручивается в гипотетическом будущем или в параллельном мире. Одна из разновидностей фантастики — альтернативная история.',
            'Фэнтези' => 'Основными признаками жанра являются сказочные миры, волшебство, невиданные существа, говорящие животные и пр. Часто основывается на фольклоре.',
            'Сказка' => 'Основная сюжетная линия — события, происходящие в сказочном мире.',
            'Поэзия' => 'Поэзия — это искусство слова, которое воплощает в себе чувства, мысли, эмоции, чувство красоты, восприятие мира.'
        ];

        $this->command->info('Загрузка категорий...');

        foreach ($categories as $name => $description) {
            BookCategory::query()->create([
                'name' => $name,
                'description' => $description,
            ]);
        }

        $this->command->info('Загрузка категорий завершена.');
        $this->command->info('Загрузка книг...');

        /** @var User $user */
        foreach (User::query()->cursor() as $user) {
            Book::factory()
                 ->count(rand(env('BOOK_SEEDER_AMOUNT_MIN', 1), env('BOOK_SEEDER_AMOUNT_MAX', 5)))
                 ->afterCreating(function ($books) use (&$user) {
                     if ($books instanceof Book) {
                         $books = [$books];
                     } elseif ($books instanceof Collection) {
                         $books = $books->all();
                     }

                     /** @var Book $book */
                     foreach ($books as $book) {
                         $book->updateQuietly([
                             'image' => preg_replace('/\covers\/\d+\//', sprintf("/covers/%s/", $user->id), $book->image)
                         ]);
                     }
                 })->create(['author_id' => $user->id]);
        }

        $this->command->info('Книги загружены');
    }
}
