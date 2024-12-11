<x-site-layout>
    <x-slot name="header">
        Create Contact
    </x-slot>
    <form action="{{ route('contact.store') }}" method="post" class="w-full space-y-6">
        @csrf
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                          :value="old('name')" required
                          autofocus/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>
        <div>
            <x-input-label for="contact" :value="__('Contact')"/>
            <x-text-input id="contact" class="block mt-1 w-full" type="text" name="contact"
                          :value="old('contact')"
                          required
                          autofocus/>
            <x-input-error :messages="$errors->get('contact')" class="mt-2"/>
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required
                          autofocus/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>
        <footer class="flex justify-end">
            <div class="isolate inline-flex rounded-md shadow-sm">
                <a href="{{ route('home') }}"
                   class="relative inline-flex items-center rounded-l-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                        class="block rounded-r-md z-10 bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    {{ __('Save') }}
                </button>
            </div>
        </footer>
    </form>

</x-site-layout>
