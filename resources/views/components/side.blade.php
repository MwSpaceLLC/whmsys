<div class="col-md-2">
    <ul class="side-menu">
        <li><a href="/home">@lang('dashboard')</a></li>
        <li><a href="/clients">@lang('clients')</a></li>
        <li><a href="/invoices">@lang('invoices')</a></li>
        <li><a href="/tickets">@lang('tickets')</a></li>
        <li><a href="/settings">@lang('settings')</a></li>
        <li><a href="/export">@lang('export')</a></li>
    </ul>
</div>

<script type="application/javascript">

    const menuselector = document
        .querySelector('[href="/{{basename(URL::current())}}"]');

    if (menuselector) {
        menuselector.parentElement
            .classList
            .add('active')
    }
</script>
