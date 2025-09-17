<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Role Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Nama</label>
                        <input type="text" value="{{ $user->name }}" disabled
                               class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100 dark:bg-gray-700">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Email</label>
                        <input type="text" value="{{ $user->email }}" disabled
                               class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100 dark:bg-gray-700">
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block font-semibold mb-2">Role</label>
                        <select name="role" id="role"
                                class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700">
                            <option value="Member" {{ $user->role == 'Member' ? 'selected' : '' }}>Member</option>
                            <option value="Officer" {{ $user->role == 'Officer' ? 'selected' : '' }}>Officer</option>
                            <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.users') }}"
                           class="px-4 py-2 bg-gray-500 text-white rounded mr-2 hover:bg-gray-600">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
