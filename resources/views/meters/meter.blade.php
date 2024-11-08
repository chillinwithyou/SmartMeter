<x-layout>

    <h1>Create new Meter</h1>

    <form method="POST" action="{{ route('new_meter') }}">
        @csrf

        <div class="d-flex flex-column">

            <label for="meter_id">Meter ID</label>
            <input type="text" name="meter_id" id="meter_id" required>
            
            <label for="meter_name">Meter Name</label>
            <input type="text" name="meter_name" id="meter_name" required>

            <label for="meter_phone">Meter Phone</label>
            <input type="text" name="meter_phone" id="meter_phone">

            <label for="meter_note">Meter Note</label>
            <input type="text" name="meter_note" id="meter_note">

            <label for="price_id">Price ID</label>
            <input type="text" name="price_id" id="price_id" required>

            <label for="user_id">User ID (0 : not bounded)</label>
            <input type="text" name="user_id" id="user_id" value="0" placeholder="0 for not bounded">

            <label for="warmkwh">Kwh (Expected)</label>
            <input type="number" name="warmkwh" id="warmkwh" value="2" required>

            <label for="sellmin">Minimum Balance</label>
            <input type="number" name="sellmin" id="sellmin" value="2" required>

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>

    </form>

</x-layout>