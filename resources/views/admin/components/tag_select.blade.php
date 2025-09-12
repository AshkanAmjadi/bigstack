<select id="tags" class="form-input select2 text-smid w-full font-YekanBakh" name="tags[]" multiple>
    @php($tags = $subject ? $subject->tags()->get(['id'])->pluck('id')->toArray() : [])

    @foreach($allTag as $tag)
        <option
            value="{{$tag->id}}" {{in_array($tag->id , old('tags' , $tags)) ? 'selected' : ''}}>{{$tag->name}}</option>
    @endforeach
</select>
