<script>


    $("#{{$select2}}").on('change', function (e) {
        setMention($("#{{$select2}}").select2('data'), '#{{$wraper}}');
        $("#{{$select2}}").val(null)
    })

    let mentionselect = $("#{{$select2}}").select2({
        ajax: {
            url: "{{base_web()}}searchUser",
            dataType: 'json',
            type: 'get',
            delay: 250,
            data: function (params) {
                var query = {
                    q: (params.term == undefined) ? '' : params.term,
                }
                return query;
            },
            processResults: function (data, params) {

                return {
                    results: data
                };

            },
            cache: true
        },
        placeholder: 'search users',
        minimumInputLength: 3,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection,
        language: {
            noResults: function () {
                return $(`<b>no user</b>`)
            },
            maximumSelected: function () {
                return $(`<b>You cannot select more than 4 items.</b>`)
            },
            inputTooShort: function (args) {
                return $(`<b>At least 3 characters are required to search.</b>`);
            }
        },
        closeOnSelect: false,
        maximumSelectionLength: 4

    });

</script>
