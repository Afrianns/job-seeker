<x-admin-layout>
        <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 ">
        <ul class="flex flex-wrap -mb-px">
            <li class="me-2">
                <a href="{{ route('verification-in-review') }}" class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active  " aria-current="page">In Review</a>
            </li>
            <li class="me-2">
                <a href="{{ route('verification-submission') }}" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 -300">Submission for Approval</a>
            </li>
        </ul>
    </div>
    <div x-data="inReviewFunction"  id="main">
        <h2 class="title-style">Companies Document In Review</h2>
        <div class="relative overflow-x-auto sm:rounded-lg my-5">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Company Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Documents
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Account Created
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Detail
                        </th>
                        <th scope="col" class="px-6 py-3">
                            action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies_document as $company)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                            <td  class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $company->name }}
                            </td>
                            <td class="px-6 py-4">
                                the Lorem ipsum dolor, sit?
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('company-verification-file') }}" class="hover:underline text-blue-500">
                                    {{ $company->verification->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                {{ carbon\Carbon::create($company->created_at)->toFormattedDayDateString() }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('company-detail', ['id' => $company->id]) }}" class="font-medium text-blue-600  hover:underline">Company Detail</a>
                            </td>
                            <td class="px-6 py-4 flex gap-x-3">
                                <span x-on:click="openModal = {id:'{{ $company->id }}', type: 'approved'}" class="cursor-pointer font-medium text-blue-600  hover:underline">Approved</span>
                                <span x-on:click="openModal = {id: '{{ $company->id }}', type: 'rejected'}" class="cursor-pointer font-medium text-red-600  hover:underline">Rejected</span>
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
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('inReviewFunction', () => ({
                openModal: {
                    id: null,
                    type: null
                },
            }))
        })
    </script>
</x-admin-layout>