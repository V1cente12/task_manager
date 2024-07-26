<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $task->description}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">     
                    <div x-data="{ showPopup: false }" class="bg-white">
                        <form id="markTaskForm" method="POST" action="{{ route('mark-task', ['task_id' => $task->id, 'user_id' => $user->id]) }}">
                            @csrf
                            <button @click.prevent="showPopup = true" type="button" class="mt-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                                Marcar como Tarea realizada
                            </button>
                        </form>
                    
                        <div x-show="showPopup" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75" x-transition>
                            <div class="bg-white p-4 rounded-lg shadow-lg">
                                <h2 class="text-lg font-semibold">¿Estás seguro?</h2>
                                <button @click="document.getElementById('markTaskForm').submit()" class="mt-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                                    Zi
                                </button>
                                <button @click="showPopup = false" class="mt-4 px-4 py-2 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75">
                                    No
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">
                                        Usuario
                                    </th>
                                    <th class="py-2 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">
                                        Completada el
                                    </th>
                                    <th class="py-2 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">
                                        Validada por
                                    </th>
                                    <th class="py-2 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">
                                        Validada el
                                    </th>
                                    <th class="py-2 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">
                                        Validar
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($shifts as $shift)
                                    <tr>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            {{ $shift->user->name }}
                                        </td>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            {{ date('H:i d-m-y', strtotime($shift->completed_at)) }}
                                        </td>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            {{ $shift->validator->name ?? 'N/A' }}
                                        </td>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            {{ $shift->validated_at ? date('H:i d-m-y', strtotime($shift->validated_at)) : 'N/A' }}
                                        </td>                                        
                                        <td class="py-2 px-4 border-b border-gray-200" x-data="{ showPopup: false }">
                                            @if (!isset($shift->validator->name))
                                                <div x-data="{ showPopup: false }" class="bg-white">
                                                    <form id="validateShiftForm" method="POST" action="{{ route('validate-shift', ['task_id' => $task->id, 'user_id' => $user->id, 'shift_id' => $shift->id]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button @click.prevent="showPopup = true" class="px-4 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">
                                                            Validar
                                                        </button>
                                                    </form>
                                                    <div x-show="showPopup" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75" x-transition>
                                                        <div class="bg-white p-4 rounded-lg shadow-lg">
                                                            <h2 class="text-lg font-semibold">Estás seguro que quieras validar esta tarea?</h2>
                                                            <button @click="document.getElementById('validateShiftForm').submit()" class="mt-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                                                                Zi
                                                            </button>
                                                            <button @click="showPopup = false" class="mt-4 px-4 py-2 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75">
                                                                No
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <button @click.prevent="showPopup = true" class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75">
                                                    Validar
                                                </button>
                                                <div x-show="showPopup" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75" x-transition>
                                                    <div class="bg-white p-4 rounded-lg shadow-lg">
                                                        <h2 class="text-lg font-semibold">Este registro ya fue validado</h2>
                                                        <button @click="showPopup = false" class="mt-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                                                            Cerrar
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>