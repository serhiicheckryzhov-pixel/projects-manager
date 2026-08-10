<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">


                <form method="POST" action="{{ route('projects.update', ['project' => $project->id]) }}">
                    @csrf
                    @method('PATCH')
                    <div>
                        <div>
                            <x-input-label for="name" :value="__('Project Name')" />
                            <x-text-input id="name" class="block mt-1 max-w-md" type="text" name="name" value="{{$project->name}}" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Project Description')" />
                            <x-textarea id="description" class="block mt-1 max-w-md" name="description" />
                        </div>
                    </div>



                    <div class="mt-4">
                        <x-primary-button>
                            {{ __('Add') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
