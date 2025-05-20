<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CategoryBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));

        $categories = [
            ['name_category_blog' => 'Cleaning Tips', 'slug' => Str::slug('Cleaning Tips')],
            ['name_category_blog' => 'Product Reviews', 'slug' => Str::slug('Product Reviews')],
            ['name_category_blog' => 'Service Updates', 'slug' => Str::slug('Service Updates')],
            ['name_category_blog' => 'Customer Stories', 'slug' => Str::slug('Customer Stories')],
            ['name_category_blog' => 'Maintenance Guides', 'slug' => Str::slug('Maintenance Guides')],
        ];

        // Insert/update kategori
        foreach ($categories as $category) {
            DB::table('category_blogs')->updateOrInsert(
                ['slug' => $category['slug']],
                [
                    'uuid' => (string) Str::uuid(),
                    'name_category_blog' => $category['name_category_blog'],
                    'slug' => $category['slug'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Ambil semua category_blog dari database setelah insert
        $categoryBlogs = DB::table('category_blogs')->get();

        // Ambil user_id dari user dengan role 'karyawan'
        $karyawanUserId = DB::table('users')->where('role', 'karyawan')->value('id');

        $blogs = [
            'Cleaning Tips' => [
                [
                    'title' => 'Bagaimana caranya membersihkan sepatu canvas',
                    'slug' => 'bagaimana-caranya-membersihkan-sepatu-canvas',
                    'content' => 'Temukan cara mudah membersihkan sepatu canvas Anda.',
                    'description' => 'Membersihkan sepatu canvas adalah salah satu tantangan tersendiri karena materialnya yang mudah rusak ...',
                ],
                [
                    'title' => 'Tips Membersihkan Sepatu Putih',
                    'slug' => 'tips-membersihkan-sepatu-putih',
                    'content' => 'Cara menjaga sepatu putih Anda tetap bersih.',
                    'description' => 'Sepatu putih memang elegan, tetapi mudah kotor ...',
                ],
            ],
            // ... kategori blog lainnya sama seperti sebelumnya ...
            'Product Reviews' => [/* isi tetap */],
            'Service Updates' => [/* isi tetap */],
            'Customer Stories' => [/* isi tetap */],
            'Maintenance Guides' => [/* isi tetap */],
        ];

        // Insert/update blog berdasarkan slug
        foreach ($categoryBlogs as $category) {
            foreach ($blogs[$category->name_category_blog] as $blogData) {
                DB::table('blogs')->updateOrInsert(
                    ['slug' => $blogData['slug']],
                    [
                        'uuid' => (string) Str::uuid(),
                        'title' => $blogData['title'],
                        'content' => $blogData['content'],
                        'image_url' => $faker->imageUrl(640, 480),
                        'description' => $blogData['description'],
                        'status_publish' => 'published',
                        'date_publish' => now()->format('Y-m-d'),
                        'time_publish' => now()->format('H:i:s'),
                        'user_id' => $karyawanUserId,
                        'category_blog_id' => $category->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
