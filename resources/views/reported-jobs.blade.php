<x-layout>
    <x-slot:title>All Posted Job</x-slot>
    <div class=" w-full max-w-[1140px] mx-auto" x-data="reportedJobsFunction">
        <h1 class="my-5 text-2xl">All Reported Jobs</h1>
        <div class="space-y-5">
            @if (count($reports) >= 1)
                @php
                    $limit_tag = 3;
                @endphp
                @foreach ($reports as $report)
                    @if ($report->message_to_recruiter_count>0)
                        <div class="py-5 px-5 bg-white border border-gray-300 rounded-md w-full">
                            <div class="flex justify-between items-center mb-3">
                                <h2 class="text-2xl font-medium">{{ $report->job->title }}</h2>
                                @if (!$report->is_resolved_by_recruiter)
                                    <button class="text-green-500 hover:underline cursor-pointer" x-on:click="openModal = {id:'{{ $report->id }}', type: 'resolve'}">Resolve</button>
                                @else
                                    <p class="underline">Resolved By Recruiter</p>
                                @endif
                            </div>
                            <p class="mb-3">{{ Str::limit($report->job->description, 200, '...') }}</p>
                            <div class="flex gap-x-1 items-center text-xs mb-3">
                                @foreach ($report->job->tags as $tag)
                                    @if ($loop->index <= ($limit_tag-1))                       
                                        <p class="tag-style">{{ $tag->name }}</p>
                                    @endif
                                @endforeach
                                @if (count($report->job->tags) > $limit_tag)
                                    <p class="tag-style">{{ count($report->job->tags) - $limit_tag }}+</p>
                                @endif
                            </div>
                            <div class="flex justify-between items-center">
                                <a href="/detail/{{ $report->job->id }}" type="button" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">Detail</a>
                                <template x-if="id">
                                    <span x-on:click="id = null" class="bg-amber-400 hover:bg-amber-500 py-1 px-4 rounded cursor-pointer">Hide Message</span>
                                </template>
                                <template x-if="!id">
                                    <span x-on:click="id = '{{ $report->id }}'" class="bg-amber-300 hover:bg-amber-400 py-1 px-4 rounded cursor-pointer">Show Message</span>
                                </template>
                            </div>
                            <template x-if="id == '{{ $report->id }}'">
                                <div class="bg-gray-100 h-fit rounded-md border border-gray-200 py-4 px-2 space-y-3">
                                    @foreach ($report->MessageToRecruiter as $message)
                                        <div class="border border-gray-300 py-2 px-4">
                                            <div class="my-2">
                                                @if ($message->type == "info")
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm">{{ $message->type }}</span>    
                                                @else
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm">{{ $message->type }}</span>
                                                @endif
                                            </div>
                                            <div class="flex justify-between items-start gap-x-5">
                                                <p>{{ $message->message }}</p>
                                                <span class="text-gray-400 font-light">{{ Carbon\Carbon::parse($message->created_at)->timezone("Asia/Jakarta")->toDayDateTimeString() }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </template>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="flex justify-center text-gray-500 flex-col items-center gap-y-5 mt-10">
                    <img src="/illustration/empty.svg" alt="empty illustration" class="w-56 max-h-56">
                    <p>There are no jobs</p>
                </div>
            @endif
        </div>
        <x-modal-confirm>
            <form action="{{ route('report-resolved-post') }}" method="post">
                @csrf
                <input type="hidden" :value="openModal.id" name="report_id">
                <input type="hidden" :value="openModal.type" name="type">
                <button type="submit" class="text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Yes, I'm sure
                </button>
            </form>
        </x-modal-confirm>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('reportedJobsFunction', () => ({
                openModal: {
                    id: null,
                    type: null
                },
                id: null,
            }))
        })
    </script>
</x-layout>