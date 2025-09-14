<section class="sticky top-5 h-fit text-gray-900 bg-white border border-gray-300 rounded-lg max-w-[400px] w-full">
    <a href="{{ route('profile') }}" type="button" @class(["relative inline-flex items-center w-full px-8 py-5 text-md font-medium border-b border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-2 focus:ring-purple-700 focus:text-purple-700", "bg-gray-100 text-purple-700" => request()->routeIs("profile")])>
        <svg class="w-5 h-5 me-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M16 9a4 4 0 1 1-8 0a4 4 0 0 1 8 0m-2 0a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/><path d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11s11-4.925 11-11S18.075 1 12 1M3 12c0 2.09.713 4.014 1.908 5.542A8.99 8.99 0 0 1 12.065 14a8.98 8.98 0 0 1 7.092 3.458A9 9 0 1 0 3 12m9 9a8.96 8.96 0 0 1-5.672-2.012A6.99 6.99 0 0 1 12.065 16a6.99 6.99 0 0 1 5.689 2.92A8.96 8.96 0 0 1 12 21"/></g></svg>
        Profile
    </a>
    @if (Auth::user()->is_recruiter)
        <a href="{{ route('company-profile-update') }}" type="button" @class(["relative inline-flex items-center w-full px-8 py-5 text-md font-medium border-b border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-2 focus:ring-purple-700 focus:text-purple-700", "bg-gray-100 text-purple-700" => request()->routeIs("company-profile-update")])>
            <svg class="w-5 h-5 me-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M18 15h-2v2h2m0-6h-2v2h2m2 6h-8v-2h2v-2h-2v-2h2v-2h-2V9h8M10 7H8V5h2m0 6H8V9h2m0 6H8v-2h2m0 6H8v-2h2M6 7H4V5h2m0 6H4V9h2m0 6H4v-2h2m0 6H4v-2h2m6-10V3H2v18h20V7z"/></svg>
            Company
        </a>
        <a type="button" href="{{ route('company-verification-info') }}" @class(["relative inline-flex items-center w-full px-8 py-5 text-md font-medium border-b border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-2 focus:ring-purple-700 focus:text-purple-700", "bg-gray-100 text-purple-700" => request()->routeIs("company-verification-info")])>
            <svg class="w-5 h-5 me-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="m17.275 20.25l3.475-3.45l-1.05-1.05l-2.425 2.375l-.975-.975l-1.05 1.075zM6 9h12V7H6zm12 14q-2.075 0-3.537-1.463T13 18t1.463-3.537T18 13t3.538 1.463T23 18t-1.463 3.538T18 23M3 22V3h18v8.675q-.475-.225-.975-.375T19 11.075V5H5v14.05h6.075q.125.775.388 1.475t.687 1.325L12 22l-1.5-1.5L9 22l-1.5-1.5L6 22l-1.5-1.5zm3-5h5.075q.075-.525.225-1.025t.375-.975H6zm0-4h7.1q.95-.925 2.213-1.463T18 11H6zm-1 6.05V5z"/></svg>
            Company Verification
        </a>
    @endif
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" class="relative inline-flex items-center w-full px-8 py-5 text-md font-medium border-b border-red-200 hover:bg-red-100 hover:text-red-700 focus:z-10 focus:ring-2 focus:ring-red-700 focus:text-red-700 cursor-pointer">
            <svg class="w-5 h-5 me-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M5 22a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3h-2V4H6v16h12v-2h2v3a1 1 0 0 1-1 1zm13-6v-3h-7v-2h7V8l5 4z"/></svg>
            Logout
        </button>
    </form>
</section>