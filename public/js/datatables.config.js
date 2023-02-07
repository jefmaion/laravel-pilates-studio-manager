var config = {
    order: [],
    pageLength: 10,
    lengthMenu: [
        [5,10, 25, 50, -1],
        [5,10, 25, 50, 'Tudo'],
    ],
    columnDefs: [
        { className: "align-middle", targets: "_all" },
    ],
    deferRender:true,
    processing:true,
    responsive:true,
    pagingType: $(window).width() < 768 ? 'simple' : 'simple_numbers',
    language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json'
    },
}

