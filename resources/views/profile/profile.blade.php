<x-profile.profile-edit>
    <x-slot:title>Profile</x-slot>

    <x-slot:upload_cv>
        <div class="py-4 px-5 bg-white border border-gray-300 rounded-md w-full space-y-3 mt-5">
            @if (Auth::user()->documentCV()->exists())
                <x-display-file></x-display-file>
            @else
                <x-form-upload-cv route-name="upload-user-cv" />
            @endif
        </div>
    </x-slot>
</x-profile.profile-edit>