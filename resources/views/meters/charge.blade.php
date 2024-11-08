<x-layout>

    <h1>Create new Charge</h1>

    <form method="POST" action="{{ route('new_charge') }}">
        @csrf

        <div class="d-flex flex-column">
            
            <label for="meter_id">Meter ID</label>
            <input type="text" name="meter_id" id="meter_id" required>

            <label for="Recharge Amount">Recharge Amount</label>
            <input type="text" name="charge_amount" id="charge_amount" required>

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>

    </form>

</x-layout>