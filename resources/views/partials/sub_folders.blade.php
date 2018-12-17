<li>
    <span>
        @if (count($folder->subFolders) || count($folder->files))
            <a href="javascript:;" class="arrow" id="arrow-{{ $folder->id }}" data-id="{{ $folder->id }}">
                <span><i class="fa fa-caret-right"></i></span>
            </a>
        @else
            <span class="no-sub"></span>
        @endif
        
        <i class="fa fa-folder-open-o"></i>

        <a href="javascript:;">
            <span class="name-prefix name" data-id="{{ $folder->id }}" data-path="{{ $folder->getPath() }}">
                {{ $folder->name }}
            </span>
        </a>

        <span class="create-sub-folder">
            @if (!is_null($folder->status))
                <span class="status {{ $folder->getStatusTag() }}">{{ $folder->getStatusTag() }}</span>
            @endif

            <span class="metadata">{{ $folder->tag }}</span>

            <a href="{{ route('folders.copy', ['id' => $folder->id]) }}" class="confirm" style="margin-right: 5px;">
                <i class="fa fa-copy"></i>
            </a>
            
            <a href="{{ route('folders.destroy', ['id' => $folder->id]) }}" class="confirm">
                <i class="fa fa-remove" style="color: red;"></i>
            </a>
        </span>
    </span>

    <hr style="margin: 0; padding: 0;" />

    @if (count($folder->subFolders))
        <span class="sub" id="sub-{{ $folder->id }}" style="display: none;">
            <ul class="tree-file">
                @foreach ($folder->subFolders as $subFolder)
                    @include('partials.sub_folders', ['folder' => $subFolder])
                @endforeach
            </ul>
        </span>
    @endif

    @if (count($folder->files))
        @include('partials.files', ['sub' => true])
    @endif
</li>