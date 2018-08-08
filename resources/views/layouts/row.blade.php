<div class="">
    {{$data}}
    {{-- @php
        $ardata = json_decode($data, true);
        // dd(($ardata));
    @endphp
    @foreach ($ardata as $key => $value)
    {{implode( $value)}}
        {{-- <div>{{$key}}</div>
        <div>{{$value}}</div> 
    @endforeach --}}
</div>
