<div class="row">
    @php
    $ardata = json_decode($data, true);
    // dd($ardata);
    @endphp
    @if (gettype($ardata)=='array')
        @foreach ($ardata as $key => $value)
            <div class="border mr-1 px-1 mb-1">
                <div class="border-bottom ">{{$key}}</div>
                <div>
                    @if (gettype($value)=='array')
                            @foreach ($value as $key => $val)
                                    {{$val}}, 
                            @endforeach
                    @else
                        {{$value}}
                    @endif

                    </div>
                </div>
            @endforeach
        @endif
    </div>
