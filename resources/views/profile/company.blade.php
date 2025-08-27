
<x-layout>
    <x-slot:title>
        Company Info
    </x-slot>

    <div class="flex max-w-[1140px] mx-auto justify-center mt-5" x-data="companyFunction">
        <x-profile.profile-sidebar></x-profile.profile-sidebar>
        <section class="pl-6 w-full h-fit">
            <h2 class="text-2xl font-medium mb-5">Company Profile</h2>
            <div class="py-4 px-5 bg-white border border-gray-300 rounded-md w-full space-y-3"> 
                <p class="block mb-2 text-sm font-medium text-gray-900">Company Logo</p>
                <form method="POST" action="/company/update/{{ $company->id }}" enctype="multipart/form-data">
                    @csrf
                    @method("PATCH")
                    <div class="mb-5 space-y-3">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-28 h-28 border-2 border-gray-300 border-dashed rounded-full cursor-pointer bg-gray-50  hover:bg-gray-100 overflow-hidden">
                            <template x-if="imgSource">
                                <img class="w-full h-full object-cover" :src="imgSource" alt="preview image">
                            </template>
                            <template x-if="!imgSource">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-sm">
                                    <svg class="w-8 h-8 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <span class="text-xs">company logo</span>
                                </div>
                            </template>
                            <input id="dropzone-file" name="company_logo" type="file" class="hidden" x-ref="image_upload" x-on:change="previewImage" />
                        </label>
                        @error('company_logo')
                            <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                        @enderror
                    
                        <label for="company_name" class="block mb-2 text-sm font-medium text-gray-900">Company Name</label>
                        <input type="text" name="company_name" id="company_name" value="{{ $company->name }}" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full p-2.5 border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('title'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('title')]) placeholder="Your company title" required />
                        @error('company_name')
                            <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                        @enderror
                        <label for="company_email" class="block mb-2 text-sm font-medium text-gray-900 ">Company Email</label>
                        <input type="email" name="company_email" id="company_email" value="{{ $company->email }}" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full p-2.5 border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('email'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('email')]) placeholder="Your company email" required />
                        @error('company_email')
                            <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                        @enderror
                        
                        <label for="company_description" class="block mb-2 text-sm font-medium text-gray-900 ">Company Description</label>
                        <textarea id="company_description" name="company_description" rows="4"
                        @class(['block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('description'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('description')])
                        placeholder="Add company description...">{{ $company->description }}</textarea>
                        @error('company_description')
                            <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                        @enderror
                        <hr class="border-b border-gray-100">
                        <p class="block mb-2 text-sm font-medium text-gray-900">Additional Links</p>
                        <div>
                            <section class="flex items-center gap-x-2 py-2">
                                <label for="facebook_company_link" class="w-[3%] block text-sm font-medium text-gray-900" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95"/></svg></label>
                                <input type="text" name="facebook_company_link" value="{{ $links["facebook_link"] }}" id="facebook_company_link" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('facebook_company_link'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('facebook_company_link')]) placeholder="company facebook link" />
                            </section>
                            @error('facebook_company_link')
                                <p class="bg-red-500 text-red-50 py-2 px-5 rounded">{{ $message }}</p>
                            @enderror
                            <section class="flex items-center gap-x-2 py-2">
                                <label for="instagram_company_link" class="w-[3%] block text-sm font-medium text-gray-900" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13.028 2c1.125.003 1.696.009 2.189.023l.194.007c.224.008.445.018.712.03c1.064.05 1.79.218 2.427.465c.66.254 1.216.598 1.772 1.153a4.9 4.9 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428c.012.266.022.487.03.712l.006.194c.015.492.021 1.063.023 2.188l.001.746v1.31a79 79 0 0 1-.023 2.188l-.006.194c-.008.225-.018.446-.03.712c-.05 1.065-.22 1.79-.466 2.428a4.9 4.9 0 0 1-1.153 1.772a4.9 4.9 0 0 1-1.772 1.153c-.637.247-1.363.415-2.427.465l-.712.03l-.194.006c-.493.014-1.064.021-2.189.023l-.746.001h-1.309a78 78 0 0 1-2.189-.023l-.194-.006a63 63 0 0 1-.712-.031c-1.064-.05-1.79-.218-2.428-.465a4.9 4.9 0 0 1-1.771-1.153a4.9 4.9 0 0 1-1.154-1.772c-.247-.637-.415-1.363-.465-2.428l-.03-.712l-.005-.194A79 79 0 0 1 2 13.028v-2.056a79 79 0 0 1 .022-2.188l.007-.194c.008-.225.018-.446.03-.712c.05-1.065.218-1.79.465-2.428A4.9 4.9 0 0 1 3.68 3.678a4.9 4.9 0 0 1 1.77-1.153c.638-.247 1.363-.415 2.428-.465c.266-.012.488-.022.712-.03l.194-.006a79 79 0 0 1 2.188-.023zM12 7a5 5 0 1 0 0 10a5 5 0 0 0 0-10m0 2a3 3 0 1 1 .001 6a3 3 0 0 1 0-6m5.25-3.5a1.25 1.25 0 0 0 0 2.5a1.25 1.25 0 0 0 0-2.5"/></svg></label>
                                <input type="text" name="instagram_company_link" value="{{ $links["instagram_link"] }}" id="instagram_company_link" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('instagram_company_link'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('instagram_company_link')]) placeholder="company instagram link" />
                            </section>
                            @error('instagram_company_link')
                                <p class="bg-red-500 text-red-50 py-2 px-5 rounded">{{ $message }}</p>
                            @enderror
                            <section class="flex items-center gap-x-2 py-2">
                                <label for="twitter_company_link" class="w-[3%] block text-sm font-medium text-gray-900" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69c.88-.53 1.56-1.37 1.88-2.38c-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29c0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15c0 1.49.75 2.81 1.91 3.56c-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.2 4.2 0 0 1-1.93.07a4.28 4.28 0 0 0 4 2.98a8.52 8.52 0 0 1-5.33 1.84q-.51 0-1.02-.06C3.44 20.29 5.7 21 8.12 21C16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56c.84-.6 1.56-1.36 2.14-2.23"/></svg></label>
                                <input type="text" name="twitter_company_link" value="{{ $links["twitter_link"] }}" id="twitter_company_link" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('twitter_company_link'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('twitter_company_link')]) placeholder="company twitter link" />
                            </section>
                            @error('twitter_company_link')
                                <p class="bg-red-500 text-red-50 py-2 px-5 rounded">{{ $message }}</p>
                            @enderror
                            <section class="flex items-center gap-x-2 py-2">
                                <label for="website_company_link" class="w-[3%] block text-sm font-medium text-gray-900" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17.9 17.39c-.26-.8-1.01-1.39-1.9-1.39h-1v-3a1 1 0 0 0-1-1H8v-2h2a1 1 0 0 0 1-1V7h2a2 2 0 0 0 2-2v-.41a7.984 7.984 0 0 1 2.9 12.8M11 19.93c-3.95-.49-7-3.85-7-7.93c0-.62.08-1.22.21-1.79L9 15v1a2 2 0 0 0 2 2m1-16A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2"/></svg></label>
                                <input type="text" name="website_company_link"  value="{{ $links["website_link"] }}" id="website_company_link" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('website_company_link'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('website_company_link')]) placeholder="company website link" />
                            </section>
                            @error('website_company_link')
                                <p class="bg-red-500 text-red-50 py-2 px-5 rounded">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">Update</button>
                </form>
            </div>
        </section>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('companyFunction', () => ({

                imgSource: "{{ $company->logo_path != '' ? '/storage/'. $company->logo_path : null }}",

                previewImage() {
                    let file = this.$refs.image_upload.files[0];
                    if(!file || file.type.indexOf('image/') === -1) return;
                    this.imgSource = null;
                    let reader = new FileReader();

                    reader.onload = e => {
                        this.imgSource = e.target.result;
                    }

                    reader.readAsDataURL(file);
                },
            }))
        });

    </script>
</x-layout>