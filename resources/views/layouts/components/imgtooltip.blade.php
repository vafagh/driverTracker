    <div class="info d-inline">
        <a class='tip' href="/{{$modelName}}/show/{{$model->id}}">
            <img  src="/img/recipt.png">
        </a>
        <div class="card w-25">
            <div class="card-body">
                @foreach ($model->toArray() as $key => $value)
                    @php
                    ($key=='image' && $value!='') ? $img = $modelName.'/'.$value:'';
                    @endphp
                @endforeach
                @if (isset($img))
                    <img class="card-img-bottom w-100" src="/img/{{$img}}" alt="Card image cap">
                @endif
            </div>
        </div>
    </div>
