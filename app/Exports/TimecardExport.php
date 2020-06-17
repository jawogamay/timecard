<?php

namespace App\Exports;

use App\Timecard;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TimecardExport implements FromQuery,WithMapping,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function between($d1,$d2){
        $this->d1 = $d1;
        $this->d2 = $d2;
        return $this;
    }
    public function map($timecard):array
    {
        $string;
        if($timecard->overbreak == 1){
            $string = "Yes";
        }else{
            $string = "No";
        }
        return[
            $timecard->id,
            $timecard->userinfo->user->name,
            $timecard->time_in,
            $timecard->time_out,
            $timecard->hours,
            $timecard->minutes,
            $string
        ];
    }
    public function headings():array
    {
        return [
            '#',
            'User',
            'Time In',
            'Time Out',
            'Hours Spent',
            'Minutes Spent',
            'Overbreak',

        ];
    }
    public function query()
    {
        return Timecard::query()->whereBetween('created_at',[$this->d1,$this->d2]);
    }
}
