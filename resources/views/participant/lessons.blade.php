@extends('layouts.app')

@section('title', 'Lessen')

@section('content')
    <h1>Lesoverzicht</h1>
    @unless ($lessons->isEmpty())
        <div style="display:flex;flex-wrap:wrap;gap:12px 16px;align-items:flex-end;margin-bottom:16px">
            <div>
                <label for="lesfilter">Zoek een les</label><br>
                <input id="lesfilter" type="search" placeholder="Bijv. zwemmen" autocomplete="off">
            </div>
            <div>
                <label for="datumfilter">Datum</label><br>
                <input id="datumfilter" type="date">
            </div>
            <div>
                <label for="vanaffilter">Vanaf tijd</label><br>
                <input id="vanaffilter" type="time">
            </div>
            <div>
                <label for="totfilter">Tot tijd</label><br>
                <input id="totfilter" type="time">
            </div>
            <div>
                <button type="button" id="wisfilters" class="btn s o">Filters wissen</button>
            </div>
        </div>
    @endunless

    @if ($lessons->isEmpty())
        <p class="empty">Er zijn op dit moment geen lessen gepland.</p>
    @else
        <div class="tw">
            <table>
                <tr>
                    <th>Les</th>
                    <th>Datum</th>
                    <th>Tijd</th>
                    <th>Trainer</th>
                    <th>Plaatsen</th>
                    <th>Actie</th>
                </tr>
                @foreach ($lessons as $lesson)
                    @php
                        $enrolled = in_array($lesson->id, $enrolledIds);
                        $left = $lesson->spotsLeft();
                    @endphp
                    <tr data-naam="{{ $lesson->name }}"
                        data-datum="{{ $lesson->date->format('Y-m-d') }}"
                        data-start="{{ $lesson->start_label }}"
                        data-eind="{{ $lesson->end_label }}">
                        <td><b>{{ $lesson->name }}</b><br><small>{{ $lesson->location->name }}</small></td>
                        <td>{{ $lesson->date->format('d-m-Y') }}</td>
                        <td>{{ $lesson->start_label }} – {{ $lesson->end_label }}</td>
                        <td>{{ $lesson->trainer->name }}</td>
                        <td>{{ $left > 0 ? $left . ' vrij' : 'Vol' }}</td>
                        <td>
                            @if ($enrolled)
                                <form class="inline" method="POST" action="{{ route('participant.lessons.withdraw', $lesson) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn s r">Afmelden</button>
                                </form>
                            @elseif ($left > 0)
                                <form class="inline" method="POST" action="{{ route('participant.lessons.enroll', $lesson) }}">
                                    @csrf
                                    <button type="submit" class="btn s">Inschrijven</button>
                                </form>
                            @else
                                <span class="btn s o disabled">Vol</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <p class="empty" id="geen-resultaat" hidden>Geen lessen gevonden voor deze filters.</p>
    @endif

    <p><small>U kunt zich niet inschrijven voor twee lessen die op hetzelfde tijdstip plaatsvinden.</small></p>

    <script>
        // Live filters: lessen die niet passen bij de zoekopdracht verdwijnen direct
        (function () {
            var naamVeld = document.getElementById('lesfilter');
            if (!naamVeld) return;

            var datumVeld = document.getElementById('datumfilter');
            var vanafVeld = document.getElementById('vanaffilter');
            var totVeld = document.getElementById('totfilter');
            var wisKnop = document.getElementById('wisfilters');
            var rijen = document.querySelectorAll('tr[data-naam]');
            var geen = document.getElementById('geen-resultaat');

            function normaal(tekst) {
                return tekst.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').trim();
            }

            function filter() {
                var zoek = normaal(naamVeld.value);
                var datum = datumVeld.value;   // formaat JJJJ-MM-DD
                var vanaf = vanafVeld.value;   // formaat UU:MM
                var tot = totVeld.value;       // formaat UU:MM
                var zichtbaar = 0;

                rijen.forEach(function (rij) {
                    var pastNaam = normaal(rij.dataset.naam).indexOf(zoek) !== -1;
                    var pastDatum = datum === '' || rij.dataset.datum === datum;
                    // De les moet beginnen op of na "vanaf" en eindigen op of voor "tot"
                    var pastVanaf = vanaf === '' || rij.dataset.start >= vanaf;
                    var pastTot = tot === '' || rij.dataset.eind <= tot;
                    var past = pastNaam && pastDatum && pastVanaf && pastTot;

                    rij.hidden = !past;
                    if (past) zichtbaar++;
                });

                geen.hidden = zichtbaar > 0;
            }

            [naamVeld, datumVeld, vanafVeld, totVeld].forEach(function (veld) {
                veld.addEventListener('input', filter);
                veld.addEventListener('change', filter);
            });

            wisKnop.addEventListener('click', function () {
                naamVeld.value = '';
                datumVeld.value = '';
                vanafVeld.value = '';
                totVeld.value = '';
                filter();
            });
        })();
    </script>
@endsection