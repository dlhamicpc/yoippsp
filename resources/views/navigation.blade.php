@foreach ($items as $item)
<li class="nav-item">
    <a href= {{ url("$item->url") }} class="nav-link">
        <i class="nav-icon far fa-circle text-info"></i>
        <p>{{$item->title}}</p>
    </a>
</li>
@endforeach