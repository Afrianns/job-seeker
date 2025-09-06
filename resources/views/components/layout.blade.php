<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Job Portal - {{ $title ?? "main" }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <script defer src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#f1f1ed] text-[#1b1b18] mb-5 min-h-[90vh] h-full">
        <div class="bg-white h-fit w-full border border-gray-300">
            <div class="max-w-[1140px] mx-auto my-7 flex justify-between items-center max-lg:mx-5">
                <a class="flex items-center gap-x-1" href="/">
                    <h1 class="text-2xl font-bold">Recreeti</h1>
                    @auth
                        @if (Auth::user()->is_recruiter)
                            <span class="bg-purple-200 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm">Recruiter</span>
                        @endif
                    @endauth
                    @if (Auth::guard("admin")->check())
                        <span class="bg-gray-200 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm">admin</span>
                    @endif
                </a>
                @auth
                    <ul class="flex gap-x-2 items-center">
                        @if (Auth::user()->is_recruiter)
                            <li class="hover:underline cursor-pointer"><a href="{{ route('reported-job-posted') }}" class="{{ request()->routeIs('reported-job-posted') ? 'underline' : '' }}">Reported Jobs</a></li>
                            <li class="hover:underline cursor-pointer"><a href="{{ route('new-job') }}" class="{{ request()->routeIs('new-job') ? 'underline' : '' }}">New Job</a></li>
                            <li class="hover:underline cursor-pointer"><a href="{{ route('user-jobs-applications.jobs') }}" class="{{ request()->routeIs('user-jobs-applications.*') ? 'underline' : '' }}">Applicants</a></li>
                        @else
                            <li class="hover:underline cursor-pointer"><a href="{{ route('my-application') }}" class="{{ request()->routeIs('my-application') ? 'underline' : '' }}">My Applications</a></li>
                        @endif
                        <li class="hover:underline cursor-pointer font-bold text-lg"><a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'underline' : '' }}">{{ Str::title(Auth::user()->name) }}</a></li>
                    </ul>
                @endauth
                @guest
                <ul class="flex gap-x-2 items-center">
                        @if (Auth::guard("admin")->check())
                            <li class="hover:underline font-medium text-lg">{{ Auth::guard('admin')->user()->email }}</li>
                        @else
                            <li class="hover:underline cursor-pointer"><a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'underline' : '' }}">Register</a></li>
                            <li class="hover:underline cursor-pointer"><a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'underline' : '' }}">Login</a></li>
                        @endif
                    </ul>
                @endguest
            </div>
        </div>
        {{$slot }}
        @session('success')
            <section class="fixed bottom-0 right-5 w-full">
            <div id="toast-success" class="flex items-center ml-auto w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm " role="alert">
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg  ">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <span class="sr-only">Check icon</span>
            </div>
            <div class="ms-3 text-sm font-normal">{{ $value }}</div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#toast-success" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </section>
        @endsession
        @session('error')
            <section class="fixed bottom-0 right-5 w-full">
            <div id="toast-danger" class="flex items-center ml-auto w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm" role="alert">
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg  ">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                    </svg>
                    <span class="sr-only">Error icon</span>
                </div>
                <div class="ms-3 text-sm font-normal">{{ $value }}</div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#toast-danger" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </section>
        @endsession
    </body>
</html>