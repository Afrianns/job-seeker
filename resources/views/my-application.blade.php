<x-layout>
    <x-slot:title>My Application</x-slot>
    <div class=" w-full max-w-[1140px] mx-auto">
        <h1 class="my-5 text-2xl">All Applications</h1>
        <div class="flex max-w-[1140px] mx-auto justify-center mt-5">
            <section class="sticky top-5 w-full max-w-[450px] h-fit border bg-white border-gray-300 rounded p-5">
                @if (count($applications)>0)
                    @foreach ($applications as $application)
                        <div onclick="window.location = '{{ route('my-application', ['id' => $application->id]) }}'" @class(["block relative border border-gray-300 rounded-md py-2 px-3 space-y-3 hover:bg-gray-50 cursor-pointer", "border-purple-500 bg-purple-50 hover:bg-purple-100" => $selected_application != null && $application->id == $selected_application['application']->id])>

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
                            <p class="text-gray-500 my-2">Applied on {{ Carbon\Carbon::parse($application->created_at)->timezone("Asia/Jakarta")->toDayDateTimeString() }}</p>
                            @if ($application->status == "rejected")
                                <div class="absolute top-2 right-2 w-fit px-5 bg-red-100 py-2 border border-red-500 rounded-md flex items-center gap-x-2 fill-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/></svg>
                                    <p class="text-lg text-red-600 font-bold">Rejected</p>
                                </div>
                            @endif
                            @if ($application->status == "approved")
                                <div class="absolute top-2 right-2 w-fit px-5 bg-green-100 py-2 border border-green-500 rounded-md flex items-center gap-x-2 fill-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/></svg>
                                    <p class="text-lg text-green-600 font-bold">Accepted</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div>
                        <h3 class="text-center text-gray-500">There are no application applied</h3>
                    </div>
                @endif
            </section>
            <section class="pl-6 max-w-[740px] w-full h-[calc(100vh-200px)]">
                <x-chating :selected-application="$selected_application"/>
            </section>
        </div>
    </div>
</x-layout>