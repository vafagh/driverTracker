@php
    $hover = false;
switch($modelName){

    case 'rideable':
        $note=''; if($model->description) $note="<i title='$model->description' class='material-icons'>event_note</i>";
        $stock=''; if ($model->stock) $stock =' <span class="text-primary">Stock</span>';
        $qty =' x<span class="text-danger">'.$model->qty.'</span>';
        $title = strtoupper($model->invoice_number);
        if($model->type=='Client')$title=$title.$note;
        else $title=$title.'<small><sup>'.$qty.$stock.'</sup></small>'.$note;
    break;

    case 'location':
    $hover = true;
    $mouseOver ='onmouseover="loadStatImg(\'https://maps.googleapis.com/maps/api/staticmap?center='.$model->line1.',+'.$model->city.',+'.$model->state.',+'.$model->zip.'&zoom=9&size=200x200&maptype=roadmap&key='.env('GOOGLE_MAP_API').'&markers=size:mid%7Ccolor:0xff0000%7Clabel:%7C'.$model->line1.',+'.$model->city.',+'.$model->state.',+'.$model->zip.'\',\'stMap'.$model->id.'\')"';
        ($model->lat=='' || $model->lat==null) ? $title='<i class="material-icons md-18 float-left">not_listed_location</i>' : $title='';
        if($model->image != ''){
            $title = $title.'<img  class="minh-30" src="/img/location/'.$model->image.'" '.$mouseOver.'>';
        }else {
            $title = $title.'<span class="mb-0 h5" '.$mouseOver.'>'.$model->name.'</span>';
        }

    break;

    case 'ride':
    $title = 'For '.$model->rideable->location->name;
    break;

    case 'transaction':
    $title = $model->user->name.' '.$model->action.' '.$model->table;
    break;

    case 'truck':
    $title = $model->lable;
    break;

    case 'driver':
    $title = (!empty($model->fname)) ? $model->fname.' '.$model->lname: 'NoTitle!';
    break;

    case 'fillup':
    $title = $model->gallons.'G';
    break;

    default:
    isset($model->name) ? $title = $model->name: $title = '?';
}
@endphp
@if($title!='?')
{!!isset($script) ? $script : ''!!}
    <div class="info d-inline ">
        <a class='tip{{isset($class) ? ' '.$class : ''}}' href="/{{$modelName}}/show/{{$model->id}}">
            @if (isset($element))
                {!!'<'.$element.'>'.$title.'</'.$element.'>'!!}
            @else
                {!!$title!!}
            @endif
        </a>
        @if ($hover)
            <div class="card">
            {{-- <div class="card-header">{!!$modelName.': '.$title!!}</div> --}}
            <div class="card-body">
                @if ($modelName == 'location')
                    <a target="_blank" href="https://www.google.com/maps/dir/1628+E+Main+St,+Grand+Prairie,+TX+75050/{{$model->line1}},+{{$model->city}},+{{$model->state}},+{{$model->zip}}">
                        {{-- <img class="w-100" src="https://maps.googleapis.com/maps/api/staticmap?center={{$model->line1}},+{{$model->city}},+{{$model->state}},+{{$model->zip}}&zoom=10&size=400x400&maptype=roadmap&key={{env('GOOGLE_MAP_API')}}&markers=size:mid%7Ccolor:0xff0000%7Clabel:%7C{{$model->line1}},+{{$model->city}},+{{$model->state}},+{{$model->zip}}" alt="{{$model->name}} Maps"> --}}
                        <img src="/img/gif/loading.gif" class="stMap{{$model->id}}" />
                    </a>
                @else

                @foreach ($model->toArray() as $key => $value)
                    @if (gettype($value)=='string' || gettype($value)=='integer')
                        <div class="d-flex justify-content-between">
                            <div class="">{{$value}}</div>
                            <div class="text-muted">{{$key}}</div>
                        </div>
                    @endif
                    @php
                        ($key=='image' && $value!='') ? $img = $modelName.'/'.$value:'';
                    @endphp
                @endforeach
                @if (isset($img))
                    <img class="card-img-bottom w-25" src="/img/{{$img}}" alt="Card image cap">
                @endif
            @endif
            </div>
        </div>
        @endif

    </div>
@else Not Found
@endif
