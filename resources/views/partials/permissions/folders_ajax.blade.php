<br />
<div class="form-group">
    {{ Form::label('folders', 'Folders') }}
    
    <ul class="tree-file" id="permission-folders">
        @foreach ($folders as $folder)
            @include('partials.permissions.folders', ['selected' => $selected])
        @endforeach
    </ul>
</div>