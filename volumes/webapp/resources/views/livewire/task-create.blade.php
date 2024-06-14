
<div>
    <section class="mt-10">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between d p-4">
                    <div class="flex">
                        <div class=" left-0 flex pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM12.75 12a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V18a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V12Z" clip-rule="evenodd" />
                                <path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                            </svg>&nbsp;Tasks
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <div class="flex space-x-2 items-center">
                            <a href="{{ url('/') }}" class="button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                    <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                                </svg>
                            </a>
                            <a href="{{ url('/tasks') }}" class="button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                                    <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex-grow border-t border-gray-400"></div>
                <div class="overflow-x-auto w-full p-5">

                    @if(session('success'))
                        <div class="p-5 w-full bg-gray-200 border text-green-700 font-weight-bold">
                            {{ session('success') }}
                        </div>
                    @elseif(session('failure'))
                        <div class="p-5 w-full bg-gray-200 border text-red-700 font-weight-bold">
                            {{ session('failure') }}
                        </div>
                    @endif

                    <form class="" wire:submit.prevent="submitForm" action="#">

                        <div class="flex flex-wrap p-5 w-full">
                            <div class="flex w-40">
                                <label for="name">Name: </label>
                            </div>
                            <div class="flex-wrap w-80">
                                <input wire:model='form.name'
                                       id="name"
                                       class="bg-gray-500 border border-gray-300 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                                       type="text"
                                       placeholder="The task's name">
                                <div class="flex w-full">
                                    @error('form.name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex w-full justify-end p-5">
                            <button class="px-3 py-1 bg-blue-500 text-white rounded">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
