<div class="p-4" x-data="{ showform: false }">
    <div class="overflow-y-auto h-full grid gap-4">
        @foreach ($messages as $message)
            @php
                $photo = $message->user->profile_photo_path
                    ? Storage::url($message->user->profile_photo_path)
                    : $message->user->profile_photo_url;

            @endphp
            <div x-data="{ show: false }"
                class="flex {{ $message->user->id == Auth::user()->id ? 'flex-row-reverse' : '' }} gap-2.5 ">
                <img class="w-8 h-8 rounded-full" src="{{ $photo }}" alt="{{ Auth::user()->name }}">

                <div
                    class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 {{ $message->user->id == Auth::user()->id ? ' rounded-s-xl rounded-ee-xl' : 'rounded-e-xl rounded-es-xl' }} dark:bg-gray-700">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            @if ($message->user->id == Auth::user()->id)
                                You
                            @else
                                {{ $message->user->name }}
                            @endif
                        </span>
                        <span
                            class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $message->created_at }}</span>
                    </div>
                    <p id="message-{{ $message->id }}"
                        class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">{{ $message->message }}</p>
                    <div>
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                            @if ($message->user->id == Auth::user()->id)
                                Sended
                            @else
                                Received
                            @endif
                        </span>
                        <span
                            class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <button @click="show = !show"
                    class="inline-flex self-end items-center mb-2 p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600"
                    type="button">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path
                            d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>
                </button>
                <div x-show="show" @click.outside="show = false"
                    class="z-10 bg-white rounded divide-y divide-gray-100 rounded-lg shadow w-30 h-20  dark:bg-gray-700 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-2 text-sm flex flex-col gap-2 text-gray-700 dark:text-gray-200">
                        <li>
                            <button onclick="copymessage({{ $message->id }})"
                                class="block px-4 py-1 w-full hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Copy</button>
                        </li>
                        <script>
                            function copymessage(id) {
                                navigator.clipboard.writeText(document.getElementById('message-' + id).textContent);
                                document.getElementById('copy-alert').classList.remove('hidden');
                                setTimeout(() => {
                                    document.getElementById('copy-alert').classList.add('hidden');
                                }, 1700);
                            }
                        </script>
                        @if ($message->user->id == Auth::user()->id)
                            <li>
                                <button wire:click="deletemessage({{ $message->id }})"
                                    class="block px-4 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</button>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
    <button @click="showform = !showform" x-show="!showform"
        class="p-3 fixed bottom-5 left-2 text-gray-800 hover:text-black dark:hover:text-black bg-gray-200 dark:bg-white rounded-full"><svg
            xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-send"
            viewBox="0 0 16 16">
            <path
                d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z" />
        </svg></button>
    <form wire:submit.prevent="sendMessage" x-show="showform" @click.outside="showform = false"
        class=" flex gap-2  fixed bottom-0 left-0 right-0 bg-gray-500 mx-8 mb-2 rounded-xl p-4">
        <input type="text" wire:model="message" class="border py-2 rounded h-10 w-[95%]"
            placeholder="Type your message...">
        <button type="submit" class=" bg-blue-500 text-white px-4 py-2  h-10 rounded">Send</button>
    </form>

    <div id="copy-alert" class="hidden fixed bottom-4 right-4 bg-green-500  text-white py-2 px-4 rounded shadow-lg">
        Teks berhasil disalin!
    </div>
</div>
