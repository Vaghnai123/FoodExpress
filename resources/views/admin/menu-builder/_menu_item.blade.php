<li class="dd-item" data-id="{{ $item->id }}">
    <div class="dd-handle">{{ $item->label }}</div>
    <span class="item-settings toggle-item-settings"><i class="fas fa-chevron-down"></i></span>

    <div class="menu-details-form">
        <form action="{{ route('admin.menus.items.update', $item->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Label</label>
                    <input type="text" name="label" value="{{ $item->label }}" class="form-control">
                </div>
                <div class="col-md-6 form-group">
                    <label>URL</label>
                    <input type="text" name="link" value="{{ $item->link }}" class="form-control">
                </div>
                <div class="col-md-4 form-group">
                    <label>Parent Item</label>
                    <select name="parent_id" class="form-control">
                        <option value="0" {{ $item->parent_id == 0 ? 'selected' : '' }}>None (Main Item)</option>

                        @php
                            $dropdownItems = \App\Models\MenuItem::where('menu_id', $item->menu_id)->get();
                        @endphp

                        @foreach($dropdownItems as $parent)
                            @if($parent->id != $item->id)
                                <option value="{{ $parent->id }}" {{ $item->parent_id == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->label }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>Target</label>
                    <select name="target" class="form-control">
                        <option value="_self" {{ $item->target == '_self' ? 'selected' : '' }}>_self</option>
                        <option value="_blank" {{ $item->target == '_blank' ? 'selected' : '' }}>_blank</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>CSS Class (optional)</label>
                    <input type="text" name="class" value="{{ $item->class }}" class="form-control">
                </div>
                <div class="col-md-4 form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Update Item</button>
        </form>

        <form action="{{ route('admin.menus.items.destroy', $item->id) }}" method="POST" class="mt-2"
            onsubmit="return confirm('Delete this item?');">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Remove Item</button>
        </form>
    </div>

    @if ($item->children->count() > 0)
        <ol class="dd-list">
            @foreach ($item->children as $child)
                @include('admin.menu-builder._menu_item', ['item' => $child])
            @endforeach
        </ol>
    @endif
</li>
