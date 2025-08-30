<x-layout>
    <x-slot:title>User Applicants</x-slot>
    <div class=" w-full max-w-[1140px] mx-auto">
        <h1 class="my-5 text-2xl">All Applications</h1>
        <div class="flex max-w-[1140px] mx-auto justify-center mt-5">
            <section class="sticky top-5 w-full max-w-[400px] h-fit border bg-white border-gray-300 rounded p-5">
                <a href="#" class="font-medium text-xl hover:underline">{{ $job_applications->title }}</a>
                <p class="text-gray-600 py-2">{{ Str::limit($job_applications->description, 100, '...') }}</p>
                @foreach ($job_applications->application as $application)
                    <a href="{{ route('user-jobs-applications.applicants', ['job_id' => $job_applications->id,'application_id' => $application->id]) }}" class="flex items-center gap-x-2 border border-gray-300 rounded-md py-2 px-3 space-y-3 hover:bg-gray-50 cursor-pointer">
                        <img class="w-10 h-10 my-auto" src="{{ $application->user->avatar_path ?? '/storage/avatars/no-avatar.svg' }}" alt="">
                        <div>
                            <h4 class="text-gray-700 font-medium text-xl">{{ $application->user->name }}</h4>
                            <p class="text-gray-500 font-light">{{ $application->user->email }}</p>
                        </div>
                    </a>
                @endforeach
            </section>
            <section class="pl-6 max-w-[740px] w-full h-[calc(100vh-200px)]">
                <x-chating :selected-application="$selected_application"/>
            </section>
        </div>
    </div>
</x-layout>