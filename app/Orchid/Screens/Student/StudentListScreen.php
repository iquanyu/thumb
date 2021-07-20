<?php

namespace App\Orchid\Screens\Student;

use App\Models\ResidentialQuarter;
use App\Models\School;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use App\Models\Student;
use App\Orchid\Layouts\Student\StudentListLayout;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Student\ChartPieStudentResidentialQuarter;
use App\Orchid\Layouts\Student\ChartPieStudentSchool;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Students management';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'All registered students';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $schools = School::withCount('students')->get();

        $student_schools_student_number_arr = [];
        $student_schools_school_name_arr    = [];

        foreach($schools as $value){
            $student_schools_student_number_arr[] = $value['students_count'];
            $student_schools_school_name_arr[]    = $value['name'];
        }

        $residential_quarters = ResidentialQuarter::withCount('students')->get();

        //dd($residential_quarters);

        $student_residential_quarters_student_number_arr = [];
        $student_residential_quarters_residential_quarter_name_arr = [];

        foreach($residential_quarters as $v){
            $student_residential_quarters_student_number_arr[] = $v['students_count'];
            $student_residential_quarters_residential_quarter_name_arr[] = $v['name'];
        }



        return [
            'students' => Student::paginate(),
            'student_residential_quarters' => [
                [
                    'name'   => 'Students',
                    'values' => $student_residential_quarters_student_number_arr,
                    'labels' => $student_residential_quarters_residential_quarter_name_arr,
                ],
            ],
            'student_schools' => [
                [
                    'name'   => 'Students',
                    'values' => $student_schools_student_number_arr,
                    'labels' => $student_schools_school_name_arr,
                ],
            ],
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
            DropDown::make('Export file')
                ->icon('cloud-download')
                ->list([

                    Button::make('Export all resourse')
                        ->method('export')
                        ->icon('cloud-download')
                        ->rawClick()
                        ->novalidate(),
                ]),
            Link::make(__('Add'))
                ->icon('plus')
                ->href(route('platform.student.edit')),
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
            Layout::columns([
                ChartPieStudentSchool::class,
                ChartPieStudentResidentialQuarter::class,
            ]),
            StudentListLayout::class,
        ];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');

        return response()->streamDownload(function () {
            $csv = tap(fopen('php://output', 'wb'), function ($csv) {
                fputcsv($csv, ['header:col1', 'header:col2', 'header:col3']);
            });

            collect([
                ['row1:col1', 'row1:col2', 'row1:col3'],
                ['row2:col1', 'row2:col2', 'row2:col3'],
                ['row3:col1', 'row3:col2', 'row3:col3'],
            ])->each(function (array $row) use ($csv) {
                fputcsv($csv, $row);
            });

            return tap($csv, function ($csv) {
                fclose($csv);
            });
        }, 'File-name.csv');
    }

    /**
     * @param Student $student
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        Student::findOrFail($request->get('id'))
            ->delete();

        Toast::info(__('Student was removed'));
    }
}
