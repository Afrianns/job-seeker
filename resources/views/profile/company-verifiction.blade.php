
<x-layout>
    <x-slot:title>
        Company Verification Info
    </x-slot>

    <div class="flex max-w-[1140px] mx-auto justify-center mt-5" x-data="verificationFunction">
        <x-profile.profile-sidebar></x-profile.profile-sidebar>
        <section class="pl-6 w-full h-fit">
            <h2 class="text-2xl font-medium mb-5">Company Verification Info</h2>
            @if ($company->verification()->doesntExist())
                <div class="py-4 px-5 bg-white border border-gray-300 rounded-md w-full space-y-3">
                    <form action="{{ route('upload-company-verifiction-file') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="mb-5">
                            <label class="block mb-2 text-md font-medium text-gray-900" for="file_approval">Document Verification</label>
                            <input name="file_approval" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('file_approval'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('file_approval')]) id="file_approval" type="file">
                            @error('file_approval')
                            <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Submit</button>
                    </form>
                </div>
            @endif
            @if ($company->verification()->exists())
                <div class="py-4 px-5 bg-white border border-gray-300 rounded-md w-full space-y-3">
                    <div class="border border-gray-200 px-3 py-2 flex items-center justify-between">
                        <div>
                            <h4 class="font-medium">Company Document</h4>
                            <a href="{{ route('company-verification-file', basename($company->verification->document_path)) }}" class="text-blue-500 hover:underline hover:text-blue-800">{{ $company->verification->name }}</a>
                        </div>
                        <div>
                            <p class="border border-gray-200 py-1 px-2">
                                Size: <strong>{{ $company->verification->size }}</strong>
                            </p>
                            <p class="border border-gray-200 py-1 px-2">
                                Type: <strong>{{ $company->verification->type }}</strong>
                            </p>
                        </div>
                    </div>
                    <p class="border border-gray-200 py-1 px-2">Status: 
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-gray-300">{{ $company->verification->status }}</span>    
                    </p>
                    @if ($company->verification->status == "waiting")
                        <a href="#" class="mt-5 text-red-500 hover:underline hover:text-red-800 text-right">Delete</a>
                    @endif
                </div>
                <p class="mt-2">Note: You only able to upload one document, you can't update document when status become: <strong>under-review</strong>.</p>
            @else
                <p class="text-center">
                    No document has send.    
                </p>    
            @endif
        </section>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('verificationFunction', () => ({

            }))
        });

    </script>
</x-layout>