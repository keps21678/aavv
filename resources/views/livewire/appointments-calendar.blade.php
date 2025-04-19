<div class="bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow p-2">
    
    <div class="grid grid-cols-7 gap-2 text-center">
        <!-- Encabezados de los días de la semana -->
        @foreach (['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'] as $day)
        <div class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $day }}</div>
        @endforeach

        <!-- Días del mes -->
        @php
        $startOfMonth = \Carbon\Carbon::create($year, $month)->startOfMonth();
        $endOfMonth = \Carbon\Carbon::create($year, $month)->endOfMonth();
        $startDayOfWeek = $startOfMonth->dayOfWeekIso; // 1 (Lunes) - 7 (Domingo)
        $daysInMonth = $endOfMonth->day;
        $currentDay = \Carbon\Carbon::now()->day;
        $currentMonth = \Carbon\Carbon::now()->month;
        $currentYear = \Carbon\Carbon::now()->year;
        @endphp

        <!-- Espacios vacíos antes del primer día del mes -->
        @for ($i = 1; $i < $startDayOfWeek; $i++) <div>
    </div>
    @endfor

    <!-- Días del mes -->
    @for ($day = 1; $day <= $daysInMonth; $day++) @php $isToday=$day==$currentDay && $month==$currentMonth &&
        $year==$currentYear; @endphp <div class="p-2 rounded-lg text-gray-900 dark:text-gray-100 
                {{ $isToday ? 'bg-blue-500 text-white font-bold' : 'bg-gray-100 dark:bg-gray-700' }}">
        {{ $day }}
</div>
@endfor
</div>
</div>