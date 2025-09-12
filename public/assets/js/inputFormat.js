
var cleave = new Cleave('.input-element', {
    blocks: [4, 4, 4, 4],
    uppercase: true
});

var cleave1 = new Cleave('.input-element1', {
    blocks: [4, 3, 4],
    uppercase: true
});

var cleave2 = new Cleave('.input-element2', {
    date: true,
    delimiter: '/',
    datePattern: ['Y', 'm', 'd']
});

var cleave3 = new Cleave('.input-element3', {
    time: true,
    timePattern: ['h', 'm','s']
});


var cleave4 = new Cleave('.input-element4', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand'
});

var cleave5 = new Cleave('.input-element5', {
    blocks: [4, 3, 3, 4],
    uppercase: true
});

var cleave6 = new Cleave('.input-element6', {
    delimiter: '·',
    blocks: [3, 3, 3],
    uppercase: true
});

var cleave7 = new Cleave('.input-element7', {
    prefix: '+98',
    delimiter: ' ',
    blocks: [3, 3, 3,4],
    uppercase: true
});