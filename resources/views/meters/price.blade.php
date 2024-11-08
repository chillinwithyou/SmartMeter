<x-layout>

    <h1>Create new Price</h1>

    <form method="POST" action="{{ route('new_price') }}">
        @csrf

        <div class="d-flex flex-column">
            
            <label for="price_name">Price Name</label>
            <input type="text" name="price_name" id="price_name" required>

            <label for="price_amount">Price Amount</label>
            <input type="text" name="price_amount" id="price_amount" required>

            <label for="price_note">Price Note</label>
            <input type="text" name="price_note" id="price_note">

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>

    </form>

</x-layout>