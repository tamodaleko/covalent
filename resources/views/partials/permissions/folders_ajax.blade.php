<br />
<div class="form-group">
    {{ Form::label('folders', 'Folders') }}
    
    <ul class="tree-file">
        @foreach ($folders as $folder)
            @include('partials.permissions.folders')
        @endforeach
    </ul>
</div>