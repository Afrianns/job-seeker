<x-layout>

    <x-slot:title>Detail Job</x-slot>
    
    <main class="p-6 lg:p-8 max-w-[1080px] mx-auto w-full" x-data="detailFunction" x-init="initialize">
        <div class="py-3 px-5 space-y-5">
            <a href="/" type="button" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-5 block w-fit">Back</a>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-medium">{{ $job->title }}</h1>
                @if (Auth::check() && !Auth::user()->is_recruiter || !Auth::check())
                    <a href="/" type="button" class="cursor-pointer text-red-500 hover:text-red-700 hover:underline font-medium rounded-lg text-sm">Report this job!</a>
                @endif
            </div>
            <div class="flex gap-x-2 items-center">
                <img src="{{ $company->logo_path ?? '/storage/companies_logo/no-logo.png' }}" class="w-10 h-10 bg-red-50 rounded-full" alt="company logo image">          
                <div class="flex flex-col">
                    <a href="{{ route('company', ['id' => $job->company->id]) }}" class="hover:underline">{{ $job->company->name }}</a>
                    @if ($job->company->verification()->exists())
                        @if ($job->company->verification->status == "approved")
                            <span class="text-xs text-gray-500">verified</span>
                        @endif
                    @else
                        <span class="text-xs text-gray-500">not verified</span>
                    @endif
                </div>
            </div>
                <ul class="flex gap-x-2 items-center">
                    <li class="text-gray-500">Displayed {{ Carbon\Carbon::now()->parse($job->created_at)->diffForHumans() }}</li>
                    <span class="w-1 h-1 bg-gray-600 rounded-full"></span>
                    <li class="text-gray-500">Updated {{ Carbon\Carbon::now()->parse($job->updated_at)->diffForHumans() }}</li>
                </ul>
            <p>{{ $job->description }}</p>
            <div class="flex gap-x-1 items-center text-sm">
                @foreach ($job->tags as $tag)
                    <p class="tag-style">{{ $tag->name }}</p>
                @endforeach
            </div>
        </div>

        @guest
            
            <div class="inline-flex items-center justify-center w-full">
                <hr class="border-t border-gray-300 m-5 w-full">
                <p class="absolute bg-[#f1f1ed] px-3 text-center text-gray-600 text-md">You need to <a class="text-purple-500 hover:text-purple-800 underline hover:no-underline" href="{{ route('login') }}">login</a> or <a class="text-purple-500 hover:text-purple-800 underline hover:no-underline" href="{{ route('register') }}">create account</a></p>
            </div>
        @endguest

        @if(Auth::check())
            @if (!Auth::user()->is_recruiter && $job->application()->exists())
                @if (Auth::user()->id == $job->application->first()->user_id)
                    <div class="px-5">
                        <span class="text-blue-500 hover:text-blue-700 hover:underline">Applied on {{ Carbon\Carbon::create($job->application->first()->created_at)->toDayDateTimeString() }}</span>
                    </div>
                @endif
            @endif

            <div class="px-5 flex justify-between items-center mt-5">
                <div class="flex items-center gap-x-2">
                    @if (Auth::check() && Auth::user()->is_recruiter)
                        <button type="button" id="edit_button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2" x-on:click="editing = !editing" x-text="editing ? 'Done':'Edit'" x-cloak></button>
                    @else
                        @if ($job->application()->exists() && Auth::user()->id == $job->application->first()->user_id)
                            <button type="button" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Check application status</button>
                        @else
                            <button data-modal-target="static-modal" data-modal-toggle="static-modal"  type="button" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Apply</button>
                        @endif
                    @endif
                </div>
                @if (Auth::user()->is_recruiter)
                    <button type="button" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
                @endif
            </div>
            <hr class="border-t border-gray-300 m-5">
            @if (Auth::user()->is_recruiter)         
                <div class="px-5" id="edit_form" x-show="editing" x-cloak>
                    <form method="POST" action="/job/update/{{ $job->id }}">
                        <h1 class="my-5 text-2xl">Update Job</h1>
                        @csrf
                        @method("PUT")
                        <div class="mb-5 space-y-5">
                            <section class="space-y-2">
                                <label for="job_title" class="block text-sm font-medium text-gray-900 ">Job Title</label>
                                <input type="text" value="{{ $job->title }}" name="title" id="job_title" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full p-2.5 border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('title'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('title')]) placeholder="your job title" required />
                                @error('title')
                                    <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                                @enderror
                            </section>
                            <section class="space-y-2">
                                <label for="description" class="block text-sm font-medium text-gray-900">Job Description</label>
                                
                                <textarea id="description" name="description" rows="5" 
                                @class(['block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('description'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('description')])
                                placeholder="add job description...">{{ $job->description }}</textarea>
                                @error('description')
                                    <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                                @enderror
                            </section>
                                
                            <section class="space-y-2">
                                <label for="tags" class="block text-sm font-medium text-gray-900 ">Job Tag</label>
                                <input type="text" x-ref="job_tag" :value="mappingTags({{ json_encode($job->tags) }})" name="tags" id="tags" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full p-2.5 border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('title'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('title')]) placeholder="your job title" />
                                @error('title')
                                    <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                                @enderror
                            </section>
                            <button type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update</button>
                        </div>
                    </form>
                </div>
            @endif
        
            @if (!Auth::user()->is_recruiter)
                <!-- Applying modal -->
                <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center bg-purple-50/50 items-center w-full h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <form action="{{ route('upload-user-cv-apply') }}" enctype="multipart/form-data" method="post">
                        @csrf
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow-sm ">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-gray-200">
                                    <h3 class="text-xl font-semibold text-gray-900">
                                        Apply to this Position!
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="static-modal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 space-y-4">
                                    <template x-if="!isUsingUploadMethod && isRelationExist">
                                        <div>
                                            <p class="text-base leading-relaxed text-gray-500 mb-5">
                                                Using your profile CV.
                                            </p>
                                            <x-display-file></x-display-file>
                                            <span x-on:click="useUploadCV" class="cursor-pointer mt-5 block text-red-500 hover:underline hover:text-red-800 text-right">Change CV</span>
                                        </div>
                                    </template>
                                    <template x-if="isUsingUploadMethod || !isRelationExist">
                                        <div>
                                            <p class="text-base leading-relaxed text-gray-500 mb-5">
                                                Using upload CV.
                                            </p>
                                            <div class="mb-5">
                                                <input name="cv_file" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('cv_file'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('cv_file')]) id="cv_file" type="file">
                                                @error('cv_file')
                                                <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <input type="hidden" name="job_id" value="{{ $job->id }}">
                                <!-- Modal footer -->
                                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b ">
                                    <button data-modal-hide="static-modal" type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Apply</button>
                                    <button data-modal-hide="static-modal" x-on:click="isUsingUploadMethod = false" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <x-deletePopup>
                    <form action="/job/delete/{{ $job->id }}" method="post">
                        @csrf
                        @method("DELETE")
                        <button data-modal-hide="popup-modal" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Yes, I'm sure
                        </button>
                    </form>
                </x-deletePopup>
            @endif
        @endif
    </main>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('detailFunction', () => ({

                editing: false,

                isUsingUploadMethod: false,

                isRelationExist: "{{ (Auth::check()) ? Auth::user()->documentCV()->exists() : '' }}",

                initialize() {
                    if(this.$refs.job_tag){
                        let tagify = new window.Tagify(this.$refs.job_tag, {
                            whitelist: @json($tags),
                            focusable: false,
                            dropdown: {
                                position: "input",
                                enabled : 0 // always opens dropdown when input gets focus
                            }
                        })
                    }
                },

                mappingTags(tags){
                    return tags.map((tag) => tag.name);
                },

                useUploadCV() {
                    this.isUsingUploadMethod = true;
                }
            }))
        })
    </script>
</x-layout>