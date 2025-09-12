<select id="type" class="form-input text-smid w-full font-YekanBakh" name="type">
    <option {{old('type',$subject ? $subject->type : null) == 'danger' ? 'selected' : ''}} value="danger">
        خطر
            @include('component.allert.icons.danger')
    </option>
    <option {{old('type',$subject ? $subject->type : null) == 'info' ? 'selected' : ''}} value="info">
        اطلاعاتی
            @include('component.allert.icons.info')
    </option>
    <option {{old('type',$subject ? $subject->type : null) == 'secondary' ? 'selected' : ''}} value="secondary">
        اطلاعیه
            @include('component.allert.icons.secondary')
    </option>
    <option {{old('type',$subject ? $subject->type : null) == 'warning' ? 'selected' : ''}} value="warning">
        هشدار
            @include('component.allert.icons.warning')
    </option>
    <option {{old('type',$subject ? $subject->type : null) == 'success' ? 'selected' : ''}} value="success">
        موفقیت
            @include('component.allert.icons.success')
    </option>
</select>
