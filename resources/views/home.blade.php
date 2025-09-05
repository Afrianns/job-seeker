
<x-layout>
    <x-slot:title>
        New Job
    </x-slot>
    {{-- <div class="flex items-center lg:justify-center flex-col  min-h-screen  p-6 lg:p-8"> --}}
    <div class="flex max-w-[1140px] mx-auto justify-center mt-5">
        <section class="sticky top-5 w-full max-w-[400px] h-fit border bg-white border-gray-300 rounded p-5">
            <h3>The Filters</h3>
        </section>
        <section class="pl-6 max-w-[740px] w-full">
            <h2 class="mb-5 text-2xl font-medium">All Jobs</h2>
            <div class="space-y-5">
                @if (count($jobs) >= 1)
                    @php
                        $limit_tag = 3;
                    @endphp
                    @foreach ($jobs as $job)
                        <div class="py-3 px-5 bg-white border border-gray-300 rounded-md w-full space-y-5">
                            <div class="flex justify-between items-center">
                                <h2 class="text-2xl font-medium mt-5">{{ $job->title }}</h2>
                                @if (Auth::check() && !Auth::user()->is_recruiter && Auth::user()->application()->exists())
                                    @if (Auth::user()->id == $job->application->first()->user_id)
                                        <div class="bg-green-100 py-1 px-4 rounded-lg">
                                            <span class="text-green-500 hover:text-green-700 hover:underline">{{ Str::title($job->application->first()->status) }}</span>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="flex gap-x-2 items-center">
                                <img src="{{ $company->logo_path ?? '/storage/companies_logo/no-logo.png' }}" class="w-10 h-10 bg-red-50 rounded-full" alt="company logo image">
                                <div class="flex flex-col">
                                    <a href="#" class="hover:underline">{{ $job->company->name }}</a>
                                    @if ($job->company->verification()->exists())
                                        @if ($job->company->verification->status == "approved")
                                            <span class="text-xs text-gray-500">verified</span>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-500">not verified</span>
                                    @endif
                                </div>
                            </div>
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
                                @if (Auth::check() && !Auth::user()->is_recruiter && Auth::user()->application()->exists())
                                    @if (Auth::user()->id == $job->application->first()->user_id)
                                        <div class="bg-blue-100 py-1 px-4 rounded-lg">
                                            <span class="text-blue-500 hover:text-blue-700 hover:underline">Applied on {{ Carbon\Carbon::create($job->application->first()->created_at)->toDayDateTimeString() }}</span>
                                        </div>
                                    @endif
                                @endif
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
            
        </section>
    </div>
</x-layout>