@if ($colection->count()>0)
<div class="card-header">
    {{$modelName = str_plural(class_basename($colection->first()))}}
</div>
<div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    @foreach ($colection->first()->toArray() as $key => $value)
                        @if ($key == 'deleted_at' || $key =='updated_at')
                        @else
                            <th class="">{{$key}}</th>
                        @endif
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach ($colection as $row)
                    @php
                        array_pull($row , 'updated_at')
                    @endphp
                    <tr>
                        @foreach ($row->toArray() as $key => $value)
                            <td class="">{{$value}}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
@endif
