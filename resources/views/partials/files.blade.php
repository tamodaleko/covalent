<span id="files-{{ $folder->id }}" class="files" @if ($sub) style="display: none;" @endif>
    <ul class="tree-file">
        @foreach ($folder->files as $file)
            @include('partials.file', ['search' => false])
        @endforeach
    </ul>
</span>