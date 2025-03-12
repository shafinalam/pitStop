<x-layout>
    <x-slot:heading>
        Edit Entry | {{ $book->book_name }} by {{ $book->author }}
    </x-slot:heading>
    <form method="POST" action="/books/{{ $book->id }}">
        @csrf
        @method('PATCH')
        <div class="space-y-12">
            <div class="sm:col-span-4">
                <label for="Name of the book" class="block text-sm/6 font-medium text-gray-900">Name of the Book</label>
                <div class="mt-2">
                    <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                        <input
                            type="text"
                            name="book_name"
                            id="book_name"
                            class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6"
                            placeholder="e.g. Bad Blood, Atomic Habits, Normal People"
                            value="{{ $book->book_name }}"
                            required>
                    </div>
                    @error('book_name')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="sm:col-span-4">
                <label for="Author of the book" class="block text-sm/6 font-medium text-gray-900">Author of the Book</label>
                <div class="mt-2">
                    <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                        <input
                            type="text"
                            name="author"
                            id="author"
                            class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6"
                            placeholder="e.g. John Carreyrou, James Clear, Sally Rooney"
                            value="{{ $book->author }}"
                            required>
                    </div>
                    @error('author')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col-span-full">
                <label for="The portion of the book you want to convert to speech" class="block text-sm/6 font-medium text-gray-900">The portion of the book you want to convert to speech</label>
                <div class="mt-2">
                    <textarea
                        name="text"
                        id="text"
                        rows="3"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        placeholder="Enter text & turn into reality!"
                        required>{{ $book->text }}</textarea>
                    @error('text')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-between gap-x-6">
            <div class="flex items-center">
                <button form="delete-form" class="text-red-500 text-sm font-bold">Delete</button>
            </div>


            <div class="flex items-center gap-x-6">
                <a href="/books/{{ $book->id }}" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
                <div>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
                </div>
            </div>
        </div>
    </form>

    <form method="POST" action="/books/{{ $book->id }}" id="delete-form" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</x-layout>
