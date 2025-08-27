
<x-layout>
    <x-slot:title>
        Profile Info
    </x-slot>

    <div class="flex max-w-[1140px] mx-auto justify-center mt-5" x-data="profileFunction">
        <x-profile.profile-sidebar></x-profile.profile-sidebar>
        <section class="pl-6 w-full h-fit">
            <h2 class="mb-5 text-2xl font-medium">{{ $title }}</h2>
            <div class="py-4 px-5 bg-white border border-gray-300 rounded-md w-full space-y-3">
                <form method="POST" action="/profile/update/{{ Auth::user()->id }}" enctype="multipart/form-data">
                    @csrf
                    @method("PATCH")
                    <div class="mb-5 space-y-3">
                        <h3 class="block mb-2 text-sm font-medium text-gray-900">Profile Image</h3>
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-28 h-28 border-2 border-gray-300 border-dashed rounded-full cursor-pointer bg-gray-50  hover:bg-gray-100 overflow-hidden">
                            <template x-if="imgSource">
                                <img class="w-full h-full object-cover" :src="imgSource" alt="preview image">
                            </template>
                            <template x-if="!imgSource">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-sm">
                                    <svg class="w-8 h-8 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <span class="text-xs">profile image</span>
                                </div>
                            </template>
                            <input id="dropzone-file" name="profile_image" type="file" class="hidden" x-ref="image_upload" x-on:change="previewImage" />
                        </label>
                        <label for="job_name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                        <input type="text" value="{{ Auth::user()->name }}" name="name" id="job_name" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full p-2.5 border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('name'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('name')]) placeholder="your job name" required />
                        @error('name')
                            <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                        @enderror

                        <label for="job_email" class="block mb-2 text-sm font-medium text-gray-900 ">Email</label>
                        <input type="email" value="{{ Auth::user()->email }}" name="email" id="job_email" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full p-2.5 border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('title'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('title')]) placeholder="your job title" required />
                        @error('email')
                            <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">Update</button>
                </form>
            </div>
            {{ $upload_cv ?? '' }}
        </section>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('profileFunction', () => ({

                imgSource: `{{ Auth::user()->avatar_path != '' ? '/storage/'. Auth::user()->avatar_path : null }}`,

                previewImage() {
                    let file = this.$refs.image_upload.files[0];
                    if(!file || file.type.indexOf('image/') === -1) return;
                    this.imgSource = null;
                    let reader = new FileReader();

                    reader.onload = e => {
                        this.imgSource = e.target.result;
                    }

                    reader.readAsDataURL(file);
                
                }
            }))
        });

    </script>

</x-layout>