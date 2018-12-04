<li>
    <span class="item">
        @if (count($folder['subFolders']))
            <a href="javascript:;" class="arrow" data-id="{{ $folder['id'] }}">
                <span><i class="fa fa-caret-right"></i></span>
            </a>
        @else
            <span class="no-sub"></span>
        @endif
        
        <i class="fa fa-folder-open-o"></i>
        <a href="javascript:;">
            <span class="name-prefix name" data-id="{{ $folder['id'] }}">{{ $folder['name'] }}</span>
        </a>

        <span class="create-sub-folder">
            @if (!is_null($folder['status']))
                <span class="status {{ $folder['status_tag'] }}">{{ $folder['status_tag'] }}</span>
            @endif

            <span class="metadata">{{ $folder['tag'] }}</span>
            <a href="javascript:;"><i class="fa fa-remove"></i></a>
        </span>
    </span>

    @if (count($folder['subFolders']))
        <span class="sub" id="sub-{{ $folder['id'] }}" style="display: none;">
            <ul class="tree-file">
                @foreach ($folder['subFolders'] as $folder)
                    @include('partials.sub_folders')
                @endforeach
            </ul>
        </span>
    @endif
</li>