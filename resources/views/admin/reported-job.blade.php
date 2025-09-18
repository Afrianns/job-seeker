<x-admin-layout>
    <h1 class="title-style">Reported Jobs Page</h1>
    @if ($total_report > 0)
        <div class="relative overflow-x-auto sm:rounded-lg my-5">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Job
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Company
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total Reported
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        @if ($report->report_message_count > 0)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $report->job->title }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $report->job->company->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $report->report_message_count }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('list-reported', ['report_id' => $report->id]) }}" class="font-medium text-blue-600 hover:underline">Detail Lists</a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>   
    @else
        <div class="text-center space-y-4">
            <img src="/illustration/empty.svg" class="w-1/3 mx-auto" alt="">
            <h3 class="text-gray-500 text-xl">There are no reported jobs from user.</h3>  
        </div>
    @endif
</x-admin-layout>