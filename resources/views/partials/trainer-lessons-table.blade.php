@if ($lessons->isEmpty())
    <p class="empty">Er zijn geen lessen gevonden.</p>
@else
    <div class="tw">
        <table>
            <tr><th>Les</th><th>Datum</th><th>Tijd</th><th>Zaal</th><th>Inschr.</th><th>Acties</th></tr>
            @foreach ($lessons as $lesson)
                <tr>
                    <td><b>{{ $lesson->name }}</b></td>
                    <td>{{ $lesson->date->format('d-m-Y') }}</td>
                    <td>{{ $lesson->start_label }}</td>
                    <td>{{ $lesson->location->name }}</td>
                    <td>{{ $lesson->participants_count }}/{{ $lesson->max_amount }}</td>
                    <td>
                        <a class="btn s o" href="{{ route('trainer.lessons.show', $lesson) }}">Details</a>
                        <a class="btn s" href="{{ route('trainer.lessons.participants', $lesson) }}">Deelnemers</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endif
