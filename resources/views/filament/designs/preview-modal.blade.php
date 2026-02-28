@php use Illuminate\Support\Str; @endphp

<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:20px;">

    @foreach($files ?? [] as $file)

        <div style="text-align:center;">

            @if(Str::endsWith($file, ['jpg','jpeg','png','webp']))
                <a href="{{ asset('storage/' . $file) }}" target="_blank">
                    <img 
                        src="{{ asset('storage/' . $file) }}" 
                        style="width:100%; height:220px; object-fit:cover; border-radius:16px; transition:0.3s;"
                    >
                </a>
            @else
                <a href="{{ asset('storage/' . $file) }}" 
                   target="_blank"
                   style="display:flex; align-items:center; justify-content:center; height:220px; border:1px solid #ddd; border-radius:16px; font-size:18px;">
                    📄 Open File
                </a>
            @endif

        </div>

    @endforeach

</div>