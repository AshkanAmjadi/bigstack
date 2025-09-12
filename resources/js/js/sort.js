new Sortable(document.getElementById('sort-1'), {
    animation: 150,
    swapThreshold: 0.63,
    ghostClass: 'blue-background-class'
});


new Sortable(document.getElementById('sort-2'), {
    group: {
        name: 'shared1',
    },
    animation: 150
});

new Sortable(document.getElementById('sort-3'), {
    group: {
        name: 'shared1',
    },
    animation: 150
});
new Sortable(document.getElementById('sort-4'), {
    group: {
        name: 'shared2',
    },
    animation: 150
});
new Sortable(document.getElementById('sort-5'), {
    group: {
        name: 'shared2',
    },
    animation: 150
});
new Sortable(document.getElementById('sort-6'), {
    handle: '.icon',
    group: {
        name: 'shared3',
    },
    animation: 150
});
new Sortable(document.getElementById('sort-7'), {
    handle: '.icon',
    group: {
        name: 'shared3',
    },
    animation: 150
});