<x-admin-layout>
    <h1 class="title-style">List Reported Messages Page</h1>
    <div class="relative overflow-x-auto sm:rounded-lg my-5" x-data="listReportFunction">
        @if ($report->is_resolved_by_recruiter)
            <div class="py-3 px-5 bg-orange-100 rounded flex items-center gap-x-2">
                    <span class="w-2 h-2 bg-orange-800 rounded-full"></span>
                    <p>Resolved By Recruiter</p>
            </div>
        @endif
        <div class="mb-5">
            <div class="flex items-center justify-between my-3">
                <h2 class="text-xl font-medium py-1">{{ $report->job->title }}</h2>
                <div>
                    <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="bg-red-400 py-1 px-5 cursor-pointer rounded-md hover:bg-red-500 font-medium text-red-900">Delete Job</button>
                    <button data-modal-target="report-modal" data-modal-toggle="report-modal" class="bg-amber-400 py-1 px-5 cursor-pointer rounded-md hover:bg-amber-500 font-medium text-amber-900">Send Message</button>
                    <button class="bg-green-500 hover:bg-green-600 py-1 px-4 rounded-md text-white cursor-pointer" x-on:click="openModal = {id:'{{ $report->id }}', type: 'resolved'}">Resolve</button>
                </div>
            </div>
            <p class="text-sm font-light">{{ Str::limit($report->job->description, 250, "...") }} <a href="{{ route('detail', ['id' => $report->job->id]) }}" class=" text-blue-500 hover:underline cursor-pointer text-xs">job details</a></p>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        Reported By
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Message
                    </th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        Created At
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($report->reportMessage as $report_message)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap w-fit">
                            {{ $report_message->user->name }}
                        </th>
                        <td class="px-6 py-4 w-full">
                            {{ Str::limit($report_message->message, 200, '...') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ carbon\Carbon::create($report_message->created_at)->toFormattedDayDateString() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- modal confirm --}}
        <x-modal-confirm>
            <form action="{{ route('admin-report-resolved-post') }}" method="post">
                @csrf
                <input type="hidden" :value="openModal.id" name="report_id">
                <input type="hidden" :value="openModal.type" name="type">
                <button type="submit" class="text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Yes, I'm sure
                </button>
            </form>
        </x-modal-confirm>
    </div>

    {{-- modal delete --}}
    <x-deletePopup>
        <form action="/job/delete/{{ $report->job->id }}" method="post">
            @csrf
            @method("DELETE")
            <button data-modal-hide="popup-modal" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Yes, I'm sure
            </button>
        </form>
    </x-deletePopup>

    <!-- Main modal -->
    <div id="report-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center bg-purple-50/50 items-center w-full h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Send Message to Recruiter.
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="report-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5 space-y-3" action="{{ route('send-message-to-recruiter') }}" method="POST">
                    @csrf
                    <input type="hidden" name="report_id" value="{{ $report->id }}">
                    <div class="col-span-2">
                        <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Type</label>
                        <select id="type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="info">Info</option>
                            <option value="warning">Warning</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900"> Product Description</label>
                        <textarea id="description" name="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Write messsage here"></textarea>                    
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div> 
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('listReportFunction', () => ({
                openModal: {
                    id: null,
                    type: null
                }
            }))
        })
    </script>
</x-admin-layout>