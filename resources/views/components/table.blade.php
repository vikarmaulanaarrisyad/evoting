<div class="table-responsive text-nowrap">
    <table id="table" {{ $attributes->merge(['class' => 'table table-striped dt-responsive nowrap mt-1 hover']) }}
        cellspacing="0" width="100%">
        @isset($thead)
            <thead>
                {{ $thead }}
            </thead>
        @endisset

        <tbody>
            {{ $slot }}
        </tbody>

        @isset($tfoot)
            <tfoot>
                {{ $tfoot }}
            </tfoot>
        @endisset
    </table>
</div>
