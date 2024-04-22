<x-app-layout>
    <x-slot name="header"><div class="flex flex-row justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Teachers') }}
        </h2>
        <a href="{{ route('admin.teachers.index') }}"
            class="font-bold py-2 px-4 bg-gray-700 hover:bg-gray-800 text-white rounded-md">
            Back
        </a>
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">

                <form method="POST" action="{{ route('admin.teachers.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" autofocus autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center mt-4">
            
                        <button type="submit" class="font-bold py-2 px-4 bg-indigo-700 text-white rounded-md">
                            Add New Teacher
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
