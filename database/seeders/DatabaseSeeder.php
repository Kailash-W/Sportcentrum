<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Employee;
use App\Models\Lesson;
use App\Models\Location;
use App\Models\Participant;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Testgegevens. Alle accounts hebben het wachtwoord: password
 *
 *   admin@delinde.nl     (beheerder)
 *   trainer1@delinde.nl  (trainer, heeft lessen)
 *   lid1@delinde.nl      (lid, al ingeschreven voor Yoga en Boksfit)
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@delinde.nl'],
            ['name' => 'Beheerder', 'password' => 'password', 'role' => User::ADMIN]
        );

        // Zalen
        $rooms = collect(['Zaal 1', 'Zaal 2', 'Zwembad', 'Fitnessruimte'])
            ->map(fn ($name) => Location::firstOrCreate(['name' => $name]));

        // Trainers
        $trainers = collect([
            ['Anna de Vries', 'trainer1@delinde.nl', '06-11111111'],
            ['Bram Smit', 'trainer2@delinde.nl', '06-22222222'],
            ['Chantal Visser', 'trainer3@delinde.nl', '06-33333333'],
        ])->map(function ($t) {
            $user = User::firstOrCreate(
                ['email' => $t[1]],
                ['name' => $t[0], 'password' => 'password', 'role' => User::TRAINER]
            );

            return Trainer::firstOrCreate(['user_id' => $user->id], ['name' => $t[0], 'phone' => $t[2]]);
        });

        // Leden
        $participants = collect([
            ['Lisa Jansen', 'lid1@delinde.nl', 'Kerkstraat 12, Breda', '06-44444444'],
            ['Mohamed Aziz', 'lid2@delinde.nl', 'Havenweg 3, Breda', '06-55555555'],
            ['Sanne Bakker', 'lid3@delinde.nl', 'Lindelaan 20, Breda', '06-66666666'],
        ])->map(function ($p) {
            $user = User::firstOrCreate(
                ['email' => $p[1]],
                ['name' => $p[0], 'password' => 'password', 'role' => User::PARTICIPANT]
            );

            return Participant::firstOrCreate(
                ['user_id' => $user->id],
                ['name' => $p[0], 'address' => $p[2], 'phone' => $p[3]]
            );
        });

        // Activiteiten
        if (Activity::count() === 0) {
            Activity::insert([
                ['name' => 'Groepslessen', 'description' => 'Yoga, spinning en boksfit in kleine groepen, voor elk niveau.', 'date' => today()->addDays(7)->toDateString()],
                ['name' => 'Zwemmen', 'description' => 'Banen zwemmen of aquafit in ons verwarmde bad.', 'date' => today()->addDays(10)->toDateString()],
                ['name' => 'Fitness', 'description' => 'Trainen op eigen tempo met begeleiding van onze trainers.', 'date' => today()->addDays(14)->toDateString()],
            ]);
        }

        // Medewerkers
        $employees = collect([
            ['Tom Jansen', 'Receptie'],
            ['Eva Mulder', 'Schoonmaak en onderhoud'],
        ])->map(fn ($e) => Employee::firstOrCreate(['name' => $e[0]], ['position' => $e[1]]));

        // Lessen (alleen als er nog geen zijn). Yoga en Spinning vallen bewust op hetzelfde tijdstip
        // zodat de dubbele-tijdcontrole direct te testen is.
        if (Lesson::count() === 0) {
            $yoga = Lesson::create(['trainer_id' => $trainers[0]->id, 'location_id' => $rooms[1]->id, 'name' => 'Yoga', 'description' => 'Rustige les voor lichaam en geest.', 'date' => today()->addDays(2), 'start_time' => '19:00', 'end_time' => '20:00', 'max_amount' => 10]);
            Lesson::create(['trainer_id' => $trainers[1]->id, 'location_id' => $rooms[0]->id, 'name' => 'Spinning', 'description' => 'Intensieve fietstraining op muziek.', 'date' => today()->addDays(2), 'start_time' => '19:00', 'end_time' => '20:00', 'max_amount' => 12]);
            $boks = Lesson::create(['trainer_id' => $trainers[2]->id, 'location_id' => $rooms[0]->id, 'name' => 'Boksfit', 'description' => 'Conditie en kracht met bokselementen.', 'date' => today()->addDays(3), 'start_time' => '18:30', 'end_time' => '19:30', 'max_amount' => 8]);
            Lesson::create(['trainer_id' => $trainers[0]->id, 'location_id' => $rooms[2]->id, 'name' => 'Zwemmen', 'description' => 'Technieklessen schoolslag en borstcrawl.', 'date' => today()->addDays(4), 'start_time' => '20:00', 'end_time' => '21:00', 'max_amount' => 2]);
            Lesson::create(['trainer_id' => $trainers[0]->id, 'location_id' => $rooms[1]->id, 'name' => 'Yoga', 'description' => 'Rustige les voor lichaam en geest.', 'date' => today()->addDays(9), 'start_time' => '19:00', 'end_time' => '20:00', 'max_amount' => 10]);

            $participants[0]->lessons()->attach([$yoga->id, $boks->id]);
            $participants[1]->lessons()->attach([$yoga->id]);

            $employees[0]->lessons()->attach([$yoga->id]);
        }
    }
}
