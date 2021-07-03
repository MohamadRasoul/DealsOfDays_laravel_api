<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //$this->call(UsersTableSeeder::class);

        // factory(App\Category::class, 1)->create();

        DB::table('categories')->insert(
            [
                [
                    'name' => 'Food',
                    'color' => '#FFEB3B',
                    'categoryId' => '2131165346'
                ],
                [
                    'name' => 'Salon',
                    'color' => '#673AB7',
                    'categoryId' => '2131165352'
                ],
                [
                    'name' => 'Cloth',
                    'color' => '#4CAF50',
                    'categoryId' => '2131165344'
                ],
                [
                    'name' => 'Gift',
                    'color' => '#9C27B0',
                    'categoryId' => '2131165347'
                ],
                [
                    'name' => 'Hotel',
                    'color' => '#FF9800',
                    'categoryId' =>  '2131165350'
                ],
                [
                    'name' => 'Shoes',
                    'color' => '#00BCD4',
                    'categoryId' => '2131165356'
                ],
                [
                    'name' => 'Sport',
                    'color' => '#2196F3',
                    'categoryId' =>  '2131165357'
                ],
                [
                    'name' => 'Health',
                    'color' => '#81C784',
                    'categoryId' => '2131165349'
                ],
                [
                    'name' => 'Grocery',
                    'color' => '#FFC107',
                    'categoryId' => '2131165348'
                ],
                [
                    'name' => 'Travel',
                    'color' => '#3F51B5',
                    'categoryId' => '2131165359'
                ],
                [
                    'name' => 'Shopping',
                    'color' => '#9C27B0',
                    'categoryId' => '2131165355'
                ],
                [
                    'name' => 'accessories',
                    'color' => '#00838F',
                    'categoryId' => '2131165341'
                ],
                [
                    'name' => 'education',
                    'color' => '#CDDC39',
                    'categoryId' => '2131165345'
                ],
                [
                    'name' => 'Tech',
                    'color' => '#2979FF',
                    'categoryId' => '2131165358'
                ],
                [
                    'name' => 'Bags',
                    'color' => '#FFA726',
                    'categoryId' => '2131165342'
                ]
            ]
        );
        factory(App\User::class, 10)->create();
        factory(App\Company::class, 15)->create();
        factory(App\Branch::class, 15)->create();
        factory(App\Offer::class, 100)->create();
        factory(App\Copon::class, 15)->create();
        factory(App\BranchOffer::class, 100)->create();
        factory(App\Image::class, 200)->create();
        factory(App\Review::class, 50)->create();
        factory(App\Favorite::class, 50)->create();
    }





}
