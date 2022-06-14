@props([
    'employee' => null,
    'periods' => [],
])

<div {{ $attributes->merge(['class' => 'flex mt-6']) }}
     x-data="{ attendances: {}, pageUrl: '{{ route('attendances.home') }}', attendanceUrl: '{{ route('employees.attendances.index', $employee) }}', periods: {{ Js::from($periods) }} }"
     x-init="{ data: attendances } = await axios.get(attendanceUrl)">
    <aside class="flex-none w-1/6 pr-6 pt-6" x-data="{ years: Object.keys(periods).reverse(), firstPeriod: (year) => Object.keys(periods[year])[0] }">
        <h3 id="employment" class="leading-6 font-semibold block">{{ __('attendances.route.index') }}</h3>
        <hr class="my-2">
        <ul x-data="{ current: { year: years[0], period: firstPeriod(years[0]) } }" x-init="$watch('current.period', async (period) => ({ data: attendances } = await axios.get(attendanceUrl, { params: { period } })))">
            <template x-for="year in years" :key="year">
                <li>
                    <a :href="`#${year}`" class="p-2 block hover:bg-slate-200 rounded-sm" :class="{ 'bg-slate-200': (year === current.year) }" x-text="year" @click="current.year = year; current.period = firstPeriod(year)"></a>
                    <ul x-show="current.year === year" class="py-1">
                        <template x-for="[period, month] in Object.entries(periods[year])" :key="period">
                            <li>
                                <a :href="`#${period}`" class="py-1 pl-4 pr-2 block hover:bg-slate-200 rounded-sm" :class="{ 'bg-slate-200': (period === current.period) }" x-text="month" @click="current.period = period"></a>
                            </li>
                        </template>
                    </ul>
                </li>
            </template>
        </ul>
    </aside>

    <div class="flex-auto p-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="flex gap-4 border-b border-gray-300 pb-4 mb-4">
            <section class="w-1/2">
                <h3 class="text-sm uppercase">{{ __('attendances.stats.schedule-label') }}</h3>
                <p class="font-bold text-lg">
                    <span x-text="attendances.schedule?.name.toUpperCase()"></span>
                </p>
            </section>

            <section class="flex-auto">
                <h3 class="text-sm uppercase">{{ __('attendances.stats.overtime-label') }}</h3>
                <p class="font-bold text-lg">
                    <span x-text="attendances.overtime"></span> {{ __('attendances.stats.overtime-hours') }}
                </p>
            </section>

            <section class="flex-auto">
                <h3 class="text-sm uppercase">{{ __('attendances.stats.leave-label') }}</h3>
                <p class="font-bold text-lg">
                    <span x-text="attendances.leaveCount"></span> {{ __('attendances.stats.leave-days') }}
                </p>
            </section>
        </div>

        <table class="table w-full">
            <thead>
                <tr>
                    <th class="text-left py-1 w-1/6">{{ __('attendances.table.date') }}</th>
                    <th class="py-1 w-2/6">{{ __('attendances.table.notes') }}</th>
                    <th class="py-1 w-1/6">{{ __('attendances.table.work-group') }}</th>
                    <th class="py-1">{{ __('attendances.table.clock-in') }}</th>
                    <th class="py-1">{{ __('attendances.table.clock-out') }}</th>
                    <th class="py-1 w-1/6">{{ __('attendances.table.overtime') }}</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="attendance in attendances.data" :key="attendance.id">
                    <tr class="border-t" :class="{'text-rose-600 bg-rose-100 font-bold' : attendance.calendar_id}" x-data="{ date: dateFormat(new Date(attendance.date), 'EEEE, d MMM') }">
                        <td class="py-2 textali">
                            <strong x-text="date"></strong>
                        </td>
                        <td class="py-2 text-sm text-gray-500" :class="{'text-center' : !attendance.notes}" x-data="{ notes: attendance.notes?.split('\n') || []}">
                            <template x-for="note in notes" :key="note">
                                <span class="block" x-text="note"></span><br />
                            </template>
                            <span class="font-bold text-rose-600 underline" x-show="attendance.calendar_id" x-text="attendance.day_off?.name"></span>
                        </td>
                        <td class="py-2 text-center">
                            <span x-text="attendance.group?.name || '-'"></span>
                        </td>
                        <td class="py-2 text-center">
                            <span x-time="attendance.started_at"></span>
                        </td>
                        <td class="py-2 text-center">
                            <span x-time="attendance.ended_at"></span>
                        </td>
                        <td class="py-2 text-center">
                            <span x-text="numberFormat(attendance.overtime)"></span>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
