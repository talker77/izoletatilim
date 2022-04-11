<!DOCTYPE html>
<html>
<head>
    <title>Laravel Pagination using Ajax</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        .box {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<br/>
<div class="container">
    <h3 align="center">Laravel Pagination using Ajax</h3><br/>
    <div id="table_data">
        @include('site.service.partials.pagination_data')

        {!! $data->links() !!}
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function () {

        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page) {
            $.ajax({
                url: "villa-filter?page=" + page,
                success: function (data) {
                    $('#table_data').html(data);
                }
            });
        }

    });
</script>
