<select id="gender" class="form-input2 text-smid w-full font-YekanBakh" name="gender" dir="ltr">
    <option {{ old('gender',$subject ? $subject->level : null) == 'man' ? 'selected' : ''  }} value="man">Male</option>
    <option {{ old('gender',$subject ? $subject->level : null) == 'woman' ? 'selected' : ''  }} value="woman">Female</option>
    <option {{ old('gender',$subject ? $subject->level : null) == 'other' ? 'selected' : ''  }} value="other">other</option>
</select>
