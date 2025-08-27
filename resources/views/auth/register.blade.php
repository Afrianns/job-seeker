
<x-layout>
    <x-slot:title>
        Register
    </x-slot>
    <div class="max-w-[1140px] mx-auto mt-5 flex flex-col justify-center items-center min-h-[calc(100vh-150px)]" x-data="registerFunction">
        <h2 class="text-center mb-5 text-2xl font-medium">Register</h2>
        <form action="/auth/register" method="POST" class="py-6 px-5 bg-white border border-gray-300 rounded-md w-full max-w-[500px] space-y-5 mx-auto">
            @csrf
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Your Name</label>
                <input type="text" name="name" id="name" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full p-2.5 border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('name'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('name')]) placeholder="type your name." required />
                @error('name')
                    <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                <input type="email" name="email" id="email" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full p-2.5 border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('email'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('email')]) placeholder="name@example.com" required />
                @error('email')
                    <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Your password</label>
                <input type="password" name="password" id="password" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full p-2.5 border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('password'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('password')]) required />
                @error('password')
                    <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Repeat your password</label>
                <input type="password" name="repeat_password" id="password" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full p-2.5 border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('repeat_password'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('repeat_password')]) required />
                @error('repeat_password')
                    <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-start mb-5">
                <div class="flex items-center h-5">
                <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-purple-300 offset-gray-800" required />
                </div>
                <label for="remember" class="ms-2 text-sm font-medium text-gray-900">Remember me</label>
            </div>
            <div class="flex gap-x-5 items-center">
                <button type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Register</button>
                <a href="/login" class="text-purple-700 hover:text-purple-800 hover:underline">Login</a>
            </div>
        </form>
    </div>
    <script>
        
        document.addEventListener('alpine:init', () => {
            Alpine.data('registerFunction', () => ({
            }))
        })
    </script>
</x-layout>