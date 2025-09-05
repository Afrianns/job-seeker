<div>

    <div class="border border-gray-200 px-3 py-2 flex items-center justify-between bg-white">
        <div>
            @if (Auth::user()->is_recruiter)
                <h4 class="font-medium">{{ $selected_application["application"]->user->name }} CV Document</h4>
            @else
                <h4 class="font-medium">Your CV Document</h4>
            @endif
            <a target="_blank" href="{{ route('user-cv-file') }}" class="text-blue-500 hover:underline hover:text-blue-800">{{ $selected_application['application']->name }}</a>
        </div>
        <div>
            <p class="border border-gray-200 py-1 px-2">
                Size: <strong>{{ $selected_application['application']->size }}</strong>
            </p>
            <p class="border border-gray-200 py-1 px-2">
                Type: <strong>{{ $selected_application['application']->type }}</strong>
            </p>
        </div>
    </div>

    @if (Auth::user()->is_recruiter)
        <div class="bg-white w-full py-2 px-3 flex justify-around items-center gap-x-2">
            @if ($selected_application["application"]->status == "waiting")
                <p class="bg-gray-50 rounded-md w-full py-3 text-center cursor-pointer hover:bg-gray-100 border border-gray-300" data-modal-target="popup-modal-approve" data-modal-toggle="popup-modal-approve">Accept</p>
                <p class="bg-red-50 rounded-md w-full py-3 text-center cursor-pointer hover:bg-red-100 border border-red-300 text-red-500" data-modal-target="popup-modal-reject" data-modal-toggle="popup-modal-reject">Reject</p>
            @else
                <p data-modal-target="popup-modal-reject" @class(['rounded-md w-full py-3 text-center border', 'bg-red-50 text-red-500 border-red-300' => $selected_application["application"]->status == "rejected", 'bg-green-50 text-green-500 border-green-300' => $selected_application["application"]->status == "approved"]) data-modal-toggle="popup-modal-reject">{{ Str::title($selected_application["application"]->status) }}</p>
            @endif
        </div>
    @endif
    {{-- if accepted --}}
    @if ($selected_application["application"]->status == "approved" && !Auth::user()->is_recruiter)
        <div class="bg-green-100 w-full p-2 text-center border border-green-500 mt-3">
            <h3 class="text-green-600">Congrat, Your application was approved</h3>
        </div>
    @endif
    <hr class="border-t border-gray-300 mt-5 w-full">
    <div id="popup-modal-reject" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-purple-50/50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm ">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="popup-modal-reject">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <form action="{{ route('user-jobs-applications.set-status',['type' => 'reject', 'application_id' => $selected_application['application']->id]) }}" method="post">
                        @csrf
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 ">Are you sure you want to decline this Application?</h3>
                        <button data-modal-hide="popup-modal-reject" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Yes, I'm sure
                        </button>
                        <button data-modal-hide="popup-modal-reject" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">No, cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div id="popup-modal-approve" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-purple-50/50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm ">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="popup-modal-approve">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <form action="{{ route('user-jobs-applications.set-status',['type' => 'approve', 'application_id' => $selected_application['application']->id]) }}" method="post">
                        @csrf
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 ">Are you sure you want to accept this Application?</h3>
                        <button data-modal-hide="popup-modal-approve" type="submit" class="text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Yes, I'm sure
                        </button>
                        <button data-modal-hide="popup-modal-approve" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">No, cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

