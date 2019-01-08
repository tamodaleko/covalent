<li>
    <span>
        <input type="hidden" id="sub_folders_opened_{{ $folder->id }}" value="0">
        <input type="checkbox" name="folders[]" class="folder_checkbox" value="{{ $folder->id }}" @if (in_array($folder->id, $selected)) checked @endif>

        @if (count($folder->subFolders))
            <span id="folder_caret_{{ $folder->id }}" class="sub_folders_toggle" data-id="{{ $folder->id }}">
                <i class="fa fa-caret-right"></i>
            </span>
        @else
            <span class="no-sub"></span>
        @endif

        <i class="fa fa-folder-open"></i>
        
        <span>
            <a href="javascript:;" class="sub_folders_toggle" data-id="{{ $folder->id }}" style="font-weight: bold;">
                {{ $folder->name }}
            </a>
        </span>
    </span>

    <hr style="margin: 0; padding: 0;" />

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
