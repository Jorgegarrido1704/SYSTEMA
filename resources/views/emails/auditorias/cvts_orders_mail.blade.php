<!DOCTYPE html>
<html>
<head>
    <title>Daily CVTS Order Report</title>
</head>
<body>
    <h2>Daily CVTS Order Report</h2>

    <p><strong>Good day all,  </strong> </p>
    <p><strong>I'm sharing in this email the results of the station auditory. </strong> </p>
    <p><strong>Each Friday, I will attach a file with the record of every week since we start with this process.</strong></p>
    <br><br><br>
    <table>
        <thead>
            <tr>
                <th><strong>Part Number</strong></th>
                <th><strong>Wo</strong></th>
                <th><strong>Physically</strong></th>
                <th><strong>In the System</strong></th>
                <th><strong>Result</strong></th>
                <th><strong>Leader</strong></th>
            </tr>
        </thead>
        <tbody>
           @for ($i = 0; $i < count($acciones['work_order']); $i++)
            <tr>
                <td>{{ $acciones['part_number'][$i] ?? '' }}</td>
                <td>{{ $acciones['work_order'][$i] ?? '' }}</td>
                <td>{{ $acciones['physically_located'][$i] ?? '' }}</td>
                <td>{{ $acciones['system_location'][$i] ?? '' }}</td>
                <td>{{ $acciones['status'][$i] ?? '' }}</td>
                <td>{{ $acciones['resposable'][$i] ?? '' }}</td>
            </tr>
        @endfor
        </tbody>

    </table>

    <p><strong>Effectivity Rate: {{ $results }} </strong> </p>
    <p><strong>Please do not hesitate to let me know if you have any questions.   </strong> </p>
    <br>
   <p><strong>Regards.   </strong> </p>


</body>
</html>
