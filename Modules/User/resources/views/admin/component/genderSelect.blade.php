<select id="gender" class="form-input2 text-smid w-full font-YekanBakh" name="gender">
    <option {{ old('gender',$subject ? $subject->level : null) == 'man' ? 'selected' : ''  }} value="man">مرد</option>
    <option {{ old('gender',$subject ? $subject->level : null) == 'woman' ? 'selected' : ''  }} value="woman">زن</option>
    <option {{ old('gender',$subject ? $subject->level : null) == 'other' ? 'selected' : ''  }} value="other">غیره</option>
</select>
