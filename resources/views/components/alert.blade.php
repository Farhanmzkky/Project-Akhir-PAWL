@if(session('notice'))
    <div role="status" class="message">{{ session('notice') }}</div>
@endif
@if($errors->any())
    <div role="alert" class="message problem"><ul>
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul></div>
@endif
