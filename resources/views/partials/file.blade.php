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

            <span style="margin-right: 10px;">{{ $file->formatDate('America/Los_Angeles') }} ( {{ $file->formatSize() }} )</span>
            
            @if ($file->isViewable())
                <span data-toggle="modal" data-target="#imagePreviewModal" data-url="{{ $file->getLink() }}" style="margin-right: 5px;">
                    <a href="javascript:;" data-toggle="tooltip" title="Image Preview">
                        <i class="fa fa-image"></i>
                    </a>
                </span>
            @endif

            <span data-toggle="tooltip" title="Download File" style="margin-right: 5px;">
                <a href="{{ route('files.download', ['id' => $file->id]) }}">
                    <i class="fa fa-download"></i>
                </a>
            </span>

            <span data-toggle="modal" data-target="#moveFileModal" data-id="{{ $file->id }}" style="margin-right: 5px;">
                <a href="javascript:;" data-toggle="tooltip" title="Move File">
                    <i class="fa fa-folder-o"></i>
                </a>
            </span>

            <span data-toggle="modal" data-target="#copyFileModal" data-id="{{ $file->id }}" style="margin-right: 5px;">
                <a href="javascript:;" data-toggle="tooltip" title="Copy File">
                    <i class="fa fa-copy"></i>
                </a>
            </span>
            
            <span data-toggle="tooltip" title="Delete File">
                <a href="{{ route('files.destroy', ['id' => $file->id]) }}" class="confirm">
                    <i class="fa fa-remove"></i>
                </a>
            </span>
        </span>
    </span>
</li>
