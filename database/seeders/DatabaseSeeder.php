<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Rubrics;
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
        DB::table('rubrics')->delete();
        $common = Rubrics::firstOrCreate(['name' => 'Общество']);
            $citylife = Rubrics::firstOrCreate(['name' => 'Городская жизнь'], ['rubrics_id' => $common->id]);
            $elections = Rubrics::firstOrCreate(['name' => 'Выборы'], ['rubrics_id' => $common->id]);
        $cityday = Rubrics::firstOrCreate(['name' => 'День города']);
            $fireworks = Rubrics::firstOrCreate(['name' => 'Салюты'], ['rubrics_id' => $cityday->id]);
            $playground = Rubrics::firstOrCreate(['name' => 'Детская площадка'], ['rubrics_id' => $cityday->id]);
                $pgfirst = Rubrics::firstOrCreate(['name' => '0-3 года'], ['rubrics_id' => $playground->id]);
                $pgsecond = Rubrics::firstOrCreate(['name' => '3-7 лет'], ['rubrics_id' => $playground->id]);
        $sport = Rubrics::firstOrCreate(['name' => 'Спорт']);
        $this->command->info('Rubrics table seeded!');
    }
}
