<x-admin-layout>
    <h1 class="title-style">List Reported Messages Page</h1>
    <div class="relative overflow-x-auto sm:rounded-lg my-5">
        <div class="mb-5">
            <h2 class="text-xl font-medium py-2">{{ $job->title }}</h2>
            <p class="text-sm font-light ">{{ Str::limit($job->description, 250, '...') }} <a href="{{ route('detail', ['id' => $job->id]) }}" class=" text-blue-500 hover:underline cursor-pointer text-xs">job details</a></p>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Reported By
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Message
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Created At
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reported_jobs as $reported_job)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $reported_job->user->name }}
                        </th>
                        <td class="px-6 py-4">
                            
                            {{  Str::limit($reported_job->message, 200, '...') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ carbon\Carbon::create($reported_job->created_at)->toFormattedDayDateString() }}
                        </td>
                        <td class="px-6 py-4 flex gap-x-3">
                            <p>Delete</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>