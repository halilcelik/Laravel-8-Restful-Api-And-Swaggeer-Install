<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
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
         User::factory(100)->create();

    /*   DB::statement('SET FOREIGN_KEY_CHECKS = 0');

          Product::factory(1000)->create();
        
         Category::factory(100)->create(); 

         DB::table('product_categories')->insert(['product_id' => 1, 'category_id' => 1]);
         DB::table('product_categories')->insert(['product_id' => 1, 'category_id' => 2]);
         DB::table('product_categories')->insert(['product_id' =>2, 'category_id' => 1]);
         DB::table('product_categories')->insert(['product_id' =>2, 'category_id' => 2]);
         DB::table('product_categories')->insert(['product_id' =>2, 'category_id' => 2]);

         DB::statement('SET FOREIGN_KEY_CHECKS = 1'); */
    }
}
