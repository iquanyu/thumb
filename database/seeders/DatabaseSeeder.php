<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\School;
use App\Models\Grade;
use App\Models\Induct;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$faker = app(Faker\Generator::class);
        $faker  = Faker\Factory::create();

        //\App\Models\User::factory(10)->create();

        //$user = \App\Models\User::find(1);
        //$user->delete();
        //$user->name = 'admin';
        //$user->email = 'admin@admin.com';
        //$user->permissions = '{"platform.index": "1", "platform.systems.roles": "1", "platform.systems.users": "1", "platform.systems.attachment": "1"}';
        //$user->save();

        $area = new Area();
        $area->code = '10000';
        $area->name = '中国';
        $area->save();

        $school_name_arr = [
            '第一小学',
            '第二小学',
            '第三小学',
            '第四小学',
            '墨尔根小学',
        ];

        foreach($school_name_arr as $value){
            $school = new School;
            $school->area_id = '1';
            $school->name = $value;
            $school->address = $faker->address();
            $school->save();
        }

        for ($i=1; $i <= 4; $i++) {
            $grade = new Grade;
            $grade->school_id = $i;
            $grade->grade_name = '一班';
            $grade->class_name = '二年';
            $grade->grade_number = '1';
            $grade->class_number = '2';
            $grade->teacher = '王老师';
            $grade->save();
        }

        $induct = new Induct();
        $induct->name = '卡片';
        $induct->type = '广告';
        $induct->save();

        \App\Models\ResidentialQuarter::factory(10)->create();

        \App\Models\Student::factory(50)->create();

        $studens = Student::all();
        foreach($studens as $value){
            $value->grade_id = $value->school_id;
            $value->save();
        }
    }
}
