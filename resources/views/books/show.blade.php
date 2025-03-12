<x-layout>
    <x-slot:heading>
        {{ $book->book_name }} | {{ $book->author }}
    </x-slot:heading>

    <div class="space-y-4">
        <p>{{ $book->text }}</p>
    </div>
    <p class="mt-6">
        <x-button href="/books/{{ $book->id }}/edit">Edit</x-button>
    </p>
</x-layout>
