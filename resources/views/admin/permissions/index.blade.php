<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Permisos
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <a href="{{ route('admin.permissions.create') }}" class="btn btn-blue text-xs">Nuevo</a>
    </div>

    <div class="relative overflow-x-auto mt-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acción
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $permission->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $permission->name }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-blue text-xs">Editar</a>
                                
                                <form class="confirm" action="{{ route('admin.permissions.destroy', $permission) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-red text-xs">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $permissions->links() }}
    </div>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.confirm').forEach(function(form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: 'No podrás revertir esta acción',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                });
            });
        </script>        
    @endpush
</x-layouts.app>