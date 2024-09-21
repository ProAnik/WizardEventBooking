<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mb-4 max-w-7xl mx-auto  sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl text-white">Create Event</h1>
                    @if (session()->has('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                             role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @elseif (session()->has('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                             role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('wizard.event.store') }}">
                        @csrf
                        <!-- Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name')"/>
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                          :value="old('name')" required autofocus/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>

                        <!-- Text -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')"/>
                            <textarea id="description" name="description" :value="old('description')"
                                      class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                      rows="5" placeholder="Enter your text here..."></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                        </div>


                        <div class="mb-4">
                            <x-input-label for="date" :value="__('Date')"/>
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date"
                                          :value="old('date')" required autofocus/>
                            <x-input-error :messages="$errors->get('date')" class="mt-2"/>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="total_seats" :value="__('Total Seats')"/>
                            <x-text-input id="total_seats" class="block mt-1 w-full" type="number" min="1"
                                          name="total_seats" :value="old('total_seats')" required autofocus/>
                            <x-input-error :messages="$errors->get('total_seats')" class="mt-2"/>
                        </div>


                        <div class="flex items-center justify-end mt-4">

                            <x-primary-button class="ms-4">
                                Save
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl text-white">Event List</h1>
                    <div class="overflow-x-auto">
                        <table class="min-w-full dark:bg-gray-800 text-white bg-white border border-gray-300">
                            <thead>
                            <tr class="dark:bg-gray-800">
                                <th class="py-2 px-4 text-left border-b">Name</th>
                                <th class="py-2 px-4 text-left border-b">Description</th>
                                <th class="py-2 px-4 text-left border-b">Date</th>
                                <th class="py-2 px-4 text-left border-b">Total Seats</th>
                                <th class="py-2 px-4 text-left border-b">Available Seats</th>
                                <th class="py-2 px-4 text-left border-b">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($eventList as $event)
                                <tr class="dark:bg-gray-800 hover:bg-gray-600">
                                    <td class="py-2 px-4 border-b">{{ $event->name  }}</td>
                                    <td class="py-2 px-4 border-b">{{ $event->description }}</td>
                                    <td class="py-2 px-4 border-b">{{ $event->date }}</td>
                                    <td class="py-2 px-4 border-b">{{ $event->total_seats }}</td>
                                    <td class="py-2 px-4 border-b">{{ $event->available_seats }}</td>
                                    <th class="py-2 px-4 text-left border-b text-red-600 cursor-pointer">
                                        <form action="{{ route('wizard.event.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </th>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
