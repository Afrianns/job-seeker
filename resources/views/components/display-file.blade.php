<div class="py-4 px-5 bg-white border border-gray-300 rounded-md w-full space-y-3">
    <div class="border border-gray-200 px-3 py-2 flex items-center justify-between">
        <div>
            <h4 class="font-medium">Your CV Document</h4>
            <a target="_blank" href="{{ route('user-cv-file') }}" class="text-blue-500 hover:underline hover:text-blue-800">{{ Auth::user()->documentCV->name }}</a>
        </div>
        <div>
            <p class="border border-gray-200 py-1 px-2">
                Size: <strong>{{ Auth::user()->documentCV->size }}</strong>
            </p>
            <p class="border border-gray-200 py-1 px-2">
                Type: <strong>{{ Auth::user()->documentCV->type }}</strong>
            </p>
        </div>
    </div>
</div>