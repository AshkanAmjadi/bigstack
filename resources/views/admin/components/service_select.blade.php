<select id="categorySelect" name="service_id"
        class="form-input text-smid w-full relative">
    @foreach($allService as $service)
        <option {{ $selected == $service->id ? 'selected' : '' }} value="{{$service->id}}">{{$service->name}}</option>
    @endforeach
</select>
