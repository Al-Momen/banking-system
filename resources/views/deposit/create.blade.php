<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Add New
        </h2>
    </x-slot>

    <div class="col-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (session('success'))
                    <x-span-text class="text-green-600">{{ session('success') }}</x-span-text>
                @endif

                @if (session('error'))
                    <x-span-text class="text-red-600">{{ session('error') }}</x-span-text>
                @endif

                <form method="post" action="{{ route('deposit.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <x-input-label for="user_id" :value="__('User Name')" />
                        <x-text-input id="user_id" name="user_id" type="text" min="0"
                            class="mt-1 block w-full" autofocus readonly autocomplete="user_id" value="{{Auth::user()->name}}"  />
                        <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                    </div>
                    <div>
                        <x-input-label for="amount" :value="__('Deposit Amount')" />
                        <x-text-input id="amount" name="amount" type="number" min="0"
                            class="mt-1 block w-full" required autofocus autocomplete="amount" />
                        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                    </div>
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
