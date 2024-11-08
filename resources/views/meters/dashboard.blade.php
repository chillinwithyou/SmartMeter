<x-layout>
    <h1>Dashboard</h1>

    <table class="table table-light">
        <thead>
            <th>User ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>Tel</th>
            <th>Actions</th>
        </thead>

        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user['Station_index'] }}</td>
                    <td>{{ $user['adminID'] }}</td>
                    <td>{{ $user['Name'] }}</td>
                    <td>{{ $user['Tel'] }}</td>
                    <td>
                        <div class="d-flex flex-row justify-content-between">
                            <a href="{{ route('userUsage', $user['adminID'] ) }}" class="btn btn-primary">Details</a>
                            <form method="POST" action="{{ route('delete_user', $user['adminID']) }}">
                                @csrf
                                @method("DELETE")

                                <button class="btn btn-danger">Delete</button>

                            </form>
                        </div>
                        
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

</x-layout>

