<?php

namespace App\Orchid\Layouts\Student;

use App\Models\Student;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Table;

class StudentListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'students';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', __('ID')),

            TD::make('username', __('Username'))
                ->render(function (Student $student) {
                    return Link::make($student->username)
                        ->route('platform.student.edit', $student);
                })->cantHide(),
            TD::make('school_id', __('School name'))->render(function (Student $student) {
                return $student->school->name;
            }),
            TD::make('grade_id', __('Grade name'))->render(function (Student $student) {
                return $student->grade->full_grade_name;
            }),
            TD::make('gender', __('Gender'))->render(function (Student $student) {
                return $student->gender_format;
            }),
            TD::make('birthday', __('Birthday')),
            TD::make('remarks', __('Remarks')),
            TD::make('created_at', __('Created')),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Student $student) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.student.edit', $student->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->method('remove')
                                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                                ->parameters([
                                    'id' => $student->id,
                                ]),
                        ]);
                }),
        ];
    }

    /**
     * @return string
     */
    protected function textNotFound(): string
    {
        return __('There are no records in this view001');
    }
}
