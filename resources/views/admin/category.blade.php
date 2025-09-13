<x-admin-layout>
    <h1 class="title-style">Tags Page</h1>
    <div class="relative overflow-x-auto sm:rounded-lg my-5" x-data="categoryFunction">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 mb-5">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Tag Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Used (jobs)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Created By
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tags as $tag)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $tag->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $tag->total_used }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $tag->company->name }}
                        </td>
                        <td class="px-6 py-4">
                            <button class="font-medium text-red-600 cursor-pointer hover:underline" x-on:click="openModal = {id:'{{ $tag->id }}', 'type': 'delete'}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tags->links() }}
        <x-modal-confirm>
            <form action="{{ route('category-delete-post') }}" method="post">
                @csrf
                <input type="hidden" :value="openModal.id" name="id">
                <button type="submit" class="text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Yes, I'm sure
                </button>
            </form>
        </x-modal-confirm>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('categoryFunction', () => ({
                openModal: {
                    id: null,
                    type: null
                },
            }))
        })
    </script>
</x-admin-layout>