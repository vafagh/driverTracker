@php
switch($modelName){

    case 'rideable':
        $title = '<strong><pre >'.strtoupper($model->invoice_number).'</pre></strong>';
    break;

    case 'location':
    $mouseOver ='onmouseover="loadStatImg(\'https://maps.googleapis.com/maps/api/staticmap?center='.$model->line1.',+'.$model->city.',+'.$model->state.',+'.$model->zip.'&zoom=10&size=300x300&maptype=roadmap&key='.env('GOOGLE_MAP_API').'&markers=size:mid%7Ccolor:0xff0000%7Clabel:%7C'.$model->line1.',+'.$model->city.',+'.$model->state.',+'.$model->zip.'\',\'stMap'.$model->id.'\')"';
        ($model->lat=='' || $model->lat==null) ? $title='<i class="material-icons md-18 float-left">not_listed_location</i>' : $title='';
        if($model->image != ''){
            $title = $title.'<img  class="minh-30" src="/img/location/'.$model->image.'" '.$mouseOver.'>';
        }else {
            $title = $title.'<h5 class="mb-0" '.$mouseOver.'>'.$model->name.'</h5>';
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
    $title = $model->fname.' '.$model->lname;
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
    <div class="info d-inline">
        <a class='tip' href="/{{$modelName}}/show/{{$model->id}}">
            @if (isset($element))
                {!!'<'.$element.'>'.$title.'</'.$element.'>'!!}
            @else
                {!!$title!!}
            @endif
        </a>
        <div class="card">
            {{-- <div class="card-header">
                {!!$modelName.': '.$title!!}
            </div> --}}

            <div class="card-body">
                @if ($modelName == 'location')
                    <a target="_blank" href="https://www.google.com/maps/dir/1628+E+Main+St,+Grand+Prairie,+TX+75050/{{$model->line1}},+{{$model->city}},+{{$model->state}},+{{$model->zip}}">
                        {{-- <img class="w-100" src="https://maps.googleapis.com/maps/api/staticmap?center={{$model->line1}},+{{$model->city}},+{{$model->state}},+{{$model->zip}}&zoom=10&size=400x400&maptype=roadmap&key=AIzaSyBWE7jcte-d6FLo0rYxQFManjv6rzi0Ysc&markers=size:mid%7Ccolor:0xff0000%7Clabel:%7C{{$model->line1}},+{{$model->city}},+{{$model->state}},+{{$model->zip}}" alt="{{$model->name}} Maps"> --}}
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
    </div>
@else Not Found
@endif
