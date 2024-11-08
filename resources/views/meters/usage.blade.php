<x-layout>

    <h1>Usage</h1>

    <table class="table table-light">
        <thead>
            <th>Name</th>
            <th>Usage up-to-date</th>
            <th>Balance</th>
        </thead>

        <tbody>
            <td>{{ $username }}</td>
            <td>{{ $summary['useKwh'] }}</td>
            <td>{{ $summary['sellMoney_e'] - $summary['useKwh'] }}</td>

        </tbody>

    </table>



    <table class="table table-light">
        <thead>
            <th>Usage ID</th>
            <th>Time</th>
            <th>Usage Kwh</th>
            <th>Usage Price</th>
        </thead>

        <tbody>
            @foreach($usages as $usage)
                <tr>
                    <td>{{ $usage['dK'] }}</td>
                    <td>{{ $usage['dF'] }}</td>
                    <td>{{ $usage['uk'] }}</td>
                    <td>{{ $usage['p'] }}</td>
                </tr>

            @endforeach

        </tbody>

    </table>

    <div class="d-flex flex-row justify-content-between">
        <a href="{{ route('userUsage', $userId) }}?start={{ Carbon\Carbon::parse($start)->subMonth()->firstOfMonth()->format("Y-m-d") }}&end={{ Carbon\Carbon::parse($start)->subMonth()->endOfMonth()->format("Y-m-d") }}" class="btn btn-primary">
            Previous
        </a>

        <a href="{{ route('userUsage', $userId) }}?start={{ Carbon\Carbon::parse($start)->addMonth()->firstOfMonth()->format("Y-m-d") }}&end={{ Carbon\Carbon::parse($start)->addMonth()->endOfMonth()->format("Y-m-d") }}" class="btn btn-primary">
            Next
        </a>

    </div>

</x-layout>