<div class="panel-group" id="accordion">
  @foreach($orders as $item)
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#{{$item->id}}">
            {{$item->package->name}} - Order from {{$item->date_completed->format('m/d/Y')}}
          </a>
        </h4>
      </div>
      <div id="{{$item->id}}" class="panel-collapse collapse {{($orders->first()->id == $item->id) ? 'in' : ''}}">
        <div class="panel-body">
          @include('scorecards/learner/wrapper', ['item' => $item])
        </div>
      </div>
    </div>
  @endforeach
</div>
