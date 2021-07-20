<?php

namespace App\Orchid\Screens\Student;

use Orchid\Platform\Database\Seeders\OrchidDatabaseSeeder;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Color;
use App\Models\Student;
use App\Orchid\Layouts\Student\StudentEditLayout;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Relation;
use App\Models\School;
use App\Models\Grade;
use App\Models\Induct;
use App\Models\ResidentialQuarter;
use Orchid\Support\Facades\Toast;

class StudentEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Edit Student';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Details such as name, gender and remarks';

    /**
     * @var bool
     */
    public $exists = false;

    /**
     * @var Student
     */
    private $student;

    /**
     * Query data.
     *
     * @param Student $student
     *
     * @return array
     */
    public function query(Student $student): array
    {
        $this->student = $student;

        if (!$student->exists) {
            $this->name = 'Create Student';
        }

        $student->load(['school', 'grade']);

        return [
            'student'       => $student,
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                ->method('remove')
                ->canSee($this->student->exists),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::block(StudentEditLayout::class)
                ->title(__('Profile Information'))
                ->description(__('Update your account\'s profile information and email address.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->student->exists)
                        ->method('save')
                ),
        ];
    }

    /**
     * @param Student $student
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Student $student, Request $request)
    {
        $request->validate([
            'student.username' => [
                'required',
                //Rule::unique(Student::class, 'email')->ignore($user),
            ],
            'student.grade_id' => [
                'required',
            ],
        ]);

        $permissions = collect($request->get('permissions'))
            ->map(function ($value, $key) {
                return [base64_decode($key) => $value];
            })
            ->collapse()
            ->toArray();

        $studentData = $request->get('student');

        $grade = Grade::find($studentData['grade_id']);

        //$studentData['school_id'] = $grade->school->id;

        $student
            ->fill($studentData)
            ->save();

        $student->refresh();

        $student->grade()->associate($grade);
        $student->school()->associate($grade->school);

        if(isset($studentData['induct_id'])){
            $student->induct()->associate(Induct::find($studentData['induct_id']));
        }else{
            $student->induct()->dissociate();
        }

        if(isset($studentData['residential_quarter_id'])){
            $student->residential_quarter()->associate(ResidentialQuarter::find($studentData['residential_quarter_id']));
        }else{
            $student->residential_quarter()->dissociate();
        }

        $student->save();

        activity()->inLog('student')->performedOn($student)->withProperties($studentData)->log('Student was saved.');

        Toast::info(__('Student was saved.'));

        return redirect()->route('platform.student.list');
    }
}
