<x-site-layout>
    <div x-data class="px-4 sm:px-6 lg:px-8 w-full">
        <x-slot name="header">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold text-gray-900 dark:text-white dark:text-white">Contacts</h1>
                </div>
                @can('create',\App\Models\Contact::class)
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a href="{{ route('contact.create') }}"
                           class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Add contact
                        </a>
                    </div>
                @endcan
            </div>
        </x-slot>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                        <thead>
                        <tr>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-0">
                                Name
                            </th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                Contact
                            </th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Email
                            </th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @foreach($contacts as $contact)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-0">
                                    {{$contact->name}}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">
                                    {{$contact->contact}}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">
                                    {{$contact->email}}
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0 dark:text-gray-300 divide-x divide-gray-300 dark:divide-gray-700">
                                    @can('view',$contact)
                                        <a href="{{ route('contact.show',$contact) }}"
                                           class="text-indigo-600 hover:text-indigo-900">View<span
                                                class="sr-only">, {{$contact->name}}</span></a>
                                    @endcan
                                    @can('update',$contact)
                                        <a href="{{ route('contact.edit',$contact) }}"
                                           class="text-indigo-600 hover:text-indigo-900">Edit<span
                                                class="sr-only">, {{$contact->name}}</span></a>
                                    @endcan
                                    @can('delete',$contact)
                                        <button x-on:click="$deleteModal(@js(route('contact.destroy',$contact)))">
                                            Deletar
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-6">
                        {{$contacts->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-site-layout>
