<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $admin = User::create(['name' => 'Admin', 'email' => 'admin@farmconnect.com', 'password' => Hash::make('password'), 'role' => 'admin']);
        $farmer = User::create(['name' => 'John Farmer', 'email' => 'farmer@farmconnect.com', 'password' => Hash::make('password'), 'role' => 'farmer', 'phone' => '0712345678', 'location' => 'Nakuru']);
        $agrovet = User::create(['name' => 'Agro Supplies Ltd', 'email' => 'agrovet@farmconnect.com', 'password' => Hash::make('password'), 'role' => 'agrovet', 'phone' => '0723456789', 'location' => 'Nairobi']);

        // Categories
        $cats = collect([
            ['name' => 'Vegetables', 'slug' => 'vegetables'],
            ['name' => 'Fruits', 'slug' => 'fruits'],
            ['name' => 'Grains & Cereals', 'slug' => 'grains-cereals'],
            ['name' => 'Fertilizers', 'slug' => 'fertilizers'],
            ['name' => 'Pesticides', 'slug' => 'pesticides'],
            ['name' => 'Seeds', 'slug' => 'seeds'],
            ['name' => 'Animal Feed', 'slug' => 'animal-feed'],
            ['name' => 'Farm Tools', 'slug' => 'farm-tools'],
        ])->map(fn($c) => Category::create($c));

        // Farmer products
        Product::create(['user_id' => $farmer->id, 'category_id' => $cats[0]->id, 'name' => 'Fresh Tomatoes', 'description' => 'Organically grown tomatoes', 'price' => 80, 'quantity' => 200, 'unit' => 'kg', 'status' => 'active']);
        Product::create(['user_id' => $farmer->id, 'category_id' => $cats[1]->id, 'name' => 'Ripe Mangoes', 'description' => 'Sweet mangoes from Meru', 'price' => 50, 'quantity' => 150, 'unit' => 'kg', 'status' => 'active']);
        Product::create(['user_id' => $farmer->id, 'category_id' => $cats[2]->id, 'name' => 'White Maize', 'description' => 'Dried white maize', 'price' => 45, 'quantity' => 500, 'unit' => 'kg', 'status' => 'active']);

        // Agrovet products
        Product::create(['user_id' => $agrovet->id, 'category_id' => $cats[3]->id, 'name' => 'DAP Fertilizer', 'description' => '50kg bag of DAP fertilizer', 'price' => 3500, 'quantity' => 100, 'unit' => 'bag', 'status' => 'active']);
        Product::create(['user_id' => $agrovet->id, 'category_id' => $cats[4]->id, 'name' => 'Dursban Pesticide', 'description' => 'Effective against soil pests', 'price' => 850, 'quantity' => 60, 'unit' => 'litre', 'status' => 'active']);
        Product::create(['user_id' => $agrovet->id, 'category_id' => $cats[5]->id, 'name' => 'Hybrid Maize Seeds', 'description' => 'H614D certified seeds', 'price' => 1200, 'quantity' => 80, 'unit' => 'bag', 'status' => 'active']);
    }
}
