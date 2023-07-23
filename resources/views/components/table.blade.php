@props(['items' => [], 'index' => 0])
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    <x-span-text>#SL</x-span-text>
                </th>
                <th scope="col" class="px-6 py-3">
                    <x-span-text>ID</x-span-text>
                </th>
                <th scope="col" class="px-6 py-3">
                    <x-span-text>Name</x-span-text>
                </th>
                <th scope="col" class="px-6 py-3">
                    <x-span-text>Transaction Type</x-span-text>
                </th>
                <th scope="col" class="px-6 py-3">
                    <x-span-text>Balance</x-span-text>
                </th>
                <th scope="col" class="px-6 py-3">
                    <x-span-text>Amount</x-span-text>
                </th>
                <th scope="col" class="px-6 py-3">
                    <x-span-text>Fees</x-span-text>
                </th>
                <th scope="col" class="px-6 py-3">
                    <x-span-text>Date</x-span-text>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $items)
                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                    <td class="px-6 py-4">
                        <x-span-text>{{ $index = $index + 1 }}</x-span-text>
                    </td>
                    <td class="px-6 py-4">
                        <x-span-text>{{ $items->id }}</x-span-text>
                    </td>
                    <td class="px-6 py-4">
                        <x-span-text>{{ $items->user->name ?? 'N/A' }}</x-span-text>
                    </td>
                    <td class="px-6 py-4">
                        <x-span-text>{{ $items->transaction_type ?? 'N/A' }}</x-span-text>
                    </td>
                    <td class="px-6 py-4">
                        <x-span-text>{{ $items->user->balance ?? 'N/A' }}</x-span-text>
                    </td>
                    <td class="px-6 py-4">
                        <x-span-text>{{ $items->amount ?? 'N/A' }}</x-span-text>
                    </td>
                    <td class="px-6 py-4">
                        <x-span-text>{{ $items->fee ?? 'N/A' }}</x-span-text>
                    </td>
                    <td class="px-6 py-4">
                        <x-span-text>{{ $items->date ?? 'N/A' }}</x-span-text>
                    </td>

                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan='50'>No Data Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
