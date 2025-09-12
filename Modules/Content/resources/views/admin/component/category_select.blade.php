<select id="categorySelect" name="category"
        class="form-input text-smid w-full relative">
    @foreach($allCat as $cat)
        <option {{ $selected == $cat->id ? 'selected' : '' }} value="{{$cat->id}}">{{$cat->title}}</option>

        @if(\App\facade\BaseCat\BaseCat::hasChild($cat))
            <optgroup label="زیردسته های ({{$cat->title}})">
                @foreach($cat->getRelation('child') as $child)

                    <option {{$selected == $child->id ? 'selected' : '' }} value="{{$child->id}}">{{$child->title}}</option>

            @if(\App\facade\BaseCat\BaseCat::hasChild($child))
                <optgroup label="زیردسته های ({{$child->title}})">

                    @foreach($child->getRelation('child') as $childhood)

                        <option {{ $selected == $childhood->id ? 'selected' : '' }} value="{{$childhood->id}}">{{$childhood->title}}</option>

                    @endforeach
                </optgroup>


                @endif
                @endforeach
                </optgroup>

            @endif

            @endforeach
</select>
