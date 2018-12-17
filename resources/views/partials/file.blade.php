<li>
    <span>
        <span class="no-sub"></span>
        <input type="checkbox" name="files[]" class="file_checkbox" value="{{ $file->id }}">
        
        <i class="fa {{ $file->getIcon() }}"></i>
        
        <a href="{{ $file->getLink() }}" target="_blank">
            @if ($search)
                <span class="name-prefix">{{ $file->fullName }} - <i style="font-size: 11px;">( /{{ $file->folder->getPath() }} )</i></span>
            @else
                <span class="name-prefix">{{ $file->fullName }}</span>
            @endif
        </a>

        <span class="create-sub-folder">

            @if ($file->isViewable())
                <a href="javascript:;" data-toggle="modal" data-target="#imagePreviewModal" data-url="{{ $file->getLink() }}" style="margin-right: 5px;">
                    <i class="fa fa-image"></i>
                </a>
            @endif

            <a href="{{ $file->getLink() }}" download="{{ $file->fullName }}" style="margin-right: 5px;">
                <i class="fa fa-download"></i>
            </a>

            <a href="javascript:;" data-toggle="modal" data-target="#moveFileModal" data-id="{{ $file->id }}" style="margin-right: 5px;">
                <i class="fa fa-folder-o"></i>
            </a>

            <a href="{{ route('files.copy', ['id' => $file->id]) }}" class="confirm" style="margin-right: 5px;">
                <i class="fa fa-copy"></i>
            </a>

            <a href="{{ route('files.destroy', ['id' => $file->id]) }}" class="confirm">
                <i class="fa fa-remove" style="color: red;"></i>
            </a>
        </span>
    </span>
</li>
