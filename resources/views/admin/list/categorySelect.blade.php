
@php($selected = isset($l1) ? $l1->listable_id : null)


@include('content::admin.component.category_select' , compact('selected'))
