<div>
    <section class="mt-10">
        <div class="mx-auto px-4 lg:px-12 box-content">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between d p-4">
                    <div class="flex">
                        <div class=" left-0 flex pl-3">
                            <a href="{{ url('/tasks') }}" class="flex button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                                </svg>
                                Tasks
                            </a>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                     fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="searchTerm"
                                   id="task-search-term"
                                   type="text"
                                   class="bg-gray-500 border border-gray-300 text-white text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 "
                                   placeholder="Search Tasks..." required=""
                            />
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <div class="flex space-x-2 items-center">
                            @livewire('search-projects')
{{--                            --}}
{{--                            <select--}}
{{--                                wire:model.live="projectId"--}}
{{--                                class="bg-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">--}}
{{--                                <option class="text-sm font-medium text-gray-900 dark:text-white" value=0 placeholder="Choose..."></option>--}}
{{--                                @foreach($projects as $project)--}}
{{--                                    <option wire:key="{{ $type->getName() }}" class="text-sm font-medium text-gray-900 dark:text-white" value="{{$type->getId()}}">{{$type->getDisplayName()}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
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
                            <a href="{{ url('/tasks/create') }}" class="button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M6 3a3 3 0 0 0-3 3v2.25a3 3 0 0 0 3 3h2.25a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H6ZM15.75 3a3 3 0 0 0-3 3v2.25a3 3 0 0 0 3 3H18a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3h-2.25ZM6 12.75a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h2.25a3 3 0 0 0 3-3v-2.25a3 3 0 0 0-3-3H6ZM17.625 13.5a.75.75 0 0 0-1.5 0v2.625H13.5a.75.75 0 0 0 0 1.5h2.625v2.625a.75.75 0 0 0 1.5 0v-2.625h2.625a.75.75 0 0 0 0-1.5h-2.625V13.5Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3" wire:click="setSortBy('project_name')">
                                <button class="flex items-center uppercase">
                                    Project
                                </button>
                            </th>
                            <th scope="col" class="px-4 py-3" wire:click="setSortBy('name')">
                                <button class="flex items-center uppercase">
                                    What to do
                                    @include('livewire.includes.datatables.sortable-th-svgs', [
                                            'columnName' => 'name'
                                        ])
                                </button>
                            </th>
                            <th scope="col" class="px-4 py-3">Start</th>
                            <th scope="col" class="px-4 py-3">Due&nbsp;By</th>
                            <th scope="col" class="px-4 py-3" wire:click="setSortBy('priority')">
                                <button class="flex items-center uppercase">
                                    priority
                                    @include('livewire.includes.datatables.sortable-th-svgs', [
                                            'columnName' => 'priority'
                                        ])
                                </button>
                            </th>
                            <th scope="col" class="px-4 py-3" wire:click="setSortBy('created_at')">
                                <button class="flex items-center uppercase">
                                    Created
                                    @include('livewire.includes.datatables.sortable-th-svgs', [
                                            'columnName' => 'created_at'
                                        ])
                                </button>
                            </th>
                            <th scope="col" class="px-4 py-3" wire:click="setSortBy('updated_at')">
                                <button class="flex items-center uppercase">
                                    updated
                                    @include('livewire.includes.datatables.sortable-th-svgs', [
                                            'columnName' => 'updated_at'
                                        ])
                                </button>
                            </th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr wire:key="{{ $task->getUuid() }}" class="border-b dark:border-gray-700">
                                <th scope="row" class="px-4 py-3">{{ $task->project->getName() }}</th>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $task->getName() }}</td>
                                <td class="px-4 py-3 items-center text-green-500">{{ $task->getStartDt() }}</td>
                                <td class="px-4 py-3 items-center text-red-500">{{ $task->getDueByDt() }}</td>
                                <td class="px-4 py-3 items-center text-blue-500">{{$task->getPriority()}}</td>
                                <td class="px-4 py-3 items-center">
                                    <div>{{ $task->getCreatedAt()->format('Y-m-d') }}</div>
                                    <div>{{ $task->getCreatedAt()->format('h:i:s') }}</div>
                                </td>
                                <td class="px-4 py-3 items-center">
                                    <div>{{ $task->getUpdatedAt()->format('Y-m-d') }}</div>
                                    <div>{{ $task->getUpdatedAt()->format('h:i:s') }}</div>
                                </td>
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button class="px-3 py-1 bg-blue-500 text-white rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                            <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                        </svg>
                                    </button>
                                    <button onclick="confirm('Are you sure you want to mark the {{ $task->getName() }} as deleted?') || event.stopImmediatePropagation() " wire:click="delete('{{$task->getUuid()}}')" class="px-3 py-1 bg-red-500 text-white rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="py-4 px-3">
                    <div class="flex ">
                        <div class="flex space-x-4 items-center mb-3">
                            <label class="w-32 text-sm font-medium text-gray-900 dark:text-white">Per Page</label>
                            <select
                                wire:model.live="perPage"
                                class="bg-gray-500 border border-gray-300 text-sm font-medium text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option class="text-sm font-medium text-gray-900 dark:text-white" value="5">5</option>
                                <option class="text-sm font-medium text-gray-900 dark:text-white" value="10">10</option>
                                <option class="text-sm font-medium text-gray-900 dark:text-white" value="20">20</option>
                                <option class="text-sm font-medium text-gray-900 dark:text-white" value="50">50</option>
                                <option class="text-sm font-medium text-gray-900 dark:text-white" value="100">100</option>
                            </select>
                        </div>
                    </div>

                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
