<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class AppointmentsCalendar extends Component
{
    public $year;
    public $month;

    public function mount($year = null, $month = null)
    {
        $this->year = $year ?? now()->year;
        $this->month = $month ?? now()->month;
    }

    public function render()
    {
        return view('livewire.appointments-calendar', [
            'year' => $this->year,
            'month' => $this->month,
        ]);
    }

    public function events() //: Collection
    {
        return collect([
            [
                'id' => 1,
                'title' => 'Breakfast',
                'description' => 'Pancakes! 🥞',
                'date' => Carbon::today(),
            ],
            [
                'id' => 2,
                'title' => 'Meeting with Pamela',
                'description' => 'Work stuff',
                'date' => Carbon::tomorrow(),
            ],
        ]);
    }
}
