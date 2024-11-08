<x-layout>

    <h1>Create new User</h1>

    <form method="POST" action="{{ route('new_user') }}">
        @csrf

        <div class="d-flex flex-column">

            <label for="name">Tenant Name</label>
            <input type="text" name="name" id="name">
            
            <label for="username">Tenant Username</label>
            <input type="text" name="username" id="username">

            <label for="phone">Tenant Phone</label>
            <input type="text" name="phone" id="phone">

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>

    </form>

</x-layout>