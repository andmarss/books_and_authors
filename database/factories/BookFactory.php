<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /** @var int $book_id */
        $book_id = (Book::query()->latest('id')->first()->id ?? 0) + 1;
        /** @var string $filepath */
        $filepath = public_path(sprintf('images/covers/%d', $book_id));

        if (!is_dir($filepath)) {
            mkdir($filepath, 0755, true);
        }

        return [
            'title'       => $this->faker->title,
            'description' => $this->faker->text(100),
            'text'        => $this->faker->text(rand(500, 1000)),
            'image'       => $this->faker->image($filepath, 640, 480, null, false),
            'author_id'   => User::factory(),
            'category_id' => BookCategory::query()->inRandomOrder()->value('id'),
            'status'      => $this->faker->randomElement([
                Book::STATUS_IN_PROGRESS,
                Book::STATUS_FINISHED,
                Book::STATUS_CANCELLED
            ])
        ];
    }
}
