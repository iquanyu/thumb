<?php

namespace App\Orchid\Layouts\Student;

use App\Models\Grade;
use App\Models\Induct;
use App\Models\ResidentialQuarter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class StudentEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Input::make('student.username')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('UserName'))
                ->placeholder(__('UserName')),

            Select::make('student.gender')
                ->options([
                    'm'   => '男',
                    'f' => '女',
                ])
                ->title('Gender'),
                //->help('Allow search bots to index'),
            DateTimer::make('student.birthday')
                ->title('Birthday')
                ->format('Y-m-d'),

            /*Relation::make('student.school_id')
                ->fromModel(School::class, 'name')
                ->title('Choose school'),*/

            Relation::make('student.grade_id')
                ->fromModel(Grade::class, 'id')
                ->displayAppend('full_name')
                ->required()
                ->title('Choose grade'),

            Relation::make('student.residential_quarter_id')
                ->fromModel(ResidentialQuarter::class, 'name')
                ->title('Choose residential quarter'),

            Relation::make('student.induct_id')
                ->fromModel(Induct::class, 'name')
                ->displayAppend('full_induct')
                ->title('Choose induct'),

            Input::make('student.remarks')
                ->type('text')
                ->title(__('Remarks'))
                ->placeholder(__('Remarks')),
        ];
    }
}
