<x-layout>
    <x-slot:heading>
        Home Page
    </x-slot:heading>
    <h1>Greetings, Sonic! Here's the home page</h1>
    <form method="POST" action="/books">
        @csrf
        <div class="space-y-12">
            <div class="scroll-pb-12">
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <x-form-field>
                        <x-form-label for="Name of the Book">Name of the Book</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="book_name" id="book_name" placeholder="e.g. Bad Blood, Atomic Habits, Normal People" required />
                            <x-form-error name="book_name" />
                        </div>
                    </x-form-field>

                    <x-form-field>
                        <x-form-label for="Author of the Book">Author of the Book</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="author" id="author" placeholder="e.g. John Carreyrou, James Clear, Sally Rooney" required />
                            <x-form-error name="author" />
                        </div>
                    </x-form-field>

                    <x-form-field>
                        <x-form-label for="The portion of the book you want to convert to speech">The portion of the book you want to convert to speech</x-form-label>
                        <div class="mt-2">
                            <textarea name="text" id="text" rows="3" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Enter text & turn into reality!" required></textarea>
                            <x-form-error name="text" />
                        </div>
                    </x-form-field>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm/6 font-semibold text-gray-900">Cancel</button>
            <x-form-button type="button" id="playButton">Play</x-form-button>
            <x-form-button>Save</x-form-button>
        </div>
    </form>

    <audio id="audioPlayer" controls style="display: none;"></audio>

    <script>
        document.getElementById('playButton').addEventListener('click', function () {
            let text = document.getElementById('text').value;
            if (!text.trim()) {
                alert('Please enter some text.');
                return;
            }

            fetch('/tts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ text: text })
            })
                .then(response => response.blob())
                .then(blob => {
                    let audioUrl = URL.createObjectURL(blob);
                    let audioPlayer = document.getElementById('audioPlayer');
                    audioPlayer.src = audioUrl;
                    audioPlayer.style.display = 'block';
                    audioPlayer.play();
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

</x-layout>
