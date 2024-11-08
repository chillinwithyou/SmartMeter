<x-layout>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="d-flex flex-column">


        
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <input type="submit">
        </div>

    </form>

</x-layout>