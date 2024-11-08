<x-layout>
    <h1>Meters List</h1>

    <table class="table table-light">
        <thead class="sticky-top">
            <th>Meter ID</th>
            <th>Meter Name</th>
            <th>
                Type 
                <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-html="true" data-bs-title="0: Prepaid<br>1: Postpaid">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                    </svg>
                </span>
            </th>
            <th>Group ID</th>
            <th>Price ID</th>
            <th>Balance (kWh)</th>
            <th>Used (kWh)</th>
            <th>Temp (Celcius)</th>
            <th>Signal</th>
            <th>
                Status Code
                <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-html="true" data-bs-title="1: Offline meter<br>2: Offline<br>3: Online and On<br>4: Online but Off<br>5: Pending<br>6: Retrieving<br>7: Error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                    </svg>
                </span>
            </th>
            <th>Issue(s)</th>
            <th>Actions</th>
        </thead>

        <tbody>
            @foreach($meters as $meter)
                <tr>
                    <td>{{ $meter['i'] }}</td>
                    <td>{{ $meter['n'] }}</td>
                    <td>{{ $meter['m'] }}</td>
                    <td>{{ $meter['g'] }}</td>
                    <td>{{ $meter['c'] }}</td>
                    <td>{{ $meter['e'] }}</td>
                    <td>{{ $meter['t'] }}</td>
                    <td>{{ $meter['p'] }}</td>
                    <td>{{ $meter['x'] }}</td>
                    <td>{{ $meter['s'] }}</td>
                    <td>{{ $meter['l'] }}</td>
                    <td>
                        <div class="d-flex flex-row justify-content-between">
                            <form method="POST" action="{{ route('switch_meter', [$meter['i'], '1']) }}">
                                @csrf

                                <button class="btn btn-danger">Switch Off</button>

                            </form>

                            <form method="POST" action="{{ route('switch_meter', [$meter['i'], '2']) }}">
                                @csrf

                                <button class="btn btn-success">Switch On</button>

                            </form>
                        </div>
                        
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

    <script>
        
    </script>

    

</x-layout>

