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
        if (User::query()->count() === 0) {
            throw new \Exception('Перед созданием книги необходимо создать хотя бы одного пользователя');
        }

        /** @var BookCategory $category */
        $category = BookCategory::query()->inRandomOrder()->first();

        /** @var int $author_id */
        $author_id = User::query()->inRandomOrder()->value('id');
        /** @var string $filepath */
        $filepath = public_path(sprintf('images/covers/%s', $author_id));

        if (!is_dir($filepath)) {
            mkdir($filepath, 0755, true);
        }
        /** @var string|bool $image */
        $image = $this->faker->image($filepath, 640, 480, $category->name, false);

        if (!$image) {
            throw new \Exception('Image not generated');
        }

        return [
            'title'       => $this->faker->title,
            'description' => $this->faker->text(100),
            'text'        => $this->faker->text(rand(500, 1000)),
            'image'       => $image,
            'author_id'   => $author_id,
            'category_id' => $category->id,
            'status'      => $this->faker->randomElement([
                Book::STATUS_IN_PROGRESS,
                Book::STATUS_FINISHED,
                Book::STATUS_CANCELLED
            ])
        ];
    }
}
