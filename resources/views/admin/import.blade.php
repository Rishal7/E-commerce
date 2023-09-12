<x-layout>

    <x-setting heading="Import Data">

        <form method="POST" action="/admin/import" enctype="multipart/form-data">

            @csrf

            <x-form.input name="csv" type="file" />

            <x-form.button onclick="load()">Import</x-form.button>

        </form>


        <div id="progress">

        </div>


    </x-setting>

    <script>
        function load() {
            $.ajax({
                url: '/admin/import-progress',
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    $('#progress').html(response);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        setInterval(load, 300);
    </script>
</x-layout>
