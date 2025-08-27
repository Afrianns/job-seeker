<x-layout>
    <x-slot:title>All Posted Job</x-slot>
    <div class=" w-full max-w-[1140px] mx-auto" x-data="recruiterJobsFunction" x-init="initialize">
        <h1 class="my-5 text-2xl">All Posted Jobs</h1>
        <div class="space-y-5">
            @if (count($jobs) >= 1)
                @php
                    $limit_tag = 3;
                @endphp
                @foreach ($jobs as $job)
                    <div class="py-3 px-5 bg-white border border-gray-300 rounded-md w-full space-y-5">
                        <h2 class="text-2xl font-medium mt-5">{{ $job->title }}</h2>
                        <p>{{ Str::limit($job->description, 200, '...') }}</p>
                        <div class="flex gap-x-1 items-center text-xs">
                            @foreach ($job->tags as $tag)
                                @if ($loop->index <= ($limit_tag-1))                       
                                    <p class="tag-style">{{ $tag->name }}</p>
                                @endif
                            @endforeach
                            @if (count($job->tags) > $limit_tag)
                                <p class="tag-style">{{ count($job->tags) - $limit_tag }}+</p>
                            @endif
                        </div>
                        <div class="flex justify-between items-center">
                            <a href="detail/{{ $job->id }}" type="button" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">Detail</a>
                        </div>
                    </div>
                @endforeach
                @else
                <div class="flex justify-center text-gray-500 flex-col items-center gap-y-5 mt-10">
                    <img src="/illustration/empty.svg" alt="empty illustration" class="w-56 max-h-56">
                    <p>There are no jobs</p>
                </div>
            @endif
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('recruiterJobsFunction', () => ({
            }))
        })
    </script>
</x-layout>