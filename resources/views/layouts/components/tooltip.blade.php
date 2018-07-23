@php
switch($modelName){

    case 'rideable':
    $title = '#'.$model->invoice_number;
    break;

    case 'location':
    $title = '<strong>'.$model->name.'</strong>';
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
    <div class="info d-inline">
        <a class='tip' href="/{{$modelName}}/show/{{$model->id}}">
            @if (isset($element))
                {!!'<'.$element.'>'.$title.'</'.$element.'>'!!}
            @else
                {!!$title!!}
            @endif
        </a>
        <div class="card">
            <div class="card-header">
                {{$modelName.': '.$title}}
            </div>


            <div class="card-body">
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
            </div>
        </div>
    </div>
@else Not Found
@endif
