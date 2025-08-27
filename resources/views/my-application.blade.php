<x-layout>
    <x-slot:title>My Application</x-slot>
    <div class=" w-full max-w-[1140px] mx-auto" x-data="myApplicationFunction">
        <h1 class="my-5 text-2xl">All Applications</h1>
        <div class="flex max-w-[1140px] mx-auto justify-center mt-5">
            <section class="sticky top-5 w-full max-w-[400px] h-fit border bg-white border-gray-300 rounded p-5">
                @foreach ($applications as $application)
                <div onclick="window.location = '{{ route('my-application', ['id' => $application->id]) }}'" @class(["block border border-gray-300 rounded-md py-2 px-3 space-y-3 hover:bg-gray-50 cursor-pointer", "border-purple-500 bg-purple-50 hover:bg-purple-100" => $application->id == $selected_application->id])>
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
                @if ($selected_application)
                    <div class="py-3 px-5 space-y-5 border border-gray-300 rounded-md h-full bg-gray-100 flex flex-col">
                        <div>
                            <div class="border border-gray-200 px-3 py-2 flex items-center justify-between bg-white">
                                <div>
                                    <h4 class="font-medium">Your CV Document</h4>
                                    <a target="_blank" href="{{ route('user-cv-file') }}" class="text-blue-500 hover:underline hover:text-blue-800">{{ $selected_application->name }}</a>
                                </div>
                                <div>
                                    <p class="border border-gray-200 py-1 px-2">
                                        Size: <strong>{{ $selected_application->size }}</strong>
                                    </p>
                                    <p class="border border-gray-200 py-1 px-2">
                                        Type: <strong>{{ $selected_application->type }}</strong>
                                    </p>
                                </div>
                            </div>
                            <hr class="border-t border-gray-300 my-5 w-full">
                        </div>

                        <form class="flex items-center mx-auto w-full mt-auto">
                            <label for="voice-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 " viewBox="-2 -2 24 24"><path fill="currentColor" d="m5.72 14.456l1.761-.508l10.603-10.73a.456.456 0 0 0-.003-.64l-.635-.642a.443.443 0 0 0-.632-.003L6.239 12.635zM18.703.664l.635.643c.876.887.884 2.318.016 3.196L8.428 15.561l-3.764 1.084a.9.9 0 0 1-1.11-.623a.9.9 0 0 1-.002-.506l1.095-3.84L15.544.647a2.215 2.215 0 0 1 3.159.016zM7.184 1.817c.496 0 .898.407.898.909a.903.903 0 0 1-.898.909H3.592c-.992 0-1.796.814-1.796 1.817v10.906c0 1.004.804 1.818 1.796 1.818h10.776c.992 0 1.797-.814 1.797-1.818v-3.635c0-.502.402-.909.898-.909s.898.407.898.91v3.634c0 2.008-1.609 3.636-3.593 3.636H3.592C1.608 19.994 0 18.366 0 16.358V5.452c0-2.007 1.608-3.635 3.592-3.635z"/></svg>
                                </div>
                                <input type="text" id="voice-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Send Message for recruiter" required />
                                <button type="button" class="absolute inset-y-0 end-0 flex items-center pe-3">
                                    <svg class="w-4 h-4 text-gray-500  hover:text-gray-900 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7v3a5.006 5.006 0 0 1-5 5H6a5.006 5.006 0 0 1-5-5V7m7 9v3m-3 0h6M7 1h2a3 3 0 0 1 3 3v5a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V4a3 3 0 0 1 3-3Z"/>
                                    </svg>
                                </button>
                            </div>
                            <button type="submit" class="inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="16" height="16" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14L21 3m0 0l-6.5 18a.55.55 0 0 1-1 0L10 14l-7-3.5a.55.55 0 0 1 0-1z"/></svg>Send
                            </button>
                        </form>
                    </div>
                @endif
            </section>
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('myApplicationFunction', () => ({
            }))
        })
    </script>
</x-layout>