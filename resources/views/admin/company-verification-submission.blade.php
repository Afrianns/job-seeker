<x-admin-layout>
    
    <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400">
        <ul class="flex flex-wrap -mb-px">
            <li class="me-2">
                <a href="{{ route('verification-in-review') }}" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">In Review</a>
            </li>
            <li class="me-2">
                <a href="{{ route('verification-submission') }}" class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500" aria-current="page">Submission for Approval</a>
            </li>
        </ul>
    </div>

    <h2 class="title-style">Companies Document For Review</h2> 
    <div class="relative overflow-x-auto sm:rounded-lg my-5" x-data="submissionFunction">
        @if ($companies_document->count() > 0)
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Company Logo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Company Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Account Created
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Detail
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies_document as $company)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <img src="{{ $company->logo_path ?? '/storage/companies_logo/no-logo.png' }}" class="w-10 h-10 bg-red-50" alt="company logo image">
                            </th>
                            <td class="px-6 py-4">
                                {{ $company->name }}
                            </td>
                            <td class="px-6 py-4">
                                the Lorem ipsum dolor, sit?
                            </td>
                            <td class="px-6 py-4">
                                {{ carbon\Carbon::create($company->created_at)->toFormattedDayDateString() }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('company-detail', ['id' => $company->id]) }}" class="font-medium text-blue-600  hover:underline">Company Detail</a>
                            </td>

                            <td class="px-6 py-4">
                                <button class="text-blue-500 hover:underline cursor-pointer" x-on:click="openModal = {id:'{{ $company->id }}', type: 'review'}">Review This</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing <span class="font-semibold text-gray-900">1-10</span> of <span class="font-semibold text-gray-900">1000</span></span>
                <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">2</a>
                    </li>
                    <li>
                        <a href="#" aria-current="page" class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700">3</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">4</a>
                    </li>
                    <li>
                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
                    </li>
                </ul>
            </nav>
        @else
            <div class="space-y-5">
                <img src="/illustration/no-data.svg" class="w-44 h-44 mx-auto" alt="">
                <p class="text-xl text-center text-gray-500">There is no company document submitted</p>
            </div>
        @endif
        <x-modal-confirm>
            <form action="{{ route('verification-submission-post') }}" method="post">
                @csrf
                <input type="hidden" :value="openModal.id" name="id">
                <input type="hidden" :value="openModal.type" name="type">
                <button type="submit" class="text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Yes, I'm sure
                </button>
            </form>
        </x-modal-confirm>
    </div>
     <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('submissionFunction', () => ({
                openModal: {
                    id: null,
                    type: null
                },
            }))
        })
    </script>
</x-admin-layout>