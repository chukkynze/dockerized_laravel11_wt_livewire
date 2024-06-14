<div class="relative w-full">
    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
             fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                  clip-rule="evenodd"/>
        </svg>
    </div>
    <input wire:model.live="searchProjectTerm"
           wire:keydown.escape="resetDropdown"
           wire:keydown.tab="resetDropdown"
           wire:change="resetDropdown"
           type="text"
           class="bg-gray-500 border border-gray-300 text-white text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2"
           placeholder="Filter for a Project"
    />

    @if(strlen($searchProjectTerm) >= 2)

        @if(!empty($results))
            <div class="absolute z-50 list-group bg-gray-700 text-sm text-white rounded w-[30rem]">
                @foreach($results as $result)
                    <a href="" class="list-item text-white px-3 py-3 w-[30rem] hover:bg-gray-100 hover:text-gray-500">
                        <span class="">{{ $result['name'] }}</span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="absolute z-50 list-item bg-gray-700 text-sm text-white rounded w-full">
                No results.
            </div>
        @endif

    @endif
</div>
