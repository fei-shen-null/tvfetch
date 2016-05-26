$(document).ready(function () {
    var step1 = {
        element:$('.tvList .panel-title:first>a:first'),
        content:'Click on title to show TV details'
    };
    var step2 = {
        content:'2'
    };
    var step3 = {
        content:'3'
    };

    new Tour({
        name: 'tourDemo',
        steps: [step1,step2,step3]
    })
        .init()
        .start(true);
});
