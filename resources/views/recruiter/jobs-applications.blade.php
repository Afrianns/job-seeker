<x-layout>
    <x-slot:title>User Jobs Applications</x-slot>
    <div class=" w-full max-w-[1140px] mx-auto">
        <h1 class="my-5 text-2xl">All Job Applications</h1>
        <div class="max-w-[1140px] mx-auto justify-center mt-5">
            @php
                $limit_tag = 3;
            @endphp
            @foreach ($jobs_applications as $job_applications)
                @if ($job_applications->application_count > 0)
                    <a href="{{ route('user-jobs-applications.applicants', ['job_id' => $job_applications->id]) }}" class="block bg-white border border-gray-300 rounded-md my-5 p-5 space-y-3 hover:bg-purple-50 hover:border-purple-500 cursor-pointer">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-bold py-2">{{ $job_applications->title }}</h2>
                            <span class="text-gray-400 font-light text-md">Created at {{ Carbon\Carbon::create($job_applications->created_at)->toDayDateTimeString() }}</span>
                        </div>
                        <p>{{ Str::limit($job_applications->description, 200, '...') }}</p>
                        <div class="flex gap-x-1 items-center text-xs">
                            @foreach ($job_applications->tags as $tag)
                                @if ($loop->index <= ($limit_tag-1))                       
                                    <p class="tag-style">{{ $tag->name }}</p>
                                @endif
                            @endforeach
                            @if (count($job_applications->tags) > $limit_tag)
                                <p class="tag-style">{{ count($job_applications->tags) - $limit_tag }}+</p>
                            @endif
                        </div>

                        <div class="my-3 bg-blue-100 py-1 px-4 rounded-lg w-fit">
                            <p class="text-blue-500 hover:text-blue-700 hover:underline">Total Users Applied {{ $job_applications->application_count }}</p>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</x-layout>