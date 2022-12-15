<div>
    <div class="card-header">
        <div class="px-6 py-4">
            <input type="text" class="form-control" wire:model="search"
                placeholder="ingrese el nombre o el correo del usuario que desea buscar" />
        </div>
    </div>
    <div class="card-body">
        @if (count($customers))
            <table class="table">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th scope="col">
                            @lang('Full Name')
                        </th>
                        <th scope="col">
                            @lang('E-mail')
                        </th>
                        <th>
                            @lang('Action')
                        </th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($customers as $customer)
                        {{-- Para que Livewire, haga un mejor seguimiento de cada fila, le asignamos un identificador unico
                        a cada fila, para este coso es el email, asi: --}}
                        <tr wire:key="{{ $customer->email }}">
                            <td>
                                {{ $customer->name }}
                            </td>
                            <td>
                                {{ $customer->email }}
                            </td>
                            <td>
                                <a href="{{ route('admin.customers.show', [$customer->id]) }}" class='btn btn-default'>
                                    <i class="far fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="py6 px-4">
                No hay registros coincidentes
            </div>
        @endif

        @if ($customers->hasPages())
            <div class="py-6 px-4">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>
