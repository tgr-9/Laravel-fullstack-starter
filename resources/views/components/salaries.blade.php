@props([
    'employee' => null,
    'periods' => [],
])

<div {{ $attributes->merge(['class' => 'flex mt-6']) }}
     x-data="{ salaries: {}, pageUrl: '{{ route('salaries.home') }}', salaryUrl: '{{ route('employees.salaries.index', $employee) }}', periods: {{ Js::from($periods) }} }"
     x-init="{ data: salaries } = await axios.get(salaryUrl)">
    <aside class="flex-none w-1/6 pr-6 pt-6" x-data="{ years: Object.keys(periods).reverse(), firstPeriod: (year) => Object.keys(periods[year])[0] }">
        <h3 id="employment" class="leading-6 font-semibold block">{{ __('salaries.sections.salaries') }}</h3>
        <hr class="my-2">
        <ul x-data="{ current: { year: years[0], period: firstPeriod(years[0]) } }" x-init="$watch('current.year', async (period) => ({ data: salaries } = await axios.get(salaryUrl, { params: { period } })))">
            <template x-for="year in years" :key="year">
                <li>
                    <a :href="`#${year}`" class="p-2 block hover:bg-slate-200 rounded-sm" :class="{ 'bg-slate-200': (year === current.year) }" x-text="year" @click="current.year = year; current.period = firstPeriod(year)"></a>
                </li>
            </template>
        </ul>
    </aside>

    <div class="flex-auto p-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
        <table class="table w-full">
            <thead>
                <tr>
                    <th class="text-left py-1">{{ __('salaries.table.month') }}</th>
                    <th class="text-right py-1 w-1/5">{{ __('salaries.table.total') }}</th>
                    <th class="text-right py-1 w-1/5">{{ __('salaries.table.calculated_at') }}</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="salary in salaries.data" :key="salary.id">
                    <tr class="border-t" x-data="{ date: dateFormat(new Date(salary.period), 'MMM Y'), period: dateFormat(new Date(salary.period), 'Y-MM') }">
                        <td class="py-2">
                            <a :href="`${pageUrl}/${period}`">
                                <strong x-text="date"></strong>
                            </a>
                        </td>
                        <td class="py-2 text-right">
                            <span x-text="numberFormat(salary.value)"></span>
                        </td>
                        <td class="py-2 text-right">
                            <span x-text="dateFormat(new Date(salary.updated_at), 'dd MMM Y HH:m')"></span>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
