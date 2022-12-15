<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Usuarios
        </h2>
    </x-slot>

    <div class="container py-12">

            <div class="px-6 py-4">
                <input type="text" class="form-control" wire:model="search"
                    placeholder="ingrese el nombre o el correo del usuario que desea buscar" />
            </div>

            @if (count($users))
                <table class="table">
                    <thead class="table-dark">
                        <tr class="text-center">
                            {{-- <th scope="col">
                                Id
                            </th> --}}
                            <th scope="col">
                                Nombre
                            </th>
                            <th scope="col">
                                Email
                            </th>
                            <th scope="col">
                                Rol
                            </th>
                            <th scope="col">
                                <span>Editar</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($users as $user)
                            {{-- Para que Livewire, haga un mejor seguimiento de cada fila, le asignamos un identificador unico
                            a cada fila, para este coso es el email, asi: --}}
                            <tr wire:key="{{ $user->email }}">
                                {{-- <td>
                                    <div>
                                        {{ $user->id }}
                                    </div>
                                </td> --}}
                                <td>
                                    <div class="text-sm">
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    <div class="text-sm">
                                        @if ($user->type == 'customer')
                                            Cliente
                                        @else
                                            Visitante
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <label>
                                        <input {{ count($user->roles) ? 'checked' : '' }} value="1" type="radio" name="{{ $user->email }}"
                                            wire:change="assignRole({{ $user }}, $event.target.value)" /> Cliente
                                    </label>
                                    <label>
                                        <input {{ count($user->roles) ? '' : 'checked' }} value="0" type="radio" name="{{ $user->email }}"
                                            wire:change="assignRole({{ $user }}, $event.target.value)"/> Visitante
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                        <!-- More people... -->
                    </tbody>
                </table>
            @else
                <div class="py6 px-4">
                    No hay registros coincidentes
                </div>
            @endif

            @if ($users->hasPages())
                <div class="py-6 px-4">
                    {{ $users->links() }}
                </div>
            @endif
    </div>
</div>