<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="p-4 sm:p-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-start items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Withdraws') }}
                    </h2>
                    <x-dropdown-link :href="route('withdrawal.create')" style="width: fit-content;">
                        <x-primary-button>
                            {{ __('New Withdraw') }}
                        </x-primary-button>
                    </x-dropdown-link>
                </div>
                <x-table :items="$data"/>
            </div>
        </div>
    </div>
</x-app-layout>


