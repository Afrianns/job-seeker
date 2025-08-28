<x-layout>
    <x-slot:title>My Application</x-slot>
    <div class=" w-full max-w-[1140px] mx-auto">
        <h1 class="my-5 text-2xl">All Applications</h1>
        <div class="flex max-w-[1140px] mx-auto justify-center mt-5">
            <section class="sticky top-5 w-full max-w-[400px] h-fit border bg-white border-gray-300 rounded p-5">
                @foreach ($applications as $application)
                    <div onclick="window.location = '{{ route('my-application', ['id' => $application->id]) }}'" @class(["block border border-gray-300 rounded-md py-2 px-3 space-y-3 hover:bg-gray-50 cursor-pointer", "border-purple-500 bg-purple-50 hover:bg-purple-100" => $selected_application != null && $application->id == $selected_application->id])>
                        <h3>{{ $application->Job->title }}</h3>
                        <div class="flex gap-x-2 items-center text-sm">
                            <img src="{{ $application->Job->company->logo_path ?? '/storage/companies_logo/no-logo.png' }}" class="w-7 h-7 bg-red-50 rounded-full" alt="company logo image" />
                            <div class="flex gap-x-1 items-center">
                                <a href="#" class="hover:underline text-sm text-gray-500">{{ $application->Job->company->name }}</a>
                                @if ($application->Job->company->verification()->exists())
                                    @if ($application->Job->company->verification->status == "approved")
                                        <span class="text-xs text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 21a9 9 0 1 0 0-18a9 9 0 0 0 0 18m-.232-5.36l5-6l-1.536-1.28l-4.3 5.159l-2.225-2.226l-1.414 1.414l3 3l.774.774z" clip-rule="evenodd"/></svg>
                                        </span>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2S2 6.477 2 12s4.477 10 10 10m4.066-14.066a.75.75 0 0 1 0 1.06L13.06 12l3.005 3.005a.75.75 0 0 1-1.06 1.06L12 13.062l-3.005 3.005a.75.75 0 1 1-1.06-1.06L10.938 12L7.934 8.995a.75.75 0 1 1 1.06-1.06L12 10.938l3.005-3.005a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <p>{{ Str::limit($application->job->description, 100, '...') }}</p>
                    </div>
                @endforeach
            </section>
            <section class="pl-6 max-w-[740px] w-full h-[calc(100vh-200px)]">
                <x-chating :selected-application="$selected_application"/>
            </section>
        </div>
    </div>
</x-layout>