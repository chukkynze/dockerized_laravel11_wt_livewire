<div>
    <section class="mt-10">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between d p-4">
                    <div class="flex">
                        <div class=" left-0 flex pl-3">
                            <a href="{{ url('/projects') }}" class="flex button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                                    <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                                </svg>
                                Projects
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
                            <input
                                wire:model.live.debounce.300ms="searchTerm"
                                type="text"
                                   class="bg-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 "
                                   placeholder="Search" required="">
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <div class="flex space-x-2 items-center">
                            <label class="w-15 text-sm font-medium text-gray-900 dark:text-white">Status:</label>
                            <select
                                wire:model.live="projectStatusId"
                                class="bg-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">

                                <option class="text-sm font-medium text-gray-900 dark:text-white" value=0 placeholder="Choose..."></option>
                                @foreach($projectStatuses as $status)
                                    <option wire:key="{{ $status->getName() }}" class="text-sm font-medium text-gray-900 dark:text-white" value="{{$status->getId()}}">{{$status->getDisplayName()}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <div class="flex space-x-2 items-center">
                            <label class="w-15 text-sm font-medium text-gray-900 dark:text-white">Types:</label>
                            <select
                                wire:model.live="projectTypeId"
                                class="bg-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option class="text-sm font-medium text-gray-900 dark:text-white" value=0 placeholder="Choose..."></option>
                                @foreach($projectTypes as $type)
                                    <option wire:key="{{ $type->getName() }}" class="text-sm font-medium text-gray-900 dark:text-white" value="{{$type->getId()}}">{{$type->getDisplayName()}}</option>
                                @endforeach
                            </select>
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
                            <a href="{{ url('/projects/create') }}" class="button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM12.75 12a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V18a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V12Z" clip-rule="evenodd" />
                                    <path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    @if(session('success'))
                        <div class="p-5 w-full bg-gray-200 border text-green-700 font-weight-bold">
                            {{ session('success') }}
                        </div>
                    @elseif(session('failure'))
                        <div class="p-5 w-full bg-gray-200 border text-red-700 font-weight-bold">
                            {{ session('failure') }}
                        </div>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3" wire:click="setSortBy('name')">
                                <button class="flex items-center uppercase">
                                    name
                                    @include('livewire.includes.datatables.sortable-th-svgs', [
                                            'columnName' => 'name'
                                        ])
                                </button>
                            </th>
                            <th scope="col" class="px-4 py-3">type</th>
                            <th scope="col" class="px-4 py-3">status</th>
                            <th scope="col" class="px-4 py-3" wire:click="setSortBy('num tasks')">tasks</th>
                            <th scope="col" class="px-4 py-3" wire:click="setSortBy('created_at')">
                                <button class="flex items-center uppercase">
                                    began
                                    @include('livewire.includes.datatables.sortable-th-svgs', [
                                            'columnName' => 'created_at'
                                        ])
                                </button>
                            </th>
                            <th scope="col" class="px-4 py-3" wire:click="setSortBy('updated_at')">
                                <button class="flex items-center uppercase">
                                    changed
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
                        @foreach($projects as $project)
                            <tr wire:key="{{ $project->getUuid() }}" class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $project->getName() }}</th>
                                <td class="px-4 py-3 items-center">{{ $project->type->getDisplayName() }}</td>
                                @if($project->status->getDisplayName() == 'Done')
                                    <td class="px-4 py-3 items-center text-green-500">
                                @elseif($project->status->getDisplayName() == 'In Progress')
                                    <td class="px-4 py-3 items-center text-blue-500">
                                @else
                                    <td class="px-4 py-3 items-center text-red-500">
                                @endif
                                    {{$project->status->getDisplayName()}}</td>
                                <td class="px-4 py-3 items-center text-green-500">{{$project->tasks->count()}}</td>
                                <td class="px-4 py-3 items-center">
                                    <div>{{ $project->getCreatedAt()->format('M d, Y') }}</div>
                                    <div>{{ $project->getCreatedAt()->format('h:i:s') }}</div>
                                </td>
                                <td class="px-4 py-3 items-center">
                                    <div>{{ $project->getUpdatedAt()->format('M d, Y') }}</div>
                                    <div>{{ $project->getUpdatedAt()->format('h:i:s') }}</div>
                                </td>
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button  wire:click="edit('{{$project->getUuid()}}')"
                                             class="px-3 py-1 bg-blue-500 text-white rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                            <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                        </svg>
                                    </button>
                                    <button onclick="confirm('Are you sure you want to mark the {{ $project->getName() }} as deleted?') || event.stopImmediatePropagation() "
                                            wire:click="markDeleted('{{$project->getUuid()}}')"
                                            class="px-3 py-1 bg-red-500 text-white rounded">
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

                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
