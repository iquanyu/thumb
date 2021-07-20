<?php

namespace App\Orchid\Layouts\Student;

use Orchid\Screen\Layouts\Chart;

class ChartPieStudentSchool extends Chart
{
    /**
     * Add a title to the Chart.
     *
     * @var string
     */
    protected $title = 'Distribution of school students';

    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'pie';

    protected $height = 250;

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the chart.
     *
     * @var string
     */
    protected $target = 'student_schools';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;
}
