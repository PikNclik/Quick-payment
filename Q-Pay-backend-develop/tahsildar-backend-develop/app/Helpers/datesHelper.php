<?php
use Carbon\Carbon;


function generateDateRange($start_date, $end_date): array
{
    $start = new Carbon($start_date);
    $end = new Carbon($end_date);

    $diffInDays = $start->diffInDays($end);
    $dateRange = [];
    $per = '';
    if ($diffInDays < $end->daysInMonth) {
        $per = 'day';
        for ($date = $start; $date->lte($end); $date->addDay()) {
            $dateRange[] = $date->copy()->format('d');
        }
    } elseif ($diffInDays < 365) {
        $per = 'month';
        for ($date = $start; $date->lte($end); $date->addMonth()) {
            $dateRange[] = $date->copy()->format('m');
        }
    } else {
        $per = 'year';
        for ($date = $start; $date->lte($end); $date->addYear()) {
            $dateRange[] = $date->copy()->format('Y');
        }
    }

    return ['range' => $dateRange ,'per' => $per];
}
