<ul class="list-group" id='truck'>
    @foreach ($trucks as $key => $truck)
        @component('truck.oneTruck',['truck'=>$truck,'key'=>$key])

        @endcomponent
    @endforeach
</ul>
