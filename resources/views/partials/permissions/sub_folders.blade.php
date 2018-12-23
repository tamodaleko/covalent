<li>
    <span>
        <input type="checkbox" name="folders[]" class="folder_checkbox" value="{{ $folder->id }}" @if (in_array($folder->id, $selected)) checked @endif>

        @if (count($folder->subFolders))
            <a href="javascript:;" class="arrow" data-id="{{ $folder->id }}" onclick="subFoldersOpen(this)">
                <span>
                    <i class="fa fa-caret-right"></i>
                </span>
            </a>
        @else
            <span class="no-sub"></span>
        @endif

        <i class="fa fa-folder-open-o"></i>
        <span class="name">{{ $folder->name }}</span>
    </span>

    @if (count($folder->subFolders))
        <span class="sub" id="sub-{{ $folder->id }}" style="display: none;">
            <ul class="tree-file">
                @foreach ($folder->subFolders as $subFolder)
                    @include('partials.permissions.sub_folders', ['folder' => $subFolder])
                @endforeach
            </ul>
        </span>
    @endif
</li>
