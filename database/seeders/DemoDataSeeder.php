<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Fictional demo data: categories, events and one regular user account.
 */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'user@test.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('Password123'),
                'role' => 'user',
            ]
        );

        $categories = [];
        foreach (['Sport', 'Music', 'Food & Drinks', 'Health & Wellness', 'Technology'] as $name) {
            $categories[$name] = Category::firstOrCreate(['name' => $name]);
        }

        $events = [
            ['Sport', 'City Marathon 10K', 'A 10 km run through the city centre, open to all levels.', '2026-11-22 08:00', '2026-11-22 12:00', 'City Centre', 300, true, null, 'marathon'],
            ['Sport', 'Football Tournament', 'Five-a-side tournament for teams of students and young professionals.', '2026-12-05 14:00', '2026-12-05 19:00', 'Municipal Stadium', 80, false, 15, 'football'],
            ['Music', 'Jazz Night', 'An evening of live jazz with local bands.', '2026-11-28 20:00', '2026-11-28 23:30', 'Municipal Theatre', 150, false, 25, 'jazz'],
            ['Music', 'Open Mic Session', 'Bring your instrument or your voice and share the stage.', '2026-12-12 18:00', '2026-12-12 21:00', 'Cultural Centre', 60, true, null, 'openmic'],
            ['Food & Drinks', 'Street Food Festival', 'Local food trucks, tastings and cooking demos.', '2026-12-19 11:00', '2026-12-19 22:00', 'Seaside Promenade', 500, true, null, 'streetfood'],
            ['Health & Wellness', 'Yoga in the Park', 'A relaxing outdoor yoga session for beginners.', '2026-11-29 09:00', '2026-11-29 10:30', 'Central Park', 40, true, null, 'yoga'],
            ['Technology', 'Web Development Workshop', 'Hands-on introduction to Laravel and REST APIs.', '2027-01-10 10:00', '2027-01-10 16:00', 'Innovation Hub', 30, false, 20, 'workshop'],
            ['Technology', 'AI Meetup', 'Talks and demos about machine learning projects.', '2027-01-24 17:00', '2027-01-24 20:00', 'Innovation Hub', 100, true, null, 'aimeetup'],
        ];

        foreach ($events as [$category, $title, $description, $start, $end, $place, $capacity, $isFree, $price, $seed]) {
            Event::updateOrCreate(
                ['title' => $title],
                [
                    'description' => $description,
                    'category_id' => $categories[$category]->id,
                    'start_date' => $start,
                    'end_date' => $end,
                    'place' => $place,
                    'capacity' => $capacity,
                    'is_free' => $isFree,
                    'price' => $price,
                    'image' => "https://picsum.photos/seed/{$seed}/800/500",
                    'status' => 'active',
                ]
            );
        }
    }
}
