
noUiSlider.create(document.getElementById('slider1'), {
    start: [4000],
    connect: [true, false],
    range: {
        'min': [2000],
        'max': [10000]
    }
});
noUiSlider.create(document.getElementById('slider2'), {
    start: [4000,8000],
    connect: [false, true,false],
    range: {
        'min': [2000],
        'max': [10000]
    }
});
noUiSlider.create(document.getElementById('slider3'), {
    start: [4000,6000,8000],
    connect: [false, true,true,false],

    range: {
        'min': [2000],
        'max': [10000]
    }
});
noUiSlider.create(document.getElementById('slider4'), {
    start: [4000],
    step: 1000,
    connect: [false, true],

    range: {
        'min': [2000],
        'max': [10000]
    }
});

noUiSlider.create(document.getElementById('slider5'), {
    start: [4000,8000],
    connect: [false, true,false],
    behaviour: 'drag',
    range: {
        'min': [2000],
        'max': [10000]
    }
});
noUiSlider.create(document.getElementById('slider6'), {
    start: [5000,7000],
    connect: [false, true,false],
    behaviour: "drag-fixed",
    range: {
        'min': [2000],
        'max': [10000]
    }
});