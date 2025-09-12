<select id="level" class="form-input text-smid w-full font-YekanBakh" name="level">
    <option {{old('level',$subject ? $subject->level : null) == 0 ? 'selected' : ''}} value="0">بدون سطح</option>
    <option {{old('level',$subject ? $subject->level : null) == 1 ? 'selected' : ''}} value="1">مبتدی</option>
    <option {{old('level',$subject ? $subject->level : null) == 2 ? 'selected' : ''}} value="2">متوسط</option>
    <option {{old('level',$subject ? $subject->level : null) == 3 ? 'selected' : ''}} value="3">پیشرفته</option>
</select>
