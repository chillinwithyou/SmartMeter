<x-layout>

    <h1>Bind Meter to User</h1>

    <form method="POST" action="#">

        <div class="d-flex flex-column">
            
            <label for="user_id">User ID</label>
            <input type="text" name="user_id" id="user_id" required>

            <label for="meter_id">Meter ID</label>
            <input type="text" name="meter_id" id="meter_id" required>

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>

    </form>

</x-layout>