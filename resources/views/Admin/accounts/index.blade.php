@extends('Layout.admin_dashboard')

@section('title', 'Sales Transactions')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manage Accounts</title>
</head>
<body>

    <div class="overflow-x-auto rounded-lg p-6">
        <table class="min-w-full bg-white divide-y divide-gray-200 rounded-lg shadow-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Active Date till</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $item)
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $loop->iteration }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->username }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->email }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->role }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium {{ $item->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} ">{{ $item->status }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->active_date }}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="{{ route('accounts.edit', $item->id) }}" class="text-yellow-500 mr-3">Edit</a>
                            <a href="{{ route('accounts.show', $item->id) }}" class="text-blue-500 mr-3">Detail</a>

                            <!-- Delete Button -->
                            <form action="{{ route('accounts.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500" onclick="return confirm('Are you sure you want to delete this account?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
@endsection
