<li>
    <span>
        <input type="hidden" id="sub_folders_opened_{{ $folder->id }}" value="1">
        <input type="checkbox" name="folders[]" class="folder_checkbox" value="{{ $folder->id }}" @if (in_array($folder->id, $selected)) checked @endif>

        <span id="folder_caret_{{ $folder->id }}" class="sub_folders_toggle" data-id="{{ $folder->id }}" @if (!count($folder->subFolders)) style="display: none;" @endif>
            <i class="fa fa-caret-down"></i>
        </span>

        <span id="folder_nosub_{{ $folder->id }}" class="no-sub" @if (count($folder->subFolders)) style="display: none;" @endif></span>

        <i class="fa fa-folder-open"></i>
        
        <span>
            <a href="javascript:;" class="sub_folders_toggle folder_name" data-id="{{ $folder->id }}" data-path="{{ $folder->getPath() }}">
                <span class="name-prefix-perm">{{ $folder->name }}</span>
            </a>
        </span>
    </span>

    <span class="sub" id="sub-{{ $folder->id }}"> 
        <ul class="tree-file" id="ul-{{ $folder->id }}">
            @foreach ($folder->subFolders as $subFolder)
                @include('partials.permissions.sub_folders', ['folder' => $subFolder])
            @endforeach
        </ul>
    </span>
</li>
