<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
        ]);

        // Copy available unsplash images to 1.jpg ... 50.jpg in the storage folder
        $profilesDir = storage_path('app/public/profiles');
        if (!file_exists($profilesDir)) {
            mkdir($profilesDir, 0755, true);
        }

        // Get all available source unsplash images
        $sourceImages = glob($profilesDir . '/*-unsplash.jpg');

        // Fallback to any jpg if no unsplash images are found
        if (empty($sourceImages)) {
            $sourceImages = glob($profilesDir . '/*.jpg');
        }

        // Filter out any already generated numeric jpg files to prevent recursive copying
        $sourceImages = array_filter($sourceImages, function ($file) {
            return !preg_match('/\/[0-9]+\.jpg$/', $file);
        });
        $sourceImages = array_values($sourceImages);

        if (!empty($sourceImages)) {
            for ($i = 1; $i <= 50; $i++) {
                $sourceImage = $sourceImages[($i - 1) % count($sourceImages)];
                copy($sourceImage, $profilesDir . '/' . $i . '.jpg');
            }
        }

        $interestsByCategory = [
            'Creativity' => ['Art', 'Painting', 'Photography', 'Writing', 'Crafts', 'Design'],
            'Sports & Fitness' => ['Running', 'Yoga', 'Gym', 'Cycling', 'Football', 'Basketball', 'Swimming'],
            'Entertainment' => ['Movies', 'Gaming', 'Reading', 'Music', 'Comedy', 'Podcasts', 'Anime'],
            'Food & Drink' => ['Cooking', 'Baking', 'Dining Out', 'Coffee', 'Veganism', 'Wine', 'Craft Beer'],
            'Travel & Outdoors' => ['Camping', 'Hiking', 'Road Trips', 'Backpacking', 'Beach', 'Sightseeing']
        ];

        foreach ($interestsByCategory as $category => $names) {
            foreach ($names as $name) {
                \App\Models\InterestOption::updateOrCreate(
                    ['name' => $name],
                    ['category' => $category]
                );
            }
        }

        // Create 50 user profiles with image name like profiles/1.jpg, profiles/2.jpg (relative path)
        for ($i = 1; $i <= 50; $i++) {
            $user = User::factory()->create([
                'profile_image' => 'profiles/' . $i . '.jpg',
                'onboarding_step' => 'completed',
            ]);

            // Create profile
            $user->profile()->create([
                'about_me' => 'Hello, I am ' . $user->first_name . '. This is my personal profile. I love exploring new things.',
                'height' => fake()->randomElement(['5\'2"', '5\'4"', '5\'6"', '5\'8"', '5\'10"', '6\'0"']),
                'weight' => fake()->numberBetween(50, 95) . ' kg',
                'religion' => fake()->randomElement(['Hindu', 'Christian', 'Muslim', 'Sikh', 'Buddhist']),
                'caste' => fake()->randomElement(['General', 'OBC', 'SC/ST', 'None']),
                'mother_tongue' => fake()->randomElement(['English', 'Hindi', 'Spanish', 'French', 'Bengali', 'Tamil']),
                'country' => 'India',
                'state' => fake()->randomElement(['Maharashtra', 'Delhi', 'Karnataka', 'Tamil Nadu', 'Gujarat']),
                'city' => fake()->city(),
                'diet' => fake()->randomElement(['Veg', 'Non Veg', 'Eggetarian']),
                'smoking' => fake()->randomElement(['Yes', 'No']),
                'drinking' => fake()->randomElement(['Yes', 'No']),
            ]);

            // Assign some random interest options
            $interestOptionIds = \App\Models\InterestOption::pluck('id')->random(3)->toArray();
            $user->interestOptions()->sync($interestOptionIds);
        }

        // Seed premium packages
        \App\Models\Package::updateOrCreate(['name' => 'Gold Plan'], [
            'price' => 19.99,
            'duration_days' => 30,
            'contact_limit' => 50,
            'interest_limit' => 100,
            'chat_access' => true,
            'view_contact' => true,
        ]);

        \App\Models\Package::updateOrCreate(['name' => 'Diamond Plan'], [
            'price' => 49.99,
            'duration_days' => 90,
            'contact_limit' => 150,
            'interest_limit' => 300,
            'chat_access' => true,
            'view_contact' => true,
        ]);

        \App\Models\Package::updateOrCreate(['name' => 'Platinum Plan'], [
            'price' => 99.99,
            'duration_days' => 180,
            'contact_limit' => 500,
            'interest_limit' => 1000,
            'chat_access' => true,
            'view_contact' => true,
        ]);
    }
}
