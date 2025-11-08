<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Activity;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        $types = ['mdb', 'ticket', 'assignment', 'gdb', 'session', 'email'];

        $type = $this->faker->randomElement($types);

        $data = [
            'user_id'       => User::inRandomOrder()->first()?->id ?? 1,
            'type'          => $type,
            'status'        => $this->faker->randomElement(['pending', 'completed']),
            'activity_date' => $this->faker->dateTimeBetween('-5 months', 'now'),
            'description'   => $this->faker->sentence(),
        ];

        // Add type-specific fields
        switch ($type) {
            case 'mdb':
                $data['description'] = "MDB reply: " . $this->faker->sentence();
                break;
            case 'ticket':
                $data['ticket_id'] = 'TCK-' . $this->faker->unique()->numberBetween(1000, 9999);
                break;
            case 'assignment':
                $data['marks_awarded'] = $this->faker->numberBetween(50, 100);
                break;
            case 'gdb':
                $data['marks_awarded'] = $this->faker->numberBetween(0, 20);
                break;
            case 'session':
                $data['session_week'] = $this->faker->numberBetween(1, 16);
                $data['description'] = "Week {$data['session_week']} session: " . $this->faker->sentence();
                break;
            case 'email':
                $data['email_subject'] = $this->faker->sentence(4);
                break;
        }

        return $data;
    }
}
