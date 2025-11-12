<?php
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

final class BooksSeed extends AbstractSeed
{
    public function run(): void
    {
        $books = [
             [
                'title' => 'A Gyűrű Szövetsége',
                'author' => 'J. R. R. Tolkien',
                'published_year' => 1954,
                'isbn' => '9789630790867',
                'image_url' => 'https://marvin.bline.hu/product_images/1514/2399972089013P.JPG',
                'price' => 5990,
                'stock' => 10,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'A Két Torony',
                'author' => 'J. R. R. Tolkien',
                'published_year' => 1954,
                'isbn' => '9789630790874',
                'image_url' => 'https://lira.erbacdn.net/upload/M_28/rek1/359/4810359.jpg',
                'price' => 5990,
                'stock' => 10,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'A Király Visszatér',
                'author' => 'J. R. R. Tolkien',
                'published_year' => 1955,
                'isbn' => '9789630790881',
                'image_url' => 'https://media.regikonyvek.hu/media/1734128/conversions/a-gyuruk-ura-iii-a-kiraly-visszater_inncvjjx-jpg.jpg',
                'price' => 5990,
                'stock' => 8,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'A Hobbit',
                'author' => 'J. R. R. Tolkien',
                'published_year' => 1937,
                'isbn' => '9789630791765',
                'image_url' => 'https://lira.erbacdn.net/upload/M_28/rek1/776/1949776.jpg',
                'price' => 4990,
                'stock' => 12,
                'created_at' => date('Y-m-d H:i:s'),
            ],

            [
                'title' => 'Harry Potter és a bölcsek köve',
                'author' => 'J. K. Rowling',
                'published_year' => 1997,
                'isbn' => '9789633243704',
                'image_url' => 'https://lira.erbacdn.net/upload/M_28/rek1/416/1901416.jpg',
                'price' => 4990,
                'stock' => 15,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Harry Potter és a titkok kamrája',
                'author' => 'J. K. Rowling',
                'published_year' => 1998,
                'isbn' => '9789633243711',
                'image_url' => 'https://lira.erbacdn.net/upload/M_28/rek1/100/3362100.jpg',
                'price' => 4990,
                'stock' => 14,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Harry Potter és az azkabani fogoly',
                'author' => 'J. K. Rowling',
                'published_year' => 1999,
                'isbn' => '9789633243728',
                'image_url' => 'https://lira.erbacdn.net/upload/M_28/rek1/113/3362113.jpg',
                'price' => 5490,
                'stock' => 13,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Harry Potter és a Tűz Serlege',
                'author' => 'J. K. Rowling',
                'published_year' => 2000,
                'isbn' => '9789633243735',
                'image_url' => 'https://lira.erbacdn.net/upload/M_28/rek1/177/4093177.jpg',
                'price' => 5990,
                'stock' => 12,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Harry Potter és a Főnix Rendje',
                'author' => 'J. K. Rowling',
                'published_year' => 2003,
                'isbn' => '9789633243742',
                'image_url' => 'https://lira.erbacdn.net/upload/M_28/rek1/736/1780736.jpg',
                'price' => 6490,
                'stock' => 11,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Harry Potter és a Félvér Herceg',
                'author' => 'J. K. Rowling',
                'published_year' => 2005,
                'isbn' => '9789633243759',
                'image_url' => 'https://lira.erbacdn.net/upload/M_28/rek1/178/4093178.jpg',
                'price' => 6490,
                'stock' => 10,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Harry Potter és a Halál Ereklyéi',
                'author' => 'J. K. Rowling',
                'published_year' => 2007,
                'isbn' => '9789633243766',
                'image_url' => 'https://lira.erbacdn.net/upload/M_28/rek1/285/3001285.jpg',
                'price' => 6990,
                'stock' => 10,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->table('books')->insert($books)->saveData();
    }
}
