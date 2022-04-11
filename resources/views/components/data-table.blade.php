<div>
    <h1>
        {{ isset(${'field_'.'active'}) ? 'ok' : 'no' }}
    </h1>
    <table class="table table-hover table-bordered" id="dataTable">
        <thead>
            <tr>
                @foreach($columns as $column)
                    <th>{{ $column['title'] }}</th>
                @endforeach
            </tr>
        </thead>
    </table>
</div>
<script>
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ $url }}"
        },
        "language": {
            "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
        },
        columns: [
                @foreach ($columns as $item)
                @if( !isset(${'field_'.$item['name']}))
            {
                data: "{{ $item['name'] }}", name: "{{ $item['name'] }}"
            },
                @else
            {
                data: "{{ $item['name'] }}", name: "{{ $item['name'] }}", render: function () {
                    return "{{ ${'field_'.$item['name']} }}";
                }
            },
            @endif

            @endforeach
        ],
        order: [0, 'desc'],
        pageLength: 10
    });

</script>
