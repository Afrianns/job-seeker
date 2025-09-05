<x-layout>
    <x-slot:title>User Applicants</x-slot>
    <div class=" w-full max-w-[1140px] mx-auto">
        <h1 class="my-5 text-2xl">All Applications</h1>
        <div class="flex max-w-[1140px] mx-auto justify-center mt-5">
            <section class="sticky top-5 w-full max-w-[450px] h-fit border bg-white border-gray-300 rounded p-5">
                <a href="#" class="font-medium text-xl hover:underline">{{ $job_applications->title }}</a>
                <p class="text-gray-600 py-2">{{ Str::limit($job_applications->description, 100, '...') }}</p>
                @foreach ($job_applications->application as $application)
                    <a href="{{ route('user-jobs-applications.applicants', ['job_id' => $job_applications->id,'application_id' => $application->id]) }}" class="relative flex items-center gap-x-2 border border-gray-300 rounded-md py-2 px-3 space-y-3 hover:bg-gray-50 cursor-pointer">
                        <img class="w-10 h-10 my-auto" src="{{ $application->user->avatar_path ?? '/storage/avatars/no-avatar.svg' }}" alt="">
                        <div>
                            <h4 class="text-gray-700 font-medium text-xl">{{ $application->user->name }}</h4>
                            <p class="text-gray-500 font-light">{{ $application->user->email }}</p>
                        </div>
                        @if ($application->status == "rejected")
                            <div class="absolute top-2 right-2 bottom-2 w-fit px-5 bg-gray-100/80 py-2 border border-gray-500/80 rounded-sm flex items-center gap-x-2 fill-gray-600/80">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/></svg>
                                <p class="text-lg text-gray-600/80 font-bold">Rejected</p>
                            </div>
                        @endif
                    </a>
                @endforeach
            </section>
            <section class="pl-6 max-w-[740px] w-full h-[calc(100vh-200px)]">
                <x-chating :selected-application="$selected_application"/>
            </section>
        </div>
    </div>
</x-layout>