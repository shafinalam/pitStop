<x-layout>
    <x-slot:heading>
        History Page
    </x-slot:heading>

    <section class="text-center">
        <form action="" class="mt-6">
            <input type="text" placeholder="Search books, authors & texts..." class="text-center rounded-xl px-5 py-4 w-full max-w-xl">
        </form>
    </section>

    <div class="pt-10 space-y-4">
        @foreach ($books as $book)
            <a href="/books/{{ $book['id'] }}" class="block hover:bg-gray-200 transition-colors duration-300 px-4 py-6 border border-gray-200 rounded-xl">
                <strong>{{ $book['book_name'] }}</strong> by <i>{{ $book['author'] }}</i>
                <div class="font-light text-sm">
                    {{ $book['text'] }}
                </div>
            </a>
        @endforeach
    </div>

</x-layout>
