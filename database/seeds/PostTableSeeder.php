<?php

use Illuminate\Database\Seeder;

use App\{Category, User};
use Carbon\Carbon;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categories = Category::select('id')->get();
    	$users = User::select('id')->get();

    	foreach (range(1, 100) as $i) {
    		factory(\App\Post::class)->create([
    			'category_id' => $categories->random()->id,
    			'user_id' => $users->random()->id,
                                        'created_at' => Carbon::now()->subHours(rand(0,720))
    		]);	
    	}
	
    }
}
