@if ($colection->count()>0)
    <div class="card-header">
        {{$modelName = str_plural(class_basename($colection->first()))}}
    </div>
    <div class="card-body">
        <div>
            <div class="pagination">
                {{ $colection->links("pagination::bootstrap-4") }}
            </div>
        </div>
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
                            @if ($loop->first)
                                <td class=""><a href="/{{strtolower((class_basename($row))).'/show/'.$value}}">{{$value}}</a></td>
                            @else
                                <td class="">{{$value}}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
