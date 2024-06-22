<div>
    <section class="mt-10">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between d p-4">
                    <div class="flex">
                        <div class=" left-0 flex pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M6 3a3 3 0 0 0-3 3v2.25a3 3 0 0 0 3 3h2.25a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H6ZM15.75 3a3 3 0 0 0-3 3v2.25a3 3 0 0 0 3 3H18a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3h-2.25ZM6 12.75a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h2.25a3 3 0 0 0 3-3v-2.25a3 3 0 0 0-3-3H6ZM17.625 13.5a.75.75 0 0 0-1.5 0v2.625H13.5a.75.75 0 0 0 0 1.5h2.625v2.625a.75.75 0 0 0 1.5 0v-2.625h2.625a.75.75 0 0 0 0-1.5h-2.625V13.5Z" />
                            </svg>&nbsp;Tasks {{ ($task->getUuid() ? ": Editing " . $task->getName() : ": Creating " . $this->name) }}
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
                                    <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
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

                    <form class="" wire:submit.prevent="{{ ($task->getUuid() ? 'update' : 'create') }}" action="#">
                        @if($task->getUuid()) <input id="uuid" name="uuid" type="hidden" value="{{ $task->getUuid() }}"> @endif

                        <div class="flex flex-wrap p-5 w-full">
                            <div class="flex w-40">
                                <label for="name">Name: </label>
                            </div>
                            <div class="flex-wrap w-80">
                                <input wire:model='name'
                                       id="name"
                                       class="bg-gray-500 border border-gray-300 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                                       type="text"
                                       placeholder="The task's name">
                                <div class="flex w-full">
                                    @error('name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap p-5 w-full">
                            <div class="flex w-40">
                                <label for="project_id">Project: </label>
                            </div>
                            <div class="flex-wrap w-auto">
                                <select wire:model='project_id'
                                        id="project_id"
                                        class="bg-gray-500 border border-gray-300 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                    <option class="text-sm font-medium text-white dark:text-white" value=0>Choose...</option>
                                    @foreach($projects as $project)
                                        <option wire:key="{{ $project->getId() }}" class="text-sm font-medium text-gray-900 dark:text-white" value={{$project->getId()}}>{{$project->getName()}}</option>
                                    @endforeach
                                </select>
                                <div class="flex w-full">
                                    @error('project_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap p-5 w-full">
                            <div class="flex w-40">
                                <label for="priority">Priority: </label>
                            </div>
                            <div class="flex-wrap w-80">
                                <input wire:model='priority'
                                       id="priority"
                                       class="bg-gray-500 border border-gray-300 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                                       type="number"
                                       placeholder="The priority as a number">
                                <div class="flex w-full">
                                    @error('priority')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap p-5 w-full">
                            <div class="flex w-40">
                                <label for="start_dt">Start Date: </label>
                            </div>
                            <div class="flex-wrap w-80">
                                <x-input.date wire:model="start_dt"
                                              id="start_dt"
                                              class="bg-gray-500 border border-gray-300 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                                              :error="$errors->first('start_dt')" />
                                <div class="flex w-full">
                                    @error('start_dt')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap p-5 w-full">
                            <div class="flex w-40">
                                <label for="due_by_dt">Due By Date: </label>
                            </div>
                            <div class="flex-wrap w-80">
                                <x-input.date wire:model="due_by_dt"
                                              id="due_by_dt"
                                              class="bg-gray-500 border border-gray-300 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                                              :error="$errors->first('due_by_dt')" />
                                <div class="flex w-full">
                                    @error('due_by_dt')
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
