<noscript>
@if(session('notice'))
    <div role="status" class="bg-soft border border-line text-forest px-5 py-3.5 rounded-btn mb-4 text-body font-medium flex items-center gap-3">
        <i class="glyph check text-forest" aria-hidden="true"></i>
        <span>{{ session('notice') }}</span>
    </div>
@endif

@if($errors->any())
    <div role="alert" class="bg-[#F8E2DC] border border-[#F2BFB5] text-[#903E35] px-5 py-3.5 rounded-btn mb-4 text-body font-medium">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</noscript>
