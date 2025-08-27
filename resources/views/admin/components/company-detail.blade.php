<x-admin-layout>
    <h1 class="title-style">Company Detail</h1>
    <div class="space-y-5"  x-data="companyDetailFunction">
        <section class="py-3 px-5 bg-white border border-gray-300 rounded-md w-full space-y-5">
            <img src="{{ $company->logo_path ?? '/storage/companies_logo/no-logo.png' }}" class="w-24 h-24 bg-red-50 rounded-full mx-auto" alt="company logo image">
            <div class="text-center">
                <h2 class="text-xl font-medium">{{ $company->name }}</h2>
                <span class="text-sm text-gray-600">Not yet verified</span>
            </div>
            
            @if ($company->description)
                <p class="text-md">{{ $company->description }}</p>
            @else    
                <p class="text-md italic text-gray-400">Sorry There isn't any description regarding this company</p>
            @endif

            <div class="flex gap-x-3 items-center">
                @if ($company->link()->exists())
                    @if ($company->link->facebook_link)
                        <a href="{{ $company->link->facebook_link }}" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95"/></svg>
                        </a>
                    @endif
                                    
                    @if ($company->link->instagram_link)
                        <a href="{{ $company->link->instagram_link }}" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path d="M13.028 2c1.125.003 1.696.009 2.189.023l.194.007c.224.008.445.018.712.03c1.064.05 1.79.218 2.427.465c.66.254 1.216.598 1.772 1.153a4.9 4.9 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428c.012.266.022.487.03.712l.006.194c.015.492.021 1.063.023 2.188l.001.746v1.31a79 79 0 0 1-.023 2.188l-.006.194c-.008.225-.018.446-.03.712c-.05 1.065-.22 1.79-.466 2.428a4.9 4.9 0 0 1-1.153 1.772a4.9 4.9 0 0 1-1.772 1.153c-.637.247-1.363.415-2.427.465l-.712.03l-.194.006c-.493.014-1.064.021-2.189.023l-.746.001h-1.309a78 78 0 0 1-2.189-.023l-.194-.006a63 63 0 0 1-.712-.031c-1.064-.05-1.79-.218-2.428-.465a4.9 4.9 0 0 1-1.771-1.153a4.9 4.9 0 0 1-1.154-1.772c-.247-.637-.415-1.363-.465-2.428l-.03-.712l-.005-.194A79 79 0 0 1 2 13.028v-2.056a79 79 0 0 1 .022-2.188l.007-.194c.008-.225.018-.446.03-.712c.05-1.065.218-1.79.465-2.428A4.9 4.9 0 0 1 3.68 3.678a4.9 4.9 0 0 1 1.77-1.153c.638-.247 1.363-.415 2.428-.465c.266-.012.488-.022.712-.03l.194-.006a79 79 0 0 1 2.188-.023zM12 7a5 5 0 1 0 0 10a5 5 0 0 0 0-10m0 2a3 3 0 1 1 .001 6a3 3 0 0 1 0-6m5.25-3.5a1.25 1.25 0 0 0 0 2.5a1.25 1.25 0 0 0 0-2.5"/></svg>
                        </a>
                    @endif

                    @if ($company->link->twitter_link)
                        <a href="{{ $company->link->twitter_link }}" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69c.88-.53 1.56-1.37 1.88-2.38c-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29c0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15c0 1.49.75 2.81 1.91 3.56c-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.2 4.2 0 0 1-1.93.07a4.28 4.28 0 0 0 4 2.98a8.52 8.52 0 0 1-5.33 1.84q-.51 0-1.02-.06C3.44 20.29 5.7 21 8.12 21C16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56c.84-.6 1.56-1.36 2.14-2.23"/></svg>
                        </a>
                    @endif
                    
                    @if ($company->link->website_link)
                        <a href="{{ $company->link->website_link }}" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path fill="currentColor" d="M17.9 17.39c-.26-.8-1.01-1.39-1.9-1.39h-1v-3a1 1 0 0 0-1-1H8v-2h2a1 1 0 0 0 1-1V7h2a2 2 0 0 0 2-2v-.41a7.984 7.984 0 0 1 2.9 12.8M11 19.93c-3.95-.49-7-3.85-7-7.93c0-.62.08-1.22.21-1.79L9 15v1a2 2 0 0 0 2 2m1-16A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2"/></svg>
                        </a>
                    @endif
                @endif
            </div>
        </section>
        @if ($company->verification->status != "waiting")
            <section class="py-3 px-5 bg-white border border-gray-300 rounded-md w-full space-y-2">
                <h3 class="text-xl my-3">Document for Verifying Company</h3>
                <div class="flex justify-between items-center">
                    <p class="font-bold">Document Verification</p>
                    <a href="{{ route('company-verification-file') }}" class="hover:underline text-blue-500">
                        {{ $company->verification->name }}
                    </a>
                </div>
                <div class="flex justify-between items-center">
                    <p class="font-bold">Document Type</p>
                    <p>
                        {{ $company->verification->type }}
                    </p>
                </div>
                <div class="flex justify-between items-center">
                    <p class="font-bold">Document Size</p>
                    <p>
                        {{ $company->verification->size }}
                    </p>
                </div>
            </section>
            <section>
                <button x-on:click="openModal = {id:'{{ $company->id }}', type: 'approved'}"  type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Approved</button>
                <button x-on:click="openModal = {id:'{{ $company->id }}', type: 'rejected'}"  type="button" class="text-white bg-red-500 border border-red-300 focus:outline-none hover:bg-red-300 focus:ring-4 focus:ring-red-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Rejected</button>
            </section>
            <x-modal-confirm>
                <form action="{{ route('verification-in-review-post') }}" method="post">
                    @csrf
                    <input type="hidden" :value="openModal.id" name="id">
                    <input type="hidden" :value="openModal.type" name="type">
                    <button type="submit" class="text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                </form>
            </x-modal-confirm>
        @endif
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('companyDetailFunction', () => ({
                openModal: {
                    id: null,
                    type: null
                },
            }))
        })
    </script>
</x-admin-layout>