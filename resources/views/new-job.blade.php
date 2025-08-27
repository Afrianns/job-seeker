<x-layout>
    <x-slot:title>New Job</x-slot>
    <div class=" w-full max-w-[1140px] mx-auto" x-data="newJobFunction" x-init="initialize">
        <h1 class="my-5 text-2xl">Create New Job</h1>
        <section class="mt-5 h-fit border bg-white border-gray-300 rounded p-5">
            <form method="POST" action="{{ route('new-job-post') }}">
                @csrf
                <div class="mb-5 space-y-3">
                    <label for="job_title" class="block mb-2 text-sm font-medium text-gray-900 ">Job Title</label>
                    <input type="text" name="title" id="job_title" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full p-2.5 border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('title'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('title')]) placeholder="your job title" required />
                    @error('title')
                        <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                    @enderror
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 ">Job Description</label>
                    <textarea id="description" name="description" rows="4"
                    @class(['block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('description'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('description')])
                    placeholder="add job description..."></textarea>
                    @error('description')
                        <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                    @enderror
                    <label for="tags" class="block mb-2 text-sm font-medium text-gray-900 ">Job Tag</label>
                    <input type="text" x-ref="job_tag" name="tags" id="tags" class='bg-gray-50 text-gray-900 text-sm rounded-lg block w-full p-2.5 border focus:ring-blue-500 focus:border-blue-500 border-gray-300' placeholder="your job tag" />
                </div>
                <button type="submit" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">Create</button>
            </form>
        </section>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('newJobFunction', () => ({

                initialize() {
                    var tagify = new window.Tagify(this.$refs.job_tag, {
                    whitelist: @json($tags),
                    focusable: false,
                    dropdown: {
                        position: "input",
                        enabled : 0 // always opens dropdown when input gets focus
                        }
                    })
                },

                toggle() {
                    this.open = ! this.open
                },
            }))
        })
    </script>
</x-layout>