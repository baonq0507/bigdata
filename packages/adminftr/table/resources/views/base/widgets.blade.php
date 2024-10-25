    @if ($this->widgets())
        <div class="container-fuild">
            <div class="row row-cards">
                @foreach ($this->widgets() as $widget)
                    {!! $widget->render() !!}
                @endforeach
            </div>
        </div>
    @endif
