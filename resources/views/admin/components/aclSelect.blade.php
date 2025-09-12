
<select id="acl" class="form-input text-smid w-full font-YekanBakh" name="acl">
    <option {{ $is_user ? 'selected' : '' }} value="user">عضو</option>
    <option {{ $boss ? 'selected' : '' }} value="boss">مدیر</option>
    <option {{ $staff ? 'selected' : '' }} value="staff">کارمند</option>
</select>
