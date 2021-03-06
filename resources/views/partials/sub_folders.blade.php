<li>
    <span>
        <a href="javascript:;" class="arrow" id="arrow-{{ $folder->id }}" data-id="{{ $folder->id }}" @if (!count($folder->subFolders) && !count($folder->files)) style="display: none;" @endif>
            <span><i class="fa fa-caret-right"></i></span>
        </a>

        <span id="nosub-{{ $folder->id }}" class="no-sub" @if (count($folder->subFolders) || count($folder->files)) style="display: none;" @endif></span>
        
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

            <span data-toggle="modal" data-target="#renameFolderModal" data-id="{{ $folder->id }}" style="margin-right: 5px;">
                <a href="javascript:;" data-toggle="tooltip" title="Rename Folder">
                    <i class="fa fa-pencil-square-o"></i>
                </a>
            </span>

            <span data-toggle="modal" data-target="#moveFolderModal" data-id="{{ $folder->id }}" data-company_id="{{ $company->id }}" style="margin-right: 5px;">
                <a href="javascript:;" data-toggle="tooltip" title="Move Folder">
                    <i class="fa fa-folder-o"></i>
                </a>
            </span>

            <span data-toggle="modal" data-target="#copyFolderModal" data-id="{{ $folder->id }}" data-company_id="{{ $company->id }}" style="margin-right: 5px;">
                <a href="javascript:;" data-toggle="tooltip" title="Copy Folder">
                    <i class="fa fa-copy"></i>
                </a>
            </span>
            
            <span data-toggle="tooltip" title="Delete Folder">
                <a href="{{ route('folders.destroy', ['id' => $folder->id]) }}" class="confirm">
                    <i class="fa fa-remove"></i>
                </a>
            </span>
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

    @include('partials.files', ['sub' => true])
</li>